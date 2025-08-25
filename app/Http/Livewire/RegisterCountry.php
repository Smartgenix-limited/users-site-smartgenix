<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;

class RegisterCountry extends Component
{
    public $type, $countries, $cities, $country, $city, $is_country;

    public function mount()
    {
        $this->countries = Country::orderBy('name')->get();
        $this->country = old('country', auth()->user()?->country);
        $this->city = old('city', auth()->user()?->city);
        $this->is_country = old('country', auth()->user()?->country) ? true : false;
        $this->cities = old('country', auth()->user()?->country) ? Country::where('name', $this->country)->first()?->cities ?? [] : [];
    }

    public function render()
    {
        return view('livewire.register-country');
    }

    public function updatedCountry()
    {
        if ($this->country) {
            $this->cities = Country::where('name', $this->country)->first()->cities;
            $this->is_country = true;
        } else {
            $this->is_country = false;
            $this->city = '';
        }
    }
}
