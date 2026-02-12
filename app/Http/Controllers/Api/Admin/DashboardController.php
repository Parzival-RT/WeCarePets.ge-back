<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Person;
use App\Models\Story;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'pending_companies' => Company::where('status', 'pending')->count(),
            'active_companies' => Company::active()->count(),
            'total_stories' => Story::count(),
            'total_people' => Person::active()->count(),
        ]);
    }
}
