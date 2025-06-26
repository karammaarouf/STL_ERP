<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseZoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create-warehouse-zone');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:warehouse_zones,code',
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
