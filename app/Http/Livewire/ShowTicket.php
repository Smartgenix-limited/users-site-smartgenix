<?php

namespace App\Http\Livewire;

use App\Enums\SupportStatus;
use App\Enums\SupportType;
use App\Models\SupportReply;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\FileUpload;

class ShowTicket extends Component
{
    use WithFileUploads, FileUpload;

    public $ticket;
    public $message;
    public $attachments = [];
    public $files = [];
    public $iteration = 1;
    public $total = 0;
    public $complete;

    protected $rules = [
        'message' => ['required'],
    ];

    public function mount($support)
    {
        $this->ticket = $support;
    }

    public function render()
    {
        // dd($this->ticket->replies);
        $this->complete = $this->ticket->status === SupportStatus::Resolved ? true : false;
        return view('livewire.show-ticket', [
            'replies' => $this->ticket->replies
        ]);
    }

    public function createReply()
    {
        $this->validate();

        $this->ticket->replies()->create([
            'type' => SupportType::Garage,
            'user_id' => auth()->id(),
            'message' => $this->message,
            'attachments' => $this->files
        ]);
        $this->ticket->update(['status' => SupportStatus::UnAnswered]);

        $this->message = '';
        $this->files = [];
    }

    public function updatedComplete()
    {
        $this->ticket->update(['status' => SupportStatus::Resolved]);
    }
    public function completeTicket()
    {
        $this->ticket->update(['status' => SupportStatus::Resolved]);
    }
    // uploading files on choosen
    public function updatedAttachments()
    {
        $this->validate([
            'attachments.*' => ['mimes:jpg,jpeg,png,webp,webm,mp4,mov,webm,mkv,flv,avi,doc,pdf,docx,zip']
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
        $video_types = ['mp4', 'mov', 'webm', 'mkv', 'flv', 'avi'];
        if (count($this->attachments) > 0) {
            foreach ($this->attachments as $file) {
                // upload file
                $item['file'] = $this->fileUpload($file);
                // check file type
                if (in_array($file->getClientOriginalExtension(), $image_types)) {
                    // file is image
                    $item['type'] = 'image';
                } elseif (in_array($file->getClientOriginalExtension(), $video_types)) {
                    $item['type'] = 'video';
                } else {
                    // file is video
                    $item['type'] = 'file';
                }
                $this->files[] = $item;
            }
        }
    }

    // delete file
    public function delete_file($index, $file)
    {
        unset($this->files[$index]);
        array_splice($this->files, 0, 0);

        // deleting file from storage
        $this->deleteFile($file);
    }
}
