<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'city_id',
        'type',
        'total_capacity_weight',
        'total_capacity_volume',
    ];

    /**
     * Get the city where the warehouse is located.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function zones()
    {
        return $this->hasMany(WarehouseZone::class);
    }

    /**
     * Get the pallets in this warehouse.
     */
    public function pallets()
    {
        return $this->hasMany(Pallet::class);
    }
}
