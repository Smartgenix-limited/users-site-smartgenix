<?php

namespace App\Http\Livewire;

use App\Services\ScrapeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCar extends Component
{
    use WithFileUploads;
    public $image, $photo, $reg_number = '';
    public $car_name, $model, $year, $colour, $reg, $mileage, $last_mot_date, $last_service_date, $tax_paid_at;
    public $show_reg_form = false;

    public function mount()
    {
        if (!is_uk()) {
            $this->show_reg_form = true;
        }
        $this->car_name = old('car_name');
        $this->model = old('model');
        $this->year = old('year');
        $this->colour = old('colour');
        $this->reg = old('reg');
        $this->mileage = old('mileage');
        $this->last_mot_date = old('last_mot_date');
        $this->last_service_date = old('last_service_date');
    }

    public function render()
    {
        return view('livewire.add-car');
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $this->photo = '';
    }

    public function searchResult()
    {
        $this->validate([
            'reg_number' => 'required|string|max:7',
        ], [], [
            'reg_number' => 'registration number'
        ]);

        $response = (new ScrapeService())->scrapping($this->reg_number);

        if ($response) {
            $this->car_name = $response['Make'];
            $this->model = $response['ModelVariant'];
            $this->year = $response['YearManufacture'];
            $this->colour = $response['PrimaryColour'];
            $this->reg = $response['number_plate'];
            $this->mileage = $response['LastMOTMileage'];
            $this->last_mot_date = $response['last_mot_date'];
            $this->tax_paid_at = $response['tax_paid_at'];

            $this->show_reg_form = true;
        } else {
            session()->flash('no_car', trans('car.no_car'));
            $this->reg = $this->reg_number;
            $this->show_reg_form = true;
        }
    }

    public function validateInputs()
    {
        $this->validate([
            'car_name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|numeric',
            'colour' => 'required|string|max:255',
            'reg' => 'required|string|max:7|unique:car_infos,reg',
            'mileage' => 'required|numeric',
            'last_mot_date' => [is_uk() ? 'required' : 'nullable', 'string', 'date'],
            'last_service_date' => 'required|string|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $this->dispatchBrowserEvent('validatedGarage', ['validated' => true]);
    }
}
