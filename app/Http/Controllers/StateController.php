<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Services\StateService;
use App\Models\Country;

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
        $countries = Country::all();
        return view('pages.states.partials.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        if (!auth()->user()->can('create-state')) {
            abort(403);
        }
        $this->stateService->createState($request->validated());
        return redirect()->route('states.index')->with('success', __('State created successfully.'));
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
    public function edit(State $state)
    {
        if (!auth()->user()->can('edit-state')) {
            abort(403);
        }
        $countries = Country::all();
        return view('pages.states.partials.edit', compact('state', 'countries'));
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        if (!auth()->user()->can('edit-state')) {
            abort(403);
        }
        $this->stateService->updateState($state, $request->validated());
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
}
