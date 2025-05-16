<?php

namespace App\Services\Auth;


use App\Services\Auth\Exceptions\LoginException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class LoginService
{
    public function __construct(private readonly AuthFactory $auth)
    {
    }

    /**
     * @throws LoginException
     */
    public function login(string $mobile, string $password): string
    {
        $token = $this->auth
            ->guard('api')
            ->attempt(['mobile' => $mobile, 'password' => $password]);

        if (!$token) {
            throw LoginException::whenMobileOrPasswordIsWrong();
        }

        return $token;
    }

}
