<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UploadProfileImageInterface
{
    public function upload(int $userId,UploadedFile $image): User;
}
