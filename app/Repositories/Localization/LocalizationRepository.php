<?php

namespace App\Repositories\Localization;

use App\Models\Localizacao;
use App\Repositories\BaseRepository;

class LocalizationRepository extends BaseRepository implements LocalizationRepositoryContract
{
    public function __construct(Localizacao $model)
    {
        parent::__construct($model);
    }
}
