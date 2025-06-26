<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('edit-warehouse');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // احصل على معرف المستودع من المسار
        $warehouseId = $this->route('warehouse')->id;

        return [
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouseId,
            'city_id' => 'required|exists:cities,id',
            'type' => 'required|in:main,branch',
            'total_capacity_weight' => 'nullable|numeric|min:0',
            'total_capacity_volume' => 'nullable|numeric|min:0',
        ];
    }
}
