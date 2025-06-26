<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseZoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit-warehouse-zone');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $zoneId = $this->route('warehouse_zone')->id;

        return [
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:warehouse_zones,code,' . $zoneId,
            'warehouse_id' => 'required|exists:warehouses,id',
        ];
    }
}
