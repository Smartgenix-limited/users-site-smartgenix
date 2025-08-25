<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoveryRequest extends FormRequest
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
            'cars' => [$this->isMethod('post') ? 'required' : 'nullable'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'string', 'max:255'],
            'longitude' => ['nullable', 'string', 'max:255'],
            'nearby_places' => ['required', 'string'],
            'type' => ['required', 'string', 'in:home,garage,other,none'],
            'other' => ['required_if:type,other', 'nullable ', 'string', 'max:255'],
            'roadside_assistance' => ['required', 'in:yes,no'],
            'payment_type' => ['required', 'in:cash,card']
        ];
    }
}
