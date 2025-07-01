<?php

namespace App\Http\Controllers;

use App\Models\Pallet;
use App\Models\Warehouse;
use App\Http\Requests\StorePalletRequest;
use App\Http\Requests\UpdatePalletRequest;
use App\Services\PalletService;

class PalletController extends Controller
{
    protected $palletService;

    public function __construct(PalletService $palletService)
    {
        $this->palletService = $palletService;
        // $this->middleware(['permission:view-pallet'])->only(['index', 'show']);
        // $this->middleware('permission:create-pallet')->only(['create', 'store']);
        // $this->middleware('permission:edit-pallet')->only(['edit', 'update']);
        // $this->middleware('permission:delete-pallet')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pallets = $this->palletService->getAllPallets();
        return view('pages.pallets.index', compact('pallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        return view('pages.pallets.partials.create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePalletRequest $request)
    {
        $pallet = $this->palletService->createPallet($request->validated());
        return redirect()->route('pallets.index')
            ->with('success', __('Pallet created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pallet $pallet)
    {
        return view('pages.pallets.partials.show', compact('pallet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pallet $pallet)
    {
        $warehouses = Warehouse::all();
        return view('pages.pallets.partials.edit', compact('pallet', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePalletRequest $request, Pallet $pallet)
    {
        $this->palletService->updatePallet($pallet, $request->validated());
        return redirect()->route('pallets.index')
            ->with('success', __('Pallet updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pallet $pallet)
    {
        $this->palletService->deletePallet($pallet);
        return redirect()->route('pallets.index')
            ->with('success', __('Pallet deleted successfully'));
    }
}
