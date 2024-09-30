<?php

namespace App\Services\Project\Contracts;

use App\Models\Projeto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectServiceContract
{
    public function create(array $data): ?Projeto;

    public function getAll(array $filters): LengthAwarePaginator;
}
