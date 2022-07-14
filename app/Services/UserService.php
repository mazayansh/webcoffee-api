<?php

namespace App\Services;

use App\Interfaces\{
    UserRepositoryInterface,
    CustomerRepositoryInterface,
    UserServiceInterface
};
use App\Http\Requests\{
    RegisterRequest,
    LoginRequest
};

class UserService implements UserServiceInterface
{
    public function __construct(public UserRepositoryInterface $userRepository, public CustomerRepositoryInterface $customerRepository)
    {

    }

    public function register(array $requestData)
    {
        $customer = $this->customerRepository->save([
            'first_name' => $requestData['first_name'],
            'last_name' => $requestData['last_name'],
            'email' => $requestData['email']
        ]);

        return $this->userRepository->save(
            array_merge(
                $requestData,
                [
                    'customer_id' => $customer->id,
                    'password' => bcrypt($requestData['password'])
                ]
            )
        );
    }

    public function login(array $requestData)
    {
        $isUserExists = $this->userRepository->isExists('email', $requestData['email']);

        if (! $isUserExists) {
            return response()->json(['error' => 'Email has not registered'], 404);
        }

        if (! $token = auth()->attempt($requestData)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return $this->createNewToken($token);
    }

    public function refreshToken()
    {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}