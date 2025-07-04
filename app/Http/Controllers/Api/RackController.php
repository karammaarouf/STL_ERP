<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseRack;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = WarehouseRack::with(['section.zone.warehouse'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('code');

        $racks = $query->paginate($perPage);

        return response()->json($racks);
    }

    public function getRacksBySection($sectionId)
    {
        try {
            $racks = WarehouseRack::where('section_id', $sectionId)
                ->orderBy('code')
                ->get();
            
            return response()->json($racks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch racks'], 500);
        }
    }
}