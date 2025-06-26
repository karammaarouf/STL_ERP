<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseService
{
    /**
     * Get all warehouses with pagination and related data.
     */
    public function getAllWarehouses()
    {
        return Warehouse::with('city.state.country')->latest()->paginate(10);
    }

    /**
     * Create a new warehouse.
     */
    public function createWarehouse(array $data): Warehouse
    {
        return Warehouse::create($data);
    }

    /**
     * Update an existing warehouse.
     */
    public function updateWarehouse(Warehouse $warehouse, array $data): bool
    {
        return $warehouse->update($data);
    }

    /**
     * Delete a warehouse.
     */
    public function deleteWarehouse(Warehouse $warehouse): ?bool
    {
        return $warehouse->delete();
    }
}
