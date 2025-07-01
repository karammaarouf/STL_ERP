<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pallet;
use Illuminate\Http\Request;

class PalletController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = Pallet::with(['warehouse'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('barcode', 'like', "%{$search}%")
                        ->orWhereHas('warehouse', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest();

        $pallets = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $pallets->items(),
            'current_page' => $pallets->currentPage(),
            'last_page' => $pallets->lastPage(),
        ]);
    }
}