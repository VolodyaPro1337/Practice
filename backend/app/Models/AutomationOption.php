<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AutomationOption extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'subtitle',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function configurations(): BelongsToMany
    {
        return $this->belongsToMany(Configuration::class, 'configuration_automation')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }
}
