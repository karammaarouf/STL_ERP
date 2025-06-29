<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit-warehouse-slot');
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:warehouse_slots,code,' . $this->warehouse_slot->id,
            'rack_id' => 'required|exists:warehouse_racks,id',
            'max_weight' => 'required|numeric|min:0',
            'max_volume' => 'required|numeric|min:0',
            'current_weight' => 'nullable|numeric|min:0',
            'current_volume' => 'nullable|numeric|min:0',
        ];
    }
}
