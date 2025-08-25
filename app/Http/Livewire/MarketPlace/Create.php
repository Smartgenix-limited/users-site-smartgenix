<?php

namespace App\Http\Livewire\MarketPlace;

use App\Models\CarInfo;
use App\Models\Country;
use App\Models\MarketPlace;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\FileUpload;

class Create extends Component
{
    use WithFileUploads, FileUpload;

    public $product, $is_promoted, $is_updated = false;
    public $type = 'car', $is_validated = false, $promote = true, $search_promote = false, $countries, $is_search_promote = false, $is_disable = true, $checkbox_disable = false, $show_number = false;
    public $make, $model, $varient, $engine_size, $body_type, $transmition, $fuel_type, $colour, $reg_date, $mileage, $price, $title, $description, $location, $condition, $vehicle_type, $vehicle_seats;
    public $product_name, $brand, $brand_number, $grade, $category, $sub_category, $ean, $quantity;
    public $features, $attachments = [], $iteration = 1, $files = [], $images = [];
    public $fee, $initial_fee, $homepage_promotion_fee, $search_promotion_fee, $engine_sizes = [], $transmitions = [];
    protected $listeners = ['disableCheckbox'];

    public function mount()
    {
        $this->features = [];
        $this->fee = support_setting('marketplace_add_product_price');
        $this->initial_fee = $this->fee;
        $this->homepage_promotion_fee = support_setting('homepage_promotion_price');
        $this->search_promotion_fee = support_setting('search_promotion_price');
        $this->countries = Country::get();
        if (request()->car) {
            $car = CarInfo::find(request()->car);
            if ($car) {
                $this->make = $car->car_name;
                $this->model = $car->model;
                $this->colour = $car->colour;
                $this->mileage = $car->mileage;
                $this->files[] = $car->image;
            }
        }
        $this->engine_sizes = [
            '0.5L', '1L', '1.5L', '2.6L', '1.8L', '1.9L', '2.0L', '2.5L', '2.8L', '3.0L', '3.5L', '4.0L', '4.5L', '5.0L', '5.5L', '6.0L', '6.5L', '7.0L', '7.5L', '8.0L', 'Up to 8.0+L'
        ];
        $this->transmitions = ['Automatic', 'Manual'];

        if ($this->product) {
            if ($this->product->car_product_id) {
                $car = $this->product->car;
                $this->make = $car->make;
                $this->model = $car->model;
                $this->varient = $car->varient;
                $this->engine_size = $car->engine_size;
                $this->body_type = $car->body_type;
                $this->body_type = $car->body_type;
                $this->transmition = $car->transmition;
                $this->fuel_type = $car->fuel_type;
                $this->colour = $car->colour;
                $this->reg_date = $car->reg_date->format('Y-m-d');
                $this->mileage = $car->mileage;
                $this->condition = $car->condition;
                $this->vehicle_type = $car->vehicle_type;
                $this->vehicle_seats = $car->vehicle_seats;
                $this->features = $car->features ?? [];
            } else {
                $product = $this->product->product;
                $this->product_name = $product->name;
                $this->make = $product->make;
                $this->condition = $product->condition;
                $this->brand = $product->brand;
                $this->brand_number = $product->brand_number;
                $this->grade = $product->grade;
                $this->category = $product->category;
                $this->sub_category = $product->sub_category;
                $this->ean = $product->ean;
                $this->quantity = $product->quantity;
            }

            $this->type = $this->product->product_id ? 'product' : 'car';
            $this->title = $this->product->title;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->location = $this->product->location;
            $this->files = $this->product->images;
            $this->show_number = $this->product->show_number;
            $this->promote = $this->product->is_promoted;
            $this->search_promote = $this->product->is_search_promoted;
            $this->is_search_promote = $this->product->is_search_promoted;
        }
    }

    public function render()
    {
        return view('livewire.market-place.create');
    }

