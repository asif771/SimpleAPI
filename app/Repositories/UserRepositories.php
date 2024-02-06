<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserRepositories implements UserRepositoryInterface
{
    public function register($user)
    {
        try {
            DB::beginTransaction();
            $user = User::create($user);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error in User Repository registration: ' . $e->getMessage());
        }
    }

    public function login($value,$data)
    {
        try {
            DB::beginTransaction();
            $user= User::where($value,$data)->first();
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error in User Repository Login: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            DB::beginTransaction();
            auth()->user()->tokens()->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new \Exception('Error fetching user profile: ' . $e->getMessage());
        }
    }

}
