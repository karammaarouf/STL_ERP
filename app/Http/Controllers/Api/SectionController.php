<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseSection;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 5;

        $sections = WarehouseSection::with(['zone', 'zone.warehouse'])
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->paginate($perPage, ['*'], 'page', $page);
            
        return response()->json($sections);
    }

    public function getSectionsByZone($zoneId)
    {
        try {
            $sections = WarehouseSection::where('zone_id', $zoneId)
                ->orderBy('name')
                ->get();
            
            return response()->json($sections);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch sections'], 500);
        }
    }
}