<?php

namespace App\Repositories\Localization;

use Illuminate\Database\Eloquent\Model;

interface LocalizationRepositoryContract
{
    /**
    * @param  string  $column
    * @param  string  $value
    * @return Model
    */
    public function findBy(string $column, string $value);
}
