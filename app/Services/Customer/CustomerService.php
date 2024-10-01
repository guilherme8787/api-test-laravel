<?php

namespace App\Services\Customer;

use App\Exceptions\NotFoundCustomerException;
use App\Models\Cliente;
use App\Repositories\Customer\CustomerRepositoryContract;
use App\Services\Customer\Contracts\CustomerServiceContract;
use Illuminate\Database\Eloquent\Collection;

class CustomerService implements CustomerServiceContract
{
    public function __construct(
        private CustomerRepositoryContract $customerRepository
    ) {}

    public function all(): Collection
    {
        return $this->customerRepository->all();
    }

    public function create(array $data): ?Cliente
    {
        return $this->customerRepository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Cliente
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw new NotFoundCustomerException('Cliente não encontrado.');
        }

        return $customer;
    }

    public function update(array $data, int $id): ?Cliente
    {
        return $this->customerRepository->update($data, $id);
    }

    public function delete(int $id): ?Cliente
    {
        return $this->customerRepository->delete($id);
    }
}
