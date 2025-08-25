<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GarageRequest extends FormRequest
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
            'car_name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|numeric',
            'colour' => 'required|string|max:255',
            'reg' => 'required|string|max:7',
            'mileage' => 'required|numeric',
            'last_mot_date' => [is_uk() ? 'required' : 'nullable', 'string', 'date'],
            'last_service_date' => 'required|string|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
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
            'reg.required' => 'registration number is required',
            'reg.string' => 'registration number must be string',
            'reg.max' => 'registration number must be less than 7 character',
        ];
    }
}
