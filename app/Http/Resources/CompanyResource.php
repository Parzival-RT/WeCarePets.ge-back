<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isAdmin = $request->user()?->hasAnyRole(['admin', 'moderator']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'detail_page_enabled' => $this->detail_page_enabled,
            'description' => $this->when($this->detail_page_enabled, $this->description),
            'stories_count' => $this->when($this->relationLoaded('stories'), fn() => $this->stories->count()),
            // Admin only fields
            'contact_person' => $this->when($isAdmin, $this->contact_person),
            'phone' => $this->when($isAdmin, $this->phone),
            'package' => $this->when($isAdmin, $this->package),
            'status' => $this->when($isAdmin, $this->status),
            'stories' => StoryResource::collection($this->whenLoaded('stories')),
            'group' => $this->when($isAdmin, $this->group),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
