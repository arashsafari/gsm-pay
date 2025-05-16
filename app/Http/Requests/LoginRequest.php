<?php

namespace App\Http\Requests;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required','string','exists:users,mobile', new MobileRule()],
            'password' => ['required','string'],
        ];
    }
}
