<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PersonController extends Controller
{
    /**
     * GET - ყველა ადამიანი
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $peopleQuery = Person::with('stories');

        $peopleQuery->when($request->name, function ($q) use ($request) {
            $q->where('name->ka', 'like', '%' . $request->name . '%')
                ->orWhere('name->en', 'like', '%' . $request->name . '%');
        });

        return PersonResource::collection($peopleQuery->latest()->paginate(15));
    }

    /**
     * POST - ადამიანის დამატება
     */
    public function store(StorePersonRequest $request): PersonResource
    {
        $person = Person::create([
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'surname' => [
                'ka' => $request->surname_ka,
                'en' => $request->surname_en ?? $request->surname_ka,
            ],
            'image' => $request->file('image')->store('people', 'public'),
            'status' => $request->status ?? 'active',
        ]);

        return new PersonResource($person);
    }

    /**
     * GET - ადამიანის დეტალი
     */
    public function show(Person $person): PersonResource
    {
        return new PersonResource($person->load('stories'));
    }

    /**
     * PUT - ადამიანის განახლება
     */
    public function update(UpdatePersonRequest $request, Person $person): PersonResource
    {
        $data = [
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'surname' => [
                'ka' => $request->surname_ka,
                'en' => $request->surname_en ?? $request->surname_ka,
            ],
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('people', 'public');
        }

        $person->update($data);
        return new PersonResource($person);
    }

    /**
     * DELETE - ადამიანის წაშლა
     */
    public function destroy(Person $person): JsonResponse
    {
        $person->stories()->detach();
        $person->delete();
        return response()->json(null, 204);
    }
}
