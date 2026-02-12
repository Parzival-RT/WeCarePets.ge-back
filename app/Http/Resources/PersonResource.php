<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isAdmin = $request->user()?->hasAnyRole(['admin', 'moderator']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'full_name' => $this->name . ' ' . $this->surname,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'stories_count' => $this->when($this->relationLoaded('stories'), fn() => $this->stories->count()),
            'stories' => StoryResource::collection($this->whenLoaded('stories')),
            'status' => $this->when($isAdmin, $this->status),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
