<?php

namespace App\Http\Requests\Customer\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:25'],
            'phone_number' => ['sometimes', 'string', 'min:3', 'max:25'],
            'whatsapp_number' => ['sometimes','string'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'min:50', 'max:8000'],


        ];
    }
}
