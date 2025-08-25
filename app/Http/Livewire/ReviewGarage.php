<?php

namespace App\Http\Livewire;

use App\Models\Garage;
use App\Models\Review;
use Livewire\Component;

class ReviewGarage extends Component
{
    public $garage, $rating = 0, $rating_numbers, $overall, $facility, $appointment, $car_back, $comment, $review;

    public function mount()
    {
        $this->review = Review::where(['garage_id' => active_garage(), 'user_id' => auth()->id()])->first();
        $this->garage = Garage::find(active_garage());
        $this->rating_numbers = [1, 2, 3, 4, 5];
        $this->overall = $this->review ? $this->review->overall : 0;
        $this->facility = $this->review ? $this->review->facility : 0;
        $this->appointment = $this->review ? $this->review->appointment : 0;
        $this->car_back = $this->review ? $this->review->car_back : 0;
        $this->comment = $this->review ? $this->review->review : null;
        $this->calculateRating();
    }

    public function render()
    {
        return view('livewire.review-garage');
    }

    public function changeRating($type, $rating)
    {
        $this->$type = $rating;
        $this->calculateRating();
    }

    public function calculateRating()
    {
        $this->rating = ($this->overall + $this->facility + $this->appointment + $this->car_back);
    }

    public function saveRating()
    {
        if ($this->review) {
            $this->review->update([
                'overall' => $this->overall,
                'facility' => $this->facility,
                'appointment' => $this->appointment,
                'car_back' => $this->car_back,
                'rating' => ceil($this->rating / 4),
                'review' => $this->comment,
            ]);
        } else {
            Review::create([
                'user_id' => auth()->id(),
                'overall' => $this->overall,
                'facility' => $this->facility,
                'appointment' => $this->appointment,
                'car_back' => $this->car_back,
                'rating' => ceil($this->rating / 4),
                'review' => $this->comment,
            ]);
        }


        session()->flash('success', trans('general.thanks_review'));
    }
}
