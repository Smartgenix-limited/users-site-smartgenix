<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'time' => 'required',
            'price' => 'nullable|numeric',
            'payment_id' => 'nullable|numeric',
            'cars' => 'required',
            'type_of_service' => 'required',
        ];
    }

    /**
     * Get the validation messages that will return on request fail.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'cars.required' => 'No car is selected',
        ];
    }
}
