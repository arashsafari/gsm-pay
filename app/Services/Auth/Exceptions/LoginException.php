<?php

declare(strict_types=1);

namespace App\Services\Auth\Exceptions;

use Exception;

class LoginException extends Exception
{
    public static function whenMobileOrPasswordIsWrong(): self
    {
        return new static('mobile or password is wrong');
    }
}
