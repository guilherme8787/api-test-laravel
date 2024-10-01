<?php

namespace App\Services\Project;

use App\Exceptions\NotFoundInstallTypeException;
use App\Exceptions\NotFoundLocaleException;
use App\Exceptions\NotFoundProjectException;
use App\Models\Localizacao;
use App\Models\Projeto;
use App\Models\TipoInstalacao;
use App\Repositories\Localization\LocalizationRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\TipoInstalacao\TipoInstalacaoRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private ProjectRepositoryContract $projectRepository,
        private LocalizationRepositoryContract $localizationRepository,
        private TipoInstalacaoRepositoryContract $tipoInstalacaoRepository
    ) {}

    private function getLocalization(string $uf): ?Localizacao
    {
        return $this->localizationRepository->findBy('uf', $uf);
    }

    private function getInstallType(string $uf): ?TipoInstalacao
    {
        return $this->tipoInstalacaoRepository->findBy('nome', $uf);
    }

    private function safeSaveProject(array $data): ?Projeto
    {
        DB::beginTransaction();
        try {
            $customer = $this->projectRepository->create($data);

            DB::commit();

            return $customer;
        } catch (Throwable|Exception $exception) {
            Log::error("message: {$exception->getMessage()}", [
                'exception' => $exception
            ]);

            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?Projeto
    {
        $localization = $this->getLocalization(
            data_get($data, 'uf')
        );

        if (!$localization?->id) {
            throw new NotFoundLocaleException('Localização não encontrada.');
        }

        $installType = $this->getInstallType(
            data_get($data, 'tipo_instalacao')
        );

        if (!$installType?->id) {
            throw new NotFoundInstallTypeException(
                'Tipo de instalação não encontrado.'
            );
        }

        data_set($data, 'localizacao_id', $localization->id);
        data_set($data, 'tipo_instalacao_id', $installType->id);

        return $this->safeSaveProject($data);
    }

    public function getAll(array $filters): LengthAwarePaginator
    {
        return $this->projectRepository->getAll($filters);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?Projeto
    {
        $project =  $this->projectRepository->get($id);

        if (!$project) {
            throw new NotFoundProjectException('Projeto não encontrado.');
        }

        return $project;
    }
}
