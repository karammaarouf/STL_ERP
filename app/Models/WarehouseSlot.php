<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'rack_id',
        'max_weight',
        'max_volume',
        'current_weight',
        'current_volume'
    ];

    protected $casts = [
        'max_weight' => 'decimal:2',
        'max_volume' => 'decimal:2',
        'current_weight' => 'decimal:2',
        'current_volume' => 'decimal:2',
    ];

    public function rack()
    {
        return $this->belongsTo(WarehouseRack::class, 'rack_id');
    }
}
