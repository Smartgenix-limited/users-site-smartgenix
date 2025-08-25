<?php

namespace App\Http\Livewire;

use App\Models\Recovery;
use App\Models\RecoveryComment;
use Livewire\Component;

class Comments extends Component
{
    public $comment = '', $recovery;

    public function render()
    {
        return view('livewire.comments', [
            'comments' => RecoveryComment::where('recovery_id', $this->recovery->id)->latest()->get()
        ]);
    }

    public function addComment()
    {
        $this->recovery->comments()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->recovery->completer->quote_user_id,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
    }
}
