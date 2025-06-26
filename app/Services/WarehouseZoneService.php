<?php

namespace App\Services;

use App\Models\WarehouseZone;

class WarehouseZoneService
{
    /**
     * Get all warehouse zones with pagination.
     */
    public function getAllWarehouseZones()
    {
        return WarehouseZone::with('warehouse')->latest()->paginate(10);
    }

    /**
     * Create a new warehouse zone.
     */
    public function createWarehouseZone(array $data): WarehouseZone
    {
        return WarehouseZone::create($data);
    }

    /**
     * Update an existing warehouse zone.
     */
    public function updateWarehouseZone(WarehouseZone $warehouseZone, array $data): bool
    {
        return $warehouseZone->update($data);
    }

    /**
     * Delete a warehouse zone.
     */
    public function deleteWarehouseZone(WarehouseZone $warehouseZone): ?bool
    {
        return $warehouseZone->delete();
    }
}
