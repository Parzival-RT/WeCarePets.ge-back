<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoryController extends Controller
{
    /**
     * GET /api/stories - ყველა ისტორია (paginated)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Story::where('status', 'active')
            ->with(['companies', 'people']);

        // Filter by hero
        if ($request->heroable_type && $request->heroable_id) {
            $relation = $request->heroable_type === 'company' ? 'companies' : 'people';
            $query->whereHas($relation, function ($q) use ($request) {
                $q->where('heroable_id', $request->heroable_id);
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // // Filter by status
        // if ($request->has('status')) {
        //     $query->where('status', $request->status);
        // }

        $stories = $query->paginate(12);
        return StoryResource::collection($stories);
    }

    /**
     * GET /api/stories/{id} - ერთი ისტორია
     */
    public function show(Story $story): StoryResource
    {
        $story->load(['companies', 'people']);
        return new StoryResource($story);
    }
}
