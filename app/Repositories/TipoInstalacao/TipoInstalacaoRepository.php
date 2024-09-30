<?php

namespace App\Repositories\TipoInstalacao;

use App\Models\TipoInstalacao;
use App\Repositories\BaseRepository;

class TipoInstalacaoRepository extends BaseRepository implements TipoInstalacaoRepositoryContract
{
    public function __construct(TipoInstalacao $model)
    {
        parent::__construct($model);
    }
}
