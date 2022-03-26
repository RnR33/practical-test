<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Construct the repository.
     *
     * @param \App\Models\Student $model
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

}
