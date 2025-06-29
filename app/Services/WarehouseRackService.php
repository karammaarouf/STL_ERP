<?php

namespace App\Services;

use App\Models\WarehouseRack;
use Illuminate\Pagination\LengthAwarePaginator;

class WarehouseRackService
{
    public function getAllRacks(): LengthAwarePaginator
    {
        return WarehouseRack::with(['section.zone.warehouse'])->paginate(10);
    }

    public function createRack(array $data): WarehouseRack
    {
        return WarehouseRack::create($data);
    }

    public function updateRack(WarehouseRack $rack, array $data): bool
    {
        return $rack->update($data);
    }

    public function deleteRack(WarehouseRack $rack): bool
    {
        return $rack->delete();
    }
}