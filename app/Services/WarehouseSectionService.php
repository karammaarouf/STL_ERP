<?php

namespace App\Services;

use App\Models\WarehouseSection;

class WarehouseSectionService
{
    /**
     * Get all warehouse sections with pagination
     */
    public function getAllWarehouseSections()
    {
        return WarehouseSection::with('zone.warehouse')->latest()->paginate(10);
    }

    /**
     * Create a new warehouse section
     */
    public function createWarehouseSection(array $data): WarehouseSection
    {
        return WarehouseSection::create($data);
    }

    /**
     * Update warehouse section
     */
    public function updateWarehouseSection(WarehouseSection $warehouseSection, array $data): bool
    {
        return $warehouseSection->update($data);
    }

    /**
     * Delete warehouse section
     */
    public function deleteWarehouseSection(WarehouseSection $warehouseSection): ?bool
    {
        return $warehouseSection->delete();
    }
}