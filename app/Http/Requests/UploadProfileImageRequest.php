<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadProfileImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
