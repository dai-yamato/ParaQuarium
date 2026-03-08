<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaterRecord extends Model
{
    protected $fillable = [
        'tank_id',
        'measured_at',
        'notes',
    ];

    protected $casts = [
        'measured_at' => 'datetime',
    ];

    public function tank(): BelongsTo
    {
        return $this->belongsTo(Tank::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(WaterRecordValue::class);
    }
}
