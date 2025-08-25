<?php

namespace App\Http\Livewire;

use App\Models\Notification as ModelsNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Notification extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.notification', [
            'notifications' => ModelsNotification::query()
                ->where(fn ($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))
                ->where(function ($q) {
                    $q->where(function ($q) {
                        $q->whereNull('end_date');
                    })->orWhere(function ($q) {
                        $q->whereDate('end_date', '>=', date('Y-m-d'));
                    });
                })
                ->latest()
                ->paginate(10)
        ])->extends('layouts.app');
    }
}
