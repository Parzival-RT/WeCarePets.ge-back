<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('results_helped', 0);
        Setting::set('results_healed', 0);
        Setting::set('results_members', 0);
        Setting::set('results_spent', 0);
        Setting::set('results_coming_soon', true);
    }
}
