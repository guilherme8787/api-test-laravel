<?php

namespace App\Repositories\Customer;

use App\Models\Cliente;
use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryContract
{
    public function __construct(Cliente $model)
    {
        parent::__construct($model);
    }
}
