<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit-pallet');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'barcode' => ['required', 'string', 'max:255', Rule::unique('pallets', 'barcode')->ignore($this->pallet)],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'status' => ['required', 'in:empty,loaded,reserved'],
            'current_weight' => ['required', 'numeric', 'min:0'],
            'current_volume' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'barcode' => __('Barcode'),
            'warehouse_id' => __('Warehouse'),
            'status' => __('Status'),
            'current_weight' => __('Current Weight'),
            'current_volume' => __('Current Volume'),
        ];
    }
}
