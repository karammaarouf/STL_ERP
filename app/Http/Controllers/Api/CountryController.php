<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $page = $request->input('page', 1);
        $perPage = 5;

        $query = Country::query()
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('name');

        $countries = $query->paginate($perPage);

        return response()->json([
            'data' => $countries->map(function ($country) {
                return [
                    'id' => $country->id,
                    'text' => $country->name,
                ];
            }),
            'pagination' => [
                'more' => $countries->hasMorePages(),
            ],
        ]);
    }
}