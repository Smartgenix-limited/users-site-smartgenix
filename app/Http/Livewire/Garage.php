<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Garage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.garage', [
            'cars' => request()->user()->cars()->paginate(10)
        ]);
    }
}
