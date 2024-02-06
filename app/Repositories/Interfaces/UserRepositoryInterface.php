<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function register($user);
    public function login($value,$data);
    public function logout();
}
