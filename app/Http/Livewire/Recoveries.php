<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Recoveries extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.recoveries', [
            'recoveries' => request()->user()->recoveries()->with(['completer'])->when(request()->car, fn ($q) => $q->where('car_id', request()->car))->latest()->paginate(10)
        ]);
    }
}
