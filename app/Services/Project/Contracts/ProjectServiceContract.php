<?php

namespace App\Services\Project\Contracts;

use App\Exceptions\NotFoundProjectException;
use App\Models\Projeto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectServiceContract
{
    /**
     * @throws NotFoundLocaleException
     * @throws NotFoundInstallTypeException
     */
    public function create(array $data): ?Projeto;

    public function getAll(array $filters): LengthAwarePaginator;

    /**
     * @throws NotFoundProjectException
     */
    public function get(int $id): ?Projeto;
}
