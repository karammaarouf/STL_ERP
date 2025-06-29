<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit-warehouse-section');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $sectionId = $this->route('warehouse_section')->id;

        return [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:warehouse_sections,code,' . $sectionId,
            'zone_id' => 'required|exists:warehouse_zones,id',
        ];
    }
}
