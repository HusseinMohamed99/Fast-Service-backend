<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerInformationRequest extends Request
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
            'address' => ['nullable', 'exclude_if:details,present,price_from,present,price_to,present,working_hours_from,present,working_hours_to,present'],
            'details' => ['nullable', 'exclude_if:address,present,price_from,present,price_to,present,working_hours_from,present,working_hours_to,present'],
            'price_from' => ['nullable', 'exclude_if:address,present,details,present,price_to,present,working_hours_from,present,working_hours_to,present','required_with:price_to'],
            'price_to' => ['nullable', 'exclude_if:address,present,details,present,price_from,present,working_hours_from,present,working_hours_to,present','required_with:price_from'],
            'working_hours_from' => ['nullable' , 'before:working_hours_to', 'required_with:working_hours_to'],
            'working_hours_to' => ['nullable' , 'after:working_hours_from', 'required_with:working_hours_from'],

        ];
    }
}
