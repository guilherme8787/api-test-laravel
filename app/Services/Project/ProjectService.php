<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private ProjectRepositoryContract $contaRepository
    ) {}
}
