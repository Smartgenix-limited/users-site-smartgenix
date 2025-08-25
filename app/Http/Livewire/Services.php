<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.services', [
            'services' => request()->user()->services()->with(['car:id,car_name', 'garage:id,name'])->when(request()->car, fn ($q) => $q->where('car_id', request()->car))->orderBy('datetime', 'DESC')->paginate(10),
        ]);
    }
}
