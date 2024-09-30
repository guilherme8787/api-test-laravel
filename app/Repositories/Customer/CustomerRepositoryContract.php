<?php

namespace App\Repositories\Customer;

use Illuminate\Database\Eloquent\Model;

interface CustomerRepositoryContract
{
    /**
    * @return Collection
    */
    public function all();

    /**
    * @param array $data
    * @return Model
    */
    public function create(array $data);

    /**
    * @param array $data
    * @param int $id
    * @return Model
    */
    public function update(array $data, int $id);

    /**
    * @param int $id
    * @return Model
    */
    public function delete(int $id);

    /**
    * @param int $id
    * @return Model
    */
    public function find(int $id);
}
