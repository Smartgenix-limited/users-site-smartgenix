<?php

namespace App\Http\Livewire;

use App\Models\ReadNotice;
use App\Models\ServiceNotice;
use Livewire\Component;

class ServiceNotices extends Component
{
    public function render()
    {
        $read_notices = ReadNotice::where('user_id', auth()->id())->pluck('service_notice_id');
        return view('livewire.service-notices', [
            'notices' => ServiceNotice::whereNotIn('id', $read_notices)->latest()->get()
        ]);
    }

    public function readNotice($notice_id)
    {
        ReadNotice::create([
            'user_id' => auth()->id(),
            'service_notice_id' => $notice_id
        ]);
    }
}
