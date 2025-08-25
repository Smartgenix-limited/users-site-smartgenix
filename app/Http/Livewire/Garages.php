<?php

namespace App\Http\Livewire;

use App\Models\Garage;
use Livewire\Component;
use Livewire\WithPagination;

class Garages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $results = 10, $total = 0;

    // public function mount()
    // {
    //     $this->total = Garage::count();
    // }

    public function render()
    {
        $garages = Garage::withAvg('reviews', 'rating')->where('country', auth()->user()->country)->where('status', true)->when($this->search !== '', fn ($query) => $query->where(fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')->orWhere('address', 'like', '%' . $this->search . '%')->orWhere('telephone', 'like', '%' . $this->search . '%')))->orderBy('reviews_avg_rating', 'desc')->get();
        $this->dispatchBrowserEvent('draw_map', ['garages' => $garages]);

        return view('livewire.garages', [
            'garages' => $garages
        ]);
    }

    // public function loadMore()
    // {
    //     $this->results += 10;
    // }
}
