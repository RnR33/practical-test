<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function storeUser($request)
    {
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['password'] = bcrypt($request['password']);

        return $this->userRepository->create($data);
    }
}
