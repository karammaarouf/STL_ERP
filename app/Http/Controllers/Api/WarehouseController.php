<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 5;

        $warehouses = Warehouse::where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->paginate($perPage, ['*'], 'page', $page);
            
        return response()->json($warehouses);
    }
}