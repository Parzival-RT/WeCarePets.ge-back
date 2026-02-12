<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Story extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'cover_image',
        'video_url',
        'description',
        'category',
        'amount_spent',
        'status',
    ];

    /**
     * Get companies associated with this story.
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'heroable', 'story_heroes');
    }

    /**
     * Get people associated with this story.
     */
    public function people(): MorphToMany
    {
        return $this->morphedByMany(Person::class, 'heroable', 'story_heroes');
    }

    /**
     * Get all heroes (companies + people) as accessor.
     */
    public function getHeroesAttribute(): array
    {
        return [
            'companies' => $this->companies,
            'people' => $this->people,
        ];
    }

    /**
     * Default ordering: newest first.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
