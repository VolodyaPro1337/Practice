<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'max_span_mm',
        'tags',
        'is_best_seller',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_best_seller' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'max_span_mm' => 'integer',
    ];

    public function configurations(): HasMany
    {
        return $this->hasMany(Configuration::class);
    }
}
