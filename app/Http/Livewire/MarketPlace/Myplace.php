<?php

namespace App\Http\Livewire\MarketPlace;

use App\Enums\ProductStatus;
use App\Models\MarketPlace;
use Livewire\Component;

class Myplace extends Component
{
    public $type = 'buying', $products;

    public function render()
    {
        // => fn ($q) => $q->orderBy('created_at', 'ASC')
        if ($this->type === 'buying') {
            $this->products = MarketPlace::withoutGlobalScope('location')->with(['buyer_requests', 'product', 'car'])->whereRelation('buyer_requests', 'request_user_id', auth()->id())->get();
        } elseif ($this->type === 'bought') {
            $this->products = MarketPlace::withoutGlobalScope('location')->with(['buyers', 'product', 'car'])->whereRelation('buyers', 'buyer_id', auth()->id())->get();
        } elseif ($this->type === 'sold') {
            $this->products = request()->user()->markets()->withoutGlobalScope('location')->where('status', ProductStatus::Sold)->get();
        } else {
            $this->products = request()->user()->markets()->withoutGlobalScope('location')->where('status', ProductStatus::UnSold)->get();
        }

        return view('livewire.market-place.myplace');
    }

    public function changeType($type)
    {
        $this->type = $type;
    }
}
