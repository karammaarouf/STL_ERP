<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'warehouse_id',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function sections()
    {
        return $this->hasMany(WarehouseSection::class, 'zone_id');
    }
}
