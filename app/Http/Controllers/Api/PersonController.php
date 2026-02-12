<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PersonController extends Controller
{
    /**
     * GET /api/people - ყველა ადამიანი (paginated)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $people = Person::active()->paginate(12);
        return PersonResource::collection($people);
    }

    /**
     * GET /api/people/{id} - ადამიანის დეტალი
     */
    public function show(Person $person): PersonResource
    {
        $person->load('stories');
        return new PersonResource($person);
    }
}
