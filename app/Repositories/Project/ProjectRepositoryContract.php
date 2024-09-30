<?php

namespace App\Repositories\Project;

use Illuminate\Database\Eloquent\Model;

interface ProjectRepositoryContract
{
    /**
    * @param  array $data
    * @return Model
    */
    public function create(array $data);
}
