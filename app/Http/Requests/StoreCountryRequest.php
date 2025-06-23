<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // تأكد من أن المستخدم لديه الصلاحية اللازمة
        return $this->user()->can('create-country');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:countries,name',
            //  تعديل هنا
            'iso_code' => 'required|string|max:3|unique:countries,iso_code',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => __('The country name is required.'),
            'name.unique' => __('The country name must be unique.'),
            'iso_code.required' => __('The country code is required.'),
            'iso_code.unique' => __('The country code must be unique.'),
        ];
    }
}
