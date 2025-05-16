<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $this */

        return [
            'id' => $this->id,
            'mobile' => $this->mobile,
            'profile_image' => $this->hasMedia('profile_image')
                ? MediaResource::make($this->getFirstMedia('profile_image'))
                : null,
        ];
    }
}
