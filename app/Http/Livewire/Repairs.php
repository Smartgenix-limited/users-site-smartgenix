<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Repairs extends Component
{
    public function render()
    {
        return view('livewire.repairs', [
            'quotes' => request()->user()->repairs()->with(['car:id,car_name', 'garage:id,name'])->where('datetime', null)->when(request()->car, fn ($q) => $q->where('car_id', request()->car))->latest()->get(),
            'repairs' => request()->user()->repairs()->with(['car:id,car_name', 'garage:id,name'])->where('datetime', '!=', null)->when(request()->car, fn ($q) => $q->where('car_id', request()->car))->orderBy('datetime', 'DESC')->paginate(10)
        ]);
    }
}
