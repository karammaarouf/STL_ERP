<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use App\Services\StateService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;

class StateController extends Controller
{
    protected $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!auth()->user()->can('view-state')) {
            abort(403);
        }
        $states = $this->stateService->getAllStates();
        return view('pages.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create-state')) {
            abort(403);
        }
        return view('pages.states.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // في ملف StateController.php


    public function store(StoreStateRequest $request)
    {
        // 1. التحقق من صلاحيات المستخدم
        if (!auth()->user()->can('create-state')) {
            abort(403, 'Unauthorized action.');
        }

        $state = $this->stateService->createState($request->validated());

        if ($request->wantsJson()) {
            return response()->json($state, 201); // 201 = Created
        }

        return redirect()->route('states.index')
            ->with('success', __('State created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        if (!auth()->user()->can('show-state')) {
            abort(403);
        }
        return view('pages.states.partials.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state, Request $request)
    {
        if (!auth()->user()->can('edit-state')) {
            abort(403);
        }
        if ($request->wantsJson()) {
            return response()->json($state);
        }
        $countries = Country::all();
        return view('pages.states.partials.edit', compact('state', 'countries'));
    }


// app/Http/Controllers/StateController.php

public function update(UpdateStateRequest $request, State $state)
{
    if (!auth()->user()->can('edit-state')) {
        abort(403);
    }

    // 💡 نستقبل هنا النسخة المحدثة من الخدمة مباشرة
    $updatedState = $this->stateService->updateState($state, $request->validated());

    if ($request->wantsJson()) {
        
        return response()->json($updatedState);
    }

    return redirect()->route('states.index')->with('success', __('State updated successfully.'));
}

    public function destroy(State $state)
    {
        if (!auth()->user()->can('delete-state')) {
            abort(403);
        }
        $this->stateService->deleteState($state);
        return redirect()->route('states.index')->with('success', __('State deleted successfully.'));
    }

    /**
     * Fetch states for a given country and return as JSON.
     */
    public function getStatesForCountry(Country $country)
    {

        if (!auth()->user()->can('view-state')) {
            abort(403);
        }

        return response()->json($country->states()->orderBy('name')->get());
    }
}
