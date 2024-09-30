<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
    * @var Model
    */
    protected $model;

    /**
    * BaseRepository constructor
    */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
    * @return Model
    */
    public function getModel()
    {
        return $this->model;
    }

    /**
    * @param Model $model
    * @return BaseRepository
    */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
    * @return Collection
    */
    public function all()
    {
        return $this->model->all();
    }

    /**
    * @param array $data
    * @return Model
    */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
    * @param array $data
    * @param int $id
    * @return Model
    */
    public function update(array $data, int $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
    * @param int $id
    * @return Model
    */
    public function delete(int $id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }

    /**
    * @param int $id
    * @return Model
    */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
    * @param string $column
    * @param string $value
    * @return Model
    */
    public function findBy(string $column, string $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
    * @param string $column
    * @param string $value
    * @return Collection
    */
    public function findAllBy(string $column, string $value)
    {
        return $this->model->where($column, $value)->get();
    }

    /**
    * @param string $column
    * @param string $value
    * @return Collection
    */
    public function findAllByPaginate(string $column, string $value)
    {
        return $this->model->where($column, $value)->paginate();
    }
}
