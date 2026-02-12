<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'package',
        'status',
        'group',
        'detail_page_enabled',
        'description',
        'logo',
    ];

    protected $casts = [
        'detail_page_enabled' => 'boolean',
    ];

    /**
     * Get stories associated with this company.
     */
    public function stories(): MorphToMany
    {
        return $this->morphToMany(Story::class, 'heroable', 'story_heroes');
    }

    /**
     * Scope: Active companies only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Founders Club companies.
     */
    public function scopeFoundersClub($query)
    {
        return $query->where('group', 'founders_club');
    }

    /**
     * Scope: Heroes Companies.
     */
    public function scopeHeroesCompanies($query)
    {
        return $query->whereIn('group', ['heroes_companies', 'founders_club']);
    }

    /**
     * Scope: Companies with detail page enabled.
     */
    public function scopeWithDetailPage($query)
    {
        return $query->where('detail_page_enabled', true);
    }
}
