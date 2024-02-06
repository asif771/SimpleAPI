<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Register(StoreUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = $this->userRepository->register($validatedData);
            $token = $user->createToken('apiToken')->plainTextToken;
            $user->save();
            $res = ['message' => 'User Registered Successfully', 'user' => $user,'token' => $token,];
            return response($res, 200);
        } catch (ValidationException|Exception  $e) {
            return response()->json(['Failed to Registration user', $e->getMessage()], 500);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $this->userRepository->login('email', $validated['email']);
            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response(['message' => 'Incorrect Username or Password'], 401);
            }
            $token = $user->createToken('apiToken')->plainTextToken;
            $res = new UserResource($user);
            return response()->json(['message' => 'User Login Successfully', 'user' => $res, 'token' => $token,]);
        } catch (Exception $e) {
            return response()->json(['User login Failed', $e->getMessage()], 500);
        }
    }
        public function logout(): JsonResponse
        {
            $this->userRepository->logout();
            return response()->json(['message' => 'User Logout Successfully']);
        }
}
