<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterRecordValue extends Model
{
    protected $fillable = [
        'water_record_id',
        'parameter_type_id',
        'value',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(WaterRecord::class, 'water_record_id');
    }

    public function parameterType(): BelongsTo
    {
        return $this->belongsTo(ParameterType::class);
    }
}
