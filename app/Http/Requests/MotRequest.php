<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotRequest extends FormRequest
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
            'date' => 'required|date|after:tomorrow',
            'time' => 'required',
            'price' => 'nullable|numeric',
            'cars' => 'required',
            'payment_id' => 'nullable|numeric',
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
