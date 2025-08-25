<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RecoveryLocation extends Component
{
    public $location;

    protected $listeners = ['fetchLocation'];

    public function mount()
    {
        $this->location = old('location');
    }

    public function render()
    {
        return view('livewire.recovery-location');
    }

    public function fetchLocation($lat, $lang)
    {
        $response = fetch_location($lat, $lang);

        if ($response['status'] != 'OK') {
            $this->dispatchBrowserEvent('locationError', ['error' => $response['status']]);
        }

        $this->location = $response['results'][0]['formatted_address'];
        $this->dispatchBrowserEvent('locationSuccess', ['message' => __('general.location_success')]);
    }
}
