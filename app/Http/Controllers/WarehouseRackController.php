<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRackRequest;
use App\Http\Requests\UpdateWarehouseRackRequest;
use App\Models\WarehouseRack;
use App\Models\WarehouseSection;
use App\Services\WarehouseRackService;
use Illuminate\Http\Request;

class WarehouseRackController extends Controller
{
    protected $warehouseRackService;

    public function __construct(WarehouseRackService $warehouseRackService)
    {
        $this->warehouseRackService = $warehouseRackService;
    }

    public function index()
    {
        $warehouseRacks = $this->warehouseRackService->getAllRacks();
        return view('pages.warehouse_racks.index', compact('warehouseRacks'));
    }

    public function create()
    {
        return view('pages.warehouse_racks.partials.create');
    }

    public function store(StoreWarehouseRackRequest $request)
    {
        $this->warehouseRackService->createRack($request->validated());
        return redirect()->route('warehouse-racks.index')
            ->with('success', __('Warehouse rack created successfully.'));
    }

    public function show(WarehouseRack $warehouseRack)
    {
        $warehouseRack->load('section.zone.warehouse');
        return view('pages.warehouse_racks.partials.show', compact('warehouseRack'));
    }

    public function edit(WarehouseRack $warehouseRack)
    {
        $sections = WarehouseSection::with('zone.warehouse')->get();
        return view('pages.warehouse_racks.partials.edit', compact('warehouseRack', 'sections'));
    }

    public function update(UpdateWarehouseRackRequest $request, WarehouseRack $warehouseRack)
    {
        $this->warehouseRackService->updateRack($warehouseRack, $request->validated());
        return redirect()->route('warehouse-racks.index')
            ->with('success', __('Warehouse rack updated successfully.'));
    }

    public function destroy(WarehouseRack $warehouseRack)
    {
        $this->warehouseRackService->deleteRack($warehouseRack);
        return redirect()->back()
            ->with('success', __('Warehouse rack deleted successfully.'));
    }
}
