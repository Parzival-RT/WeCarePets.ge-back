<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Person extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name', 'surname'];

    protected $fillable = [
        'name',
        'surname',
        'image',
        'status',
    ];

    /**
     * Get stories associated with this person.
     */
    public function stories(): MorphToMany
    {
        return $this->morphToMany(Story::class, 'heroable', 'story_heroes');
    }

    /**
     * Scope: Active people only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
