<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create-warehouse-section');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:warehouse_sections,code',
            'zone_id' => 'required|exists:warehouse_zones,id',
        ];
    }
}
