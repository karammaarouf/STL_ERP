<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit-warehouse-rack');
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:warehouse_racks,code,' . $this->warehouse_rack->id,
            'section_id' => 'required|exists:warehouse_sections,id'
        ];
    }
}
