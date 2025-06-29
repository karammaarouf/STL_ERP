<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create-warehouse-rack');
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:warehouse_racks,code',
            'section_id' => 'required|exists:warehouse_sections,id'
        ];
    }
}
