<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create-pallet');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'barcode' => ['required', 'string', 'max:255', 'unique:pallets,barcode'],
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
