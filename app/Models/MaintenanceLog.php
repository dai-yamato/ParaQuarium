<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_id',
        'action',
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
