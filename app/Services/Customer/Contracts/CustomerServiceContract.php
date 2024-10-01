<?php

namespace App\Services\Customer\Contracts;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

interface CustomerServiceContract
{
    public function all(): Collection;

    /**
     * @throws NotFoundCustomerException
     */
    public function create(array $data): ?Cliente;

    public function find(int $id): ?Cliente;

    public function update(array $data, int $id): ?Cliente;

    public function delete(int $id): ?Cliente;
}
