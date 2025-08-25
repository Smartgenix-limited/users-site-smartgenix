<?php

namespace App\Http\Livewire;

use App\Models\CarInfo;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarTransfer extends Component
{
    use AuthorizesRequests;

    public $car;
    public $email = '';
    public $user;
    public $user_id;

    public function mount()
    {
        $this->car = CarInfo::find(request()->car);
        $this->authorize('transfer', $this->car);
    }

    public function render()
    {
        return view('livewire.car-transfer')->extends('layouts.app');
    }

    // finding user on search
    public function findUser()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $user = User::whereEmail($this->email)->first();
        if ($user) {
            $this->user = $user;
            $this->user_id = $user->id;
        } else {
            $this->user = null;
            session()->flash('error', 'No User Found');
        }
        $this->email = '';
    }

    // finding user on search
    public function confirmTransfer()
    {
        $this->authorize('transfer', $this->car);

        $this->car->update(['user_id' => $this->user_id]);

        return redirect()->route('garage.index')->with('success', 'Car Successfully Transfered!');
    }
}
