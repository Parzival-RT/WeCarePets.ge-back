<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'description' => $this->description,
            'stories' => StoryResource::collection($this->whenLoaded('stories')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
