<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Configuration extends Model
{
    protected $fillable = [
        'profile_id',
        'width_mm',
        'height_mm',
        'material_id',
        'session_token',
    ];

    protected $casts = [
        'width_mm' => 'integer',
        'height_mm' => 'integer',
        'profile_id' => 'integer',
        'material_id' => 'integer',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function automationOptions(): BelongsToMany
    {
        return $this->belongsToMany(AutomationOption::class, 'configuration_automation')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
