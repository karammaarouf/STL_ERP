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
}