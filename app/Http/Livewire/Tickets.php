<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.tickets', [
            'tickets' => request()->user()->tickets()->latest()->paginate(10)
        ]);
    }
}
