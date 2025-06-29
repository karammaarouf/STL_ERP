<?php

namespace App\Services;

use App\Models\WarehouseSlot;
use Illuminate\Pagination\LengthAwarePaginator;

class WarehouseSlotService
{
    public function getAllSlots(): LengthAwarePaginator
    {
        return WarehouseSlot::with(['rack.section.zone.warehouse'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function createSlot(array $data): WarehouseSlot
    {
        return WarehouseSlot::create($data);
    }

    public function updateSlot(WarehouseSlot $slot, array $data): bool
    {
        return $slot->update($data);
    }

    public function deleteSlot(WarehouseSlot $slot): bool
    {
        return $slot->delete();
    }
}