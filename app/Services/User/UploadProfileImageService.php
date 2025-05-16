<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\User\Contracts\UploadProfileImageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Config\Repository as Config;

class UploadProfileImageService implements UploadProfileImageInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Config                  $config,
    )
    {
    }

    public function upload(int $userId, UploadedFile $image): User
    {
        $user = $this->userRepository->findOrFail($userId);

        $user->addMedia($image)
            ->toMediaCollection('profile_image', $this->config->get('filesystems.default'));

        return $user;
    }
}
