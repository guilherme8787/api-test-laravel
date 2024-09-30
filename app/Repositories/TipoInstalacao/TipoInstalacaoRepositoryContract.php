<?php

namespace App\Repositories\TipoInstalacao;

use Illuminate\Database\Eloquent\Model;

interface TipoInstalacaoRepositoryContract
{
    /**
    * @param  string  $column
    * @param  string  $value
    * @return Model
    */
    public function findBy(string $column, string $value);
}
