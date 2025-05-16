<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadProfileImageRequest;
use App\Http\Resources\UserResource;
use App\Services\User\Contracts\UploadProfileImageInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class UploadProfileImageController extends Controller
{
    public function __construct(private readonly UploadProfileImageInterface $uploadProfileImage)
    {
    }

    public function __invoke(UploadProfileImageRequest $request): JsonResponse
    {
        try {
            $user = $this->uploadProfileImage->upload(auth()->id(), $request->file('image'));
        } catch (Exception $exception) {

            return $this->error($exception->getMessage(), 404);
        }

        return $this->success(UserResource::make($user));
    }
}
