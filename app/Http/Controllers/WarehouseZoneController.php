<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseZone;
use App\Services\WarehouseZoneService;
use App\Http\Requests\StoreWarehouseZoneRequest;
use App\Http\Requests\UpdateWarehouseZoneRequest;

class WarehouseZoneController extends Controller
{
    protected $warehouseZoneService;

    public function __construct(WarehouseZoneService $warehouseZoneService)
    {
        $this->warehouseZoneService = $warehouseZoneService;
    }

    public function index()
    {
        if (!auth()->user()->can('view-warehouse-zone')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouseZones = $this->warehouseZoneService->getAllWarehouseZones();
        return view('pages.warehouse_zones.index', compact('warehouseZones'));
    }

    public function create()
    {
        if (!auth()->user()->can('create-warehouse-zone')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.warehouse_zones.partials.create', compact('warehouses'));
    }

    public function store(StoreWarehouseZoneRequest $request)
    {
        $this->warehouseZoneService->createWarehouseZone($request->validated());
        return redirect()->route('warehouse-zones.index')
            ->with('success', __('Warehouse zone created successfully.'));
    }

    public function show(WarehouseZone $warehouseZone)
    {
        if (!auth()->user()->can('show-warehouse-zone')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.warehouse_zones.partials.show', compact('warehouseZone'));
    }

    public function edit(WarehouseZone $warehouseZone)
    {
        if (!auth()->user()->can('edit-warehouse-zone')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouses = Warehouse::orderBy('name')->get();
        return view('pages.warehouse_zones.partials.edit', compact('warehouseZone', 'warehouses'));
    }

    public function update(UpdateWarehouseZoneRequest $request, WarehouseZone $warehouseZone)
    {
        $this->warehouseZoneService->updateWarehouseZone($warehouseZone, $request->validated());
        return redirect()->route('warehouse-zones.index')
            ->with('success', __('Warehouse zone updated successfully.'));
    }

    public function destroy(WarehouseZone $warehouseZone)
    {
        if (!auth()->user()->can('delete-warehouse-zone')) {
            abort(403, 'Unauthorized action.');
        }
        $this->warehouseZoneService->deleteWarehouseZone($warehouseZone);
        return redirect()->route('warehouse-zones.index')
            ->with('success', __('Warehouse zone deleted successfully.'));
    }
}
