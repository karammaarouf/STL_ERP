<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseSlot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = WarehouseSlot::with(['rack.section.zone.warehouse'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                          ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->orderBy('code');

        $slots = $query->paginate($perPage);

        return response()->json($slots);
    }

    public function getSlotsByRack($rackId)
    {
        try {
            $slots = WarehouseSlot::where('rack_id', $rackId)
                ->orderBy('code')
                ->get();
            
            return response()->json($slots);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch slots'], 500);
        }
    }
}