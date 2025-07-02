<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseZone;
use App\Models\WarehouseSection;
use App\Services\WarehouseSectionService;
use App\Http\Requests\StoreWarehouseSectionRequest;
use App\Http\Requests\UpdateWarehouseSectionRequest;

class WarehouseSectionController extends Controller
{
    protected $warehouseSectionService;

    public function __construct(WarehouseSectionService $warehouseSectionService)
    {
        $this->warehouseSectionService = $warehouseSectionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouseSections = $this->warehouseSectionService->getAllWarehouseSections();
        return view('pages.warehouse_sections.index', compact('warehouseSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warehouse_sections.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseSectionRequest $request)
    {
        $this->warehouseSectionService->createWarehouseSection($request->validated());
        return redirect()->route('warehouse-sections.index')->with('success', __('Section created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(WarehouseSection $warehouseSection)
    {
        $warehouseSection->load('zone.warehouse');
        return view('pages.warehouse_sections.partials.show', compact('warehouseSection'));
    }

    public function edit(WarehouseSection $warehouseSection)
    {
        $warehouseSection->load('zone.warehouse');
        $zones = WarehouseZone::with('warehouse')->get();
        return view('pages.warehouse_sections.partials.edit', compact('warehouseSection', 'zones'));
    }

    public function update(UpdateWarehouseSectionRequest $request, WarehouseSection $warehouseSection)
    {
        $this->warehouseSectionService->updateWarehouseSection($warehouseSection, $request->validated());
        return redirect()->route('warehouse-sections.index')->with('success', __('Section updated successfully'));
    }

    public function destroy(WarehouseSection $warehouseSection)
    {
        try {
            $this->warehouseSectionService->deleteWarehouseSection($warehouseSection);
            return redirect()->back()->with('success', __('Section deleted successfully'));
        } catch (\Exception $e) {
            return redirect()->route('warehouse-sections.index')->with('error', __('Cannot delete section'));
        }
    }
}
