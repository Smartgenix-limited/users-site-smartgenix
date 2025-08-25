<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CarImage extends Component
{
    use WithFileUploads;
    public $image, $photo;

    public function render()
    {
        return view('livewire.car-image');
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $this->photo = '';
    }
}
