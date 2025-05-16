<?php

namespace App\Services\Auth\Contracts;

interface LoginInterface
{
    public function login($mobile, $password);
}
