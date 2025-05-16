<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Post $this */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'view_count' => $this->view_count,
            'user' => UserResource::make($this->user),
        ];
    }
}
