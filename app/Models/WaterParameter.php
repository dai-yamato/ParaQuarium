<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_id',
        'ph',
        'temperature',
        'nitrite',
        'gh',
        'measured_at',
    ];

    protected $casts = [
        'measured_at' => 'datetime',
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
