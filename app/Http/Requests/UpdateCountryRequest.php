<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:countries,name,' . $this->country->id,
            'iso_code' => 'required|string|max:10|unique:countries,code,' . $this->country->id,
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدلة مطلوب .',
            'name.unique' => '  اسم الدلة يجب أن يكون فريدًا.',
            'iso_code.required' => 'رمز الدلة مطلوب   .',
            'iso_code.unique' => 'رمز الدلة يجب أن يكون فريدًا.',
        ];
    }
}
