<?php

namespace App\Http\Livewire\MarketPlace;

use App\Enums\ProductStatus;
use App\Models\MarketPlace;
use App\Models\Product;
use Livewire\Component;

class Homepage extends Component
{
    public $currency, $search = '', $search_filters, $filters = [], $show_filters = false;

    public function mount()
    {
        $this->currency = support_setting('currency_symbol');
        $this->search_filters = ['vehicle_type', 'engine_size', 'vehicle_seats', 'mileage', 'fuel_type', 'price', 'location', 'colour'];
    }

    public function render()
    {
        return view('livewire.market-place.homepage', [
            'sponsered_products' => MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', true)->whereNotNull('product_id')->take(6)->get(),
            'sponsered_cars' => MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', true)->whereNotNull('car_product_id')->take(6)->get(),
            'car_products' => MarketPlace::where('status', ProductStatus::UnSold)->where('is_promoted', false)->whereNull('product_id')->take(6)->get(),
            'other_products' => Product::with('market')->whereRelation('market', 'status', ProductStatus::UnSold)->whereRelation('market', 'is_promoted', false)->get()->groupBy('sub_category'),
            'search_products' => $this->search ? MarketPlace::query()
                ->where('status', ProductStatus::UnSold)
                ->when($this->search, fn ($q) => $q->whereLike('title', $this->search)->OrWhereLike('description', $this->search))
                ->when($this->search && in_array('price', $this->filters), function ($query) {
                    $query->whereLike('price', $this->search);
                })
                ->when($this->search && in_array('location', $this->filters), function ($query) {
                    $query->whereLike('location', $this->search);
                })
                ->when($this->search && count($this->filters) > 0, function ($query) {
                    return $query->whereHas('car', function ($q) {
                        foreach ($this->filters as $filter) {
                            $q->whereLike($filter, $this->search);
                        }
                    });
                })
                ->orderBy('is_search_promoted', 'desc')
                ->get() : []
        ]);
    }

    public function toggleShowFilters()
    {
        $this->show_filters = !$this->show_filters;
    }

    public function closeFiltersIfShow()
    {
        if ($this->show_filters) {
            $this->show_filters = false;
        }
    }

    public function cannot_search()
    {
        return ($this->search !== '' && count($this->filters) == 0) ? true : false;
    }
}
