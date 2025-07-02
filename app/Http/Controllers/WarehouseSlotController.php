<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseSlotRequest;
use App\Http\Requests\UpdateWarehouseSlotRequest;
use App\Models\WarehouseSlot;
use App\Models\WarehouseRack;
use App\Services\WarehouseSlotService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WarehouseSlotController extends Controller
{
    protected WarehouseSlotService $slotService;

    public function __construct(WarehouseSlotService $slotService)
    {
        $this->slotService = $slotService;
    }

    public function index(): View
    {
        if (!auth()->user()->can('view-warehouse-slot')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouseSlots = $this->slotService->getAllSlots();
        return view('pages.warehouse_slots.index', compact('warehouseSlots'));
    }

    public function create(): View
    {
        if (!auth()->user()->can('create-warehouse-slot')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.warehouse_slots.partials.create');
    }

    public function store(StoreWarehouseSlotRequest $request): RedirectResponse
    {
        try {
            $this->slotService->createSlot($request->validated());
            return redirect()->route('warehouse-slots.index')
                ->with('success', __('Warehouse slot created successfully.'));
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', __('An error occurred while creating the slot.'));
        }
    }

    public function show(WarehouseSlot $warehouseSlot): View
    {
        if (!auth()->user()->can('show-warehouse-slot')) {
            abort(403, 'Unauthorized action.');
        }
        $warehouseSlot->load(['rack.section.zone.warehouse']);
        return view('pages.warehouse_slots.partials.show', compact('warehouseSlot'));
    }

    public function edit(WarehouseSlot $warehouseSlot): View
    {
if (!auth()->user()->can('edit-warehouse-slot')) {
    abort(403, 'Unauthorized action.');
}
        $racks = WarehouseRack::with(['section.zone.warehouse'])->get();
        return view('pages.warehouse_slots.partials.edit', compact('warehouseSlot', 'racks'));
    }

    public function update(UpdateWarehouseSlotRequest $request, WarehouseSlot $warehouseSlot): RedirectResponse
    {
        try {
            $this->slotService->updateSlot($warehouseSlot, $request->validated());
            return redirect()->route('warehouse-slots.index')
                ->with('success', __('Warehouse slot updated successfully.'));
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', __('An error occurred while updating the slot.'));
        }
    }

    public function destroy(WarehouseSlot $warehouseSlot): RedirectResponse
    {
if (!auth()->user()->can('delete-warehouse-slot')) {
    abort(403, 'Unauthorized action.');
}
        try {
            $this->slotService->deleteSlot($warehouseSlot);
            return redirect()->back()
                ->with('success', __('Warehouse slot deleted successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', __('An error occurred while deleting the slot.'));
        }
    }
}
