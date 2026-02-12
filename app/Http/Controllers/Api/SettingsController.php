<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    /**
     * GET /api/settings/results - KPI რიცხვები
     */
    public function results(): JsonResponse
    {
        return response()->json([
            'helped' => Setting::get('results_helped', 0),
            'healed' => Setting::get('results_healed', 0),
            'members' => Setting::get('results_members', 0),
            'spent' => Setting::get('results_spent', 0),
            'coming_soon' => Setting::get('results_coming_soon', true),
        ]);
    }
}
