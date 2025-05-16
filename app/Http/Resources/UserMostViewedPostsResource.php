<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMostViewedPostsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $this */

        return [
            'id' => $this->id,
            'mobile' => $this->mobile,
            'total_post_views' => $this->total_post_views,
            'profile_image' => $this->hasMedia('profile_image')
                ? MediaResource::make($this->getFirstMedia('profile_image'))
                : null,
        ];
    }
}
