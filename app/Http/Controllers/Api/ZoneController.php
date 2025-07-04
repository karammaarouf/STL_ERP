<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseZone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 5;

        $zones = WarehouseZone::with('warehouse')
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->paginate($perPage, ['*'], 'page', $page);
            
        return response()->json($zones);
    }

    public function getZonesByWarehouse($warehouseId)
    {
        try {
            $zones = WarehouseZone::where('warehouse_id', $warehouseId)
                ->orderBy('name')
                ->get();
            
            return response()->json($zones);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch zones'], 500);
        }
    }
}