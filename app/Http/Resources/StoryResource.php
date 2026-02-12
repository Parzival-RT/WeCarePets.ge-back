<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'category' => $this->category,
            'amount_spent' => $this->amount_spent,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'video_url' => $this->video_url,
            'description' => $this->description,
            'heroes' => [
                'companies' => CompanyResource::collection($this->whenLoaded('companies')),
                'people' => PersonResource::collection($this->whenLoaded('people')),
            ],
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
