<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * GET - ყველა ისტორია
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Story::with(['companies', 'people']);

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

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $stories = $query->paginate(12);
        return StoryResource::collection($stories);
    }

    /**
     * GET - სტატისტიკა
     */
    public function statistics(): JsonResponse
    {
        return response()->json([
            'data' => [
                'helped' => Story::where('category', 'helped')->count(),
                'healed' => Story::where('category', 'healed')->count(),
                'total_spent' => Story::sum('amount_spent') ?? 0,
            ]
        ]);
    }

    /**
     * POST - ისტორიის შექმნა
     */
    public function store(StoreStoryRequest $request): StoryResource
    {
        $story = Story::create([
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'cover_image' => $request->file('cover_image')->store('stories', 'public'),
            'video_url' => $request->video_url,
            'description' => [
                'ka' => $request->description_ka,
                'en' => $request->description_en,
            ],
            'category' => $request->category,
            'amount_spent' => $request->amount_spent,
            'status' => $request->status,
        ]);

        // გმირების მიბმა (multi-select)
        if ($request->company_ids) {
            $story->companies()->attach($request->company_ids);
        }
        if ($request->person_ids) {
            $story->people()->attach($request->person_ids);
        }

        return new StoryResource($story->load(['companies', 'people']));
    }

    /**
     * GET - ერთი ისტორია
     */
    public function show(Story $story): StoryResource
    {
        return new StoryResource($story->load(['companies', 'people']));
    }

    /**
     * PUT - ისტორიის განახლება
     */
    public function update(UpdateStoryRequest $request, Story $story): StoryResource
    {
        $data = [
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'video_url' => $request->video_url,
            'description' => [
                'ka' => $request->description_ka,
                'en' => $request->description_en,
            ],
            'category' => $request->category,
            'amount_spent' => $request->amount_spent,
            'status' => $request->status,
        ];

        if ($request->hasFile('cover_image')) {
            // ძველი სურათის წაშლა
            if ($story->cover_image) {
                Storage::disk('public')->delete($story->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('stories', 'public');
        }

        $story->update($data);

        // გმირების განახლება (sync - წაშლის ძველებს, დაამატებს ახლებს)
        $story->companies()->sync($request->company_ids ?? []);
        $story->people()->sync($request->person_ids ?? []);

        return new StoryResource($story->load(['companies', 'people']));
    }

    /**
     * DELETE - ისტორიის წაშლა
     */
    public function destroy(Story $story): JsonResponse
    {
        // სურათის წაშლა
        if ($story->cover_image) {
            Storage::disk('public')->delete($story->cover_image);
        }

        $story->companies()->detach();
        $story->people()->detach();
        $story->delete();
        return response()->json(null, 204);
    }
}
