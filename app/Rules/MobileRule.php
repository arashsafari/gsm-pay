<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobileRule implements ValidationRule
{
    public const REGEX = '/(0)9\d\d{8}/';

    public static function make(): static
    {
        return new static();
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::REGEX, (string) $value)) {
            $fail(__('validation.custom.mobile'));
        }
    }
}
