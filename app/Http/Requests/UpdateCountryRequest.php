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
        // تأكد من أن المستخدم لديه الصلاحية اللازمة
        return $this->user()->can('edit-country');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // الحصول على id الدولة من المسار (route)
        $countryId = $this->route('country')->id;

        return [
            'name' => 'required|string|max:100|unique:countries,name,' . $countryId,
            // تعديل هنا
            'iso_code' => 'required|string|max:3|unique:countries,iso_code,' . $countryId,
        ];
    }

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

