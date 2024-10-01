<?php

namespace App\Repositories\Project;

use App\Exceptions\NotFoundProjectException;
use App\Models\Projeto;
use Illuminate\Database\Eloquent\Model;

interface ProjectRepositoryContract
{
    /**
    * @param  array $data
    * @return Model
    */
    public function create(array $data);

    public function getAll(array $filters);

    public function get(int $id): ?Projeto;

    /**
     * @throws NotFoundProjectException
     */
    public function update(array $data, int $id): Projeto;

    /**
    * @param int $id
    * @return Model
    */
    public function delete(int $id);
}
