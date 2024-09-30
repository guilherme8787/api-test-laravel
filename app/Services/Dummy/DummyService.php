<?php

namespace App\Services\Dummy;

use App\Repositories\Dummy\DummyRepositoryContract;
use App\Services\Dummy\Contracts\DummyServiceContract;

class DummyService implements DummyServiceContract
{
    public function __construct(
        private DummyRepositoryContract $contaRepository
    ) {}
}