    public function validateInputs()
    {
        if ($this->type === 'car') {
            $this->validate([
                'make' => ['required', 'string', 'max:255'],
                'model' => ['required', 'string', 'max:255'],
                'varient' => ['required', 'string', 'max:255'],
                'engine_size' => ['required', 'string', 'max:255'],
                'body_type' => ['required', 'string', 'max:255'],
                'transmition' => ['required', 'string', 'max:255'],
                'fuel_type' => ['required', 'string', 'max:255'],
                'colour' => ['required', 'string', 'max:255'],
                'reg_date' => ['required', 'string', 'max:255'],
                'mileage' => ['required', 'numeric'],
                'price' => ['required', 'numeric'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'location' => ['required', 'string', 'max:255'],
                'condition' => ['required', 'string', 'max:255'],
                'vehicle_type' => ['required', 'string', 'max:255'],
                'vehicle_seats' => ['required', 'string', 'max:255'],
                'files' => [count($this->files) < 1 ? 'required' : 'nullable'],
            ], [], ['files' => 'images']);
        } else {
            $this->validate([
                'product_name' => ['required', 'string', 'max:255'],
                'brand' => ['required', 'string', 'max:255'],
                'brand_number' => ['required', 'string', 'max:255'],
                'grade' => ['required', 'string', 'max:255'],
                'category' => ['required', 'string', 'max:255'],
                'sub_category' => ['required', 'string', 'max:255'],
                'ean' => ['nullable', 'string', 'max:255'],
                'quantity' => ['required', 'numeric'],
                'condition' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'location' => ['required', 'string', 'max:255'],
                'files' => [count($this->files) < 1 ? 'required' : 'nullable'],
            ], [], ['files' => 'images']);
        }

        if ($this->is_promoted) {
            if ($this->promote) {
                $promoted_count = MarketPlace::withoutGlobalScope('location')->where('is_promoted', true)->where('end_promotion', '>', now())->count();
                if ($promoted_count < 15) {
                    $this->is_validated = true;
                    $this->dispatchBrowserEvent('dataValidated');
                } else {
                    $this->dispatchBrowserEvent('feeUpdated', ['fee' => number_format(convert_price($this->initial_fee), 2)]);
                    $this->promote = false;
                    $this->is_search_promote = true;
                    session()->flash('error', trans('marketplace.promotion_exceed'));
                }
            } else {
                $this->is_validated = true;
                $this->dispatchBrowserEvent('dataValidated');
            }
        } else {
            $this->is_validated = true;
            $this->dispatchBrowserEvent('dataValidatedUpdated');
        }

        if ($this->is_updated && $this->is_validated) {
            $this->checkbox_disable = true;
        }
    }

    public function disableCheckbox($value)
    {
        $this->checkbox_disable = $value;
    }

    public function updatedPromote()
    {
        if ($this->promote) {
            if ($this->is_updated) {
                $this->fee = $this->homepage_promotion_fee;
            } else {
                $this->fee += $this->homepage_promotion_fee;
            }

            $this->is_promoted = true;
        } else {
            if ($this->initial_fee < $this->fee) {
                if ($this->is_updated) {
                    $this->fee = 0;
                } else {
                    $this->fee -= $this->homepage_promotion_fee;
                }

                $this->is_promoted = false;
            }
        }
        $this->dispatchBrowserEvent('feeUpdated', ['fee' => number_format(convert_price($this->fee), 2)]);
    }


    public function updatedSearchPromote()
    {
        if ($this->search_promote) {
            if ($this->is_updated) {
                $this->fee = $this->homepage_promotion_fee;
            } else {
                $this->fee += $this->search_promotion_fee;
            }

            $this->is_promoted = true;
        } else {
            if ($this->initial_fee < $this->fee) {
                if ($this->is_updated) {
                    $this->fee = 0;
                } else {
                    $this->fee -= $this->search_promotion_fee;
                }

                $this->is_promoted = false;
            }
        }
        $this->dispatchBrowserEvent('feeUpdated', ['fee' => number_format(convert_price($this->fee), 2)]);
    }

    public function changeType($type)
    {
        $this->type = $type;
    }

    // add new Feature
    public function addFeature()
    {
        $this->features[] = [
            'feature' => '',
        ];
    }

    // delete Feature
    public function deleteFeature($index)
    {
        unset($this->features[$index]);
    }

    // uploading files on choosen
    public function updatedAttachments()
    {
        $this->validate([
            'attachments.*' => ['mimes:jpg,jpeg,png,webp,webm,gif']
        ]);
        // uploading files to disk after validation
        $this->upload_files();

        // clear the attachment veriable to empty array
        $this->attachments = [];
        $this->iteration++;
    }

    // upload files
    public function upload_files()
    {
        $image_types = ['jpg', 'jpeg', 'png', 'webp', 'webm'];
        if (count($this->attachments) > 0) {
            foreach ($this->attachments as $file) {
                $this->files[] = $this->fileUpload($file);
            }
        }
    }


    // delete file
    public function delete_file($index, $file)
    {
        unset($this->files[$index]);
        array_splice($this->files, 0, 0);

        $this->deleteFile($file);
    }

    // clear fields
    private function clearFields()
    {
        $this->files = [];
        $this->attachments = [];
        $this->images = [];
    }
}
