<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = City::with(['state.country'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('cities.name', 'like', "%{$search}%")
                          ->orWhereHas('state', function ($query) use ($search) {
                              $query->where('name', 'like', "%{$search}%")
                                    ->orWhereHas('country', function ($query) use ($search) {
                                        $query->where('name', 'like', "%{$search}%");
                                    });
                          });
                });
            })
            ->orderBy('name');

        $cities = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'text' => $city->name . ' (' . $city->state->name . ' - ' . $city->state->country->name . ')',
                ];
            }),
            'pagination' => [
                'more' => $cities->hasMorePages(),
            ],
        ]);
    }
}