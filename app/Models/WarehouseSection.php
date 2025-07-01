<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'zone_id',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(WarehouseZone::class, 'zone_id');
    }

    public function racks()
    {
        return $this->hasMany(WarehouseRack::class, 'section_id');
    }
}