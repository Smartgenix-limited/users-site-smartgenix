<?php

namespace App\Http\Livewire;

use App\Models\Reminder;
use Livewire\Component;

class GarageReminder extends Component
{
    public $type, $car, $reminder_type;

    public function mount()
    {
        $this->reminder_type = $this->type . '_reminder';
    }

    public function render()
    {
        return view('livewire.garage-reminder');
    }

    public function setReminder($type)
    {
        $this->car->update([
            $type => true
        ]);
    }
}
