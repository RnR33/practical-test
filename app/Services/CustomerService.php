<?php

namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Http\Resources\CustomerResource;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        $customers = $this->customerRepository->get();

        return CustomerResource::collection($customers);
    }

    public function storeCustomer($request)
    {
        $customer = $this->customerRepository->create($request);

        return new CustomerResource($customer);
    }

    public function showCustomer($customer)
    {
        $customer = $this->customerRepository->find($customer);

        return new CustomerResource($customer);
    }

    public function updateCustomer($id,$request)
    {
        $customer = $this->customerRepository->updateById($id,$request);

        return new CustomerResource($customer);
    }

    public function deleteCustomer($id)
    {

        return $this->customerRepository->deleteById($id);

    }
}
