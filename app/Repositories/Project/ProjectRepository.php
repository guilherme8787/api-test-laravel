<?php

namespace App\Repositories\Project;

use App\Models\Projeto;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectRepository extends BaseRepository implements ProjectRepositoryContract
{
    /**
     * @var int
     */
    private const PER_PAGE = 10;

    public function __construct(Projeto $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $projectToSave = [
            'cliente_id' => data_get($data, 'cliente_id'),
            'nome' => data_get($data, 'nome'),
            'localizacao_id' => data_get($data, 'localizacao_id'),
            'tipo_instalacao_id' => data_get($data, 'tipo_instalacao_id'),
        ];

        $project = $this->model->create($projectToSave);

        if (!empty($data['equipamentos'])) {
            foreach ($data['equipamentos'] as $equipment) {
                $project->equipamentos()->attach($equipment['equipamento_id'], ['quantidade' => $equipment['quantidade']]);
            }
        }

        return $project;
    }

    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = $this->model
            ->select('projetos.*')
            ->with(['cliente', 'equipamentos', 'localizacao', 'tipoInstalacao'])
            ->join('localizacaos', 'projetos.localizacao_id', '=', 'localizacaos.id')
            ->join('tipo_instalacaos', 'projetos.tipo_instalacao_id', '=', 'tipo_instalacaos.id');

        $clienteId = data_get($filters, 'cliente_id', false);
        if ($clienteId) {
            $query->where('cliente_id', $clienteId);
        }

        $uf = data_get($filters, 'uf', false);
        if ($uf) {
            $query->where('localizacaos.uf', $uf);
        }

        $tipoInstalacao = data_get($filters, 'tipo_instalacao', false);
        if ($tipoInstalacao) {
            $query->where('tipo_instalacaos.nome', 'LIKE', '%' . $tipoInstalacao . '%');
        }

        $nome = data_get($filters, 'nome', false);
        if ($nome) {
            $query->where('projetos.nome', 'LIKE', '%' . $nome . '%');
        }

        return $query->paginate(self::PER_PAGE);
    }
}
