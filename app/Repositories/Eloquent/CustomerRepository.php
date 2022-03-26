<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use File;

class CustomerRepository extends BaseRepository implements \App\Repositories\Contracts\CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

}
