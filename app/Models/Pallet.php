<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pallet extends Model
{
    /** @use HasFactory<\Database\Factories\PalletFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'barcode',
        'warehouse_id',
        'status',
        'current_weight',
        'current_volume',
    ];

    /**
     * Get the warehouse that owns the pallet.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the warehouse slots for this pallet.
     */
    public function warehouseSlots()
    {
        return $this->belongsToMany(WarehouseSlot::class, 'pallet_warehouse_slots')
            ->withTimestamps();
    }

    /**
     * Get the shipments for this pallet.
     */
    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'pallet_shipments')
            ->withTimestamps();
    }
}
