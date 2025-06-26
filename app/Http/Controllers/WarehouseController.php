<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Warehouse;
use App\Services\WarehouseService;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {
        if (!auth()->user()->can('view-warehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouses = $this->warehouseService->getAllWarehouses();
        return view('pages.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        if (!auth()->user()->can('create-warehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $cities = City::orderBy('name')->get();
        return view('pages.warehouses.partials.create', compact('cities'));
    }

    public function store(StoreWarehouseRequest $request)
    {
        // Authorization is now handled by the StoreWarehouseRequest file
        $this->warehouseService->createWarehouse($request->validated());
        return redirect()->route('warehouses.index')
            ->with('success', __('Warehouse created successfully.'));
    }

    public function show(Warehouse $warehouse)
    {
        if (!auth()->user()->can('show-warehouse')) {
            abort(403, 'Unauthorized action.');
        }
        // Eager load related data for the detailed view
        $warehouse->load('city.state.country');
        return view('pages.warehouses.partials.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        if (!auth()->user()->can('edit-warehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $cities = City::orderBy('name')->get();
        return view('pages.warehouses.partials.edit', compact('warehouse', 'cities'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        // Authorization is now handled by the UpdateWarehouseRequest file
        $this->warehouseService->updateWarehouse($warehouse, $request->validated());
        return redirect()->route('warehouses.index')
            ->with('success', __('Warehouse updated successfully.'));
    }

    public function destroy(Warehouse $warehouse)
    {
        if (!auth()->user()->can('delete-warehouse')) {
            abort(403, 'Unauthorized action.');
        }
        $this->warehouseService->deleteWarehouse($warehouse);
        return redirect()->route('warehouses.index')
            ->with('success', __('Warehouse deleted successfully.'));
    }
}
