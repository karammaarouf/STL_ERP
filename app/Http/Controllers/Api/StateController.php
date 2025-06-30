<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = State::with(['country'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('name');

        $states = $query->paginate($perPage);

        return response()->json([
            'data' => $states->map(function ($state) {
                return [
                    'id' => $state->id,
                    'text' => $state->name . ' (' . $state->country->name . ')',
                ];
            }),
            'pagination' => [
                'more' => $states->hasMorePages(),
            ],
        ]);
    }
}