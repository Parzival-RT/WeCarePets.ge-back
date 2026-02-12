<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * GET - წამოიღე settings
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'results_helped' => Setting::get('results_helped', 0),
            'results_healed' => Setting::get('results_healed', 0),
            'results_members' => Setting::get('results_members', 0),
            'results_spent' => Setting::get('results_spent', 0),
            'results_coming_soon' => Setting::get('results_coming_soon', true),
        ]);
    }

    /**
     * PUT - განაახლე settings
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'helped' => 'required|integer|min:0',
            'healed' => 'required|integer|min:0',
            'members' => 'required|integer|min:0',
            'spent' => 'required|numeric|min:0',
            'coming_soon' => 'nullable|boolean',
        ]);

        Setting::set('results_helped', $request->helped);
        Setting::set('results_healed', $request->healed);
        Setting::set('results_members', $request->members);
        Setting::set('results_spent', $request->spent);
        Setting::set('results_coming_soon', $request->coming_soon);

        return response()->json(['success' => true]);
    }
}
