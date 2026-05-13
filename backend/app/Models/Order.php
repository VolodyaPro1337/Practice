<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'configuration_id',
        'client_name',
        'client_phone',
        'status',
        'admin_note',
    ];

    protected $casts = [
        'configuration_id' => 'integer',
    ];

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }
}
