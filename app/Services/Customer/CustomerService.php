<?php

namespace App\Services\Customer;

use App\Exceptions\NotFoundCustomerException;
use App\Repositories\Customer\CustomerRepositoryContract;
use App\Services\Customer\Contracts\CustomerServiceContract;

class CustomerService implements CustomerServiceContract
{
    public function __construct(
        private CustomerRepositoryContract $customerRepository
    ) {}

    public function all()
    {
        return $this->customerRepository->all();
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function find(int $id)
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw new NotFoundCustomerException('Cliente não encontrado.');
        }

        return $customer;
    }

    public function update(array $data, int $id)
    {
        return $this->customerRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->customerRepository->delete($id);
    }
}
