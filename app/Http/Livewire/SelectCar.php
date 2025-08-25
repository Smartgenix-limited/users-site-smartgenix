<?php

namespace App\Http\Livewire;

use App\Models\CarInfo;
use Livewire\Component;

class SelectCar extends Component
{
    public $type, $car, $car_ids = [], $selected_cars = [];

    public function mount()
    {
        if (request()->car) {
            $this->car_ids[] = request()->car;
            $this->selected_cars = CarInfo::where('id', request()->car)->get();
        }
    }

    public function render()
    {
        return view('livewire.select-car', [
            'cars' => request()->user()->cars()->whereNotIn('id', $this->car_ids)->get(['id', 'car_name', 'model', 'reg']),
        ]);
    }

    public function updatedCar()
    {
        // solo account only select one car at a time so empty array
        if (auth()->user()->type === 'solo' || $this->type === 'repair') {
            $this->car_ids = [];
        }
        $this->car_ids[] = $this->car;

        $this->selected_cars = CarInfo::whereIn('id', $this->car_ids)->get();
        $this->car = '';
    }

    // remove car id from list
    // public function removeCar($index, $id)
    // {
    //     $key = array_search($id, $this->car_ids);
    //     unset($this->car_ids[$key]);
    //     unset($this->selected_cars[$index]);
    //     array_splice($this->selected_cars, 0, 0);
    // }
}
