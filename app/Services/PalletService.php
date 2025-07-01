<?php

namespace App\Services;

use App\Models\Pallet;
use Illuminate\Pagination\LengthAwarePaginator;

class PalletService
{
    public function getAllPallets(): LengthAwarePaginator
    {
        return Pallet::with('warehouse')
            ->latest()
            ->paginate(10);
    }

    public function createPallet(array $data): Pallet
    {
        return Pallet::create($data);
    }

    public function updatePallet(Pallet $pallet, array $data): bool
    {
        return $pallet->update($data);
    }

    public function deletePallet(Pallet $pallet): bool
    {
        return $pallet->delete();
    }
}