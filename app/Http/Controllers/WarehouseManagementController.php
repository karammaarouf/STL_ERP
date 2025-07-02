<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseManagementController extends Controller
{
    public function index(){
        $warehouses = Warehouse::all();
        return view('pages.warehouses_management.index', compact('warehouses'));
    }
}
