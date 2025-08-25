<?php

namespace App\Http\Livewire;

use App\Enums\SupportType;
use App\Models\Support;
use App\Models\SupportService;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\FileUpload;

class CreateTicket extends Component
{
    use WithFileUploads, FileUpload;

    public $is_type_selected = false;
    public $types;
    public $departments, $periorities;
    public $department, $service_type = 'plan', $priority = 'low', $subject, $message, $attachments = [];
    public $files = [];
    public $iteration = 1;
    public $service_types = [];
    public $services = [];

    protected $rules = [
        'department' => ['required', 'in:support,billing,sales,feature'],
        'priority' => ['required', 'in:low,medium,high'],
        'service_type' => ['required'],
        'subject' => ['required', 'string', 'max:255'],
        // 'status' => ['required', 'in:unanswered,answered,completed'],
        'message' => ['required'],
    ];

    public function mount()
    {
        $this->departments = Support::departments();
        $this->periorities = Support::periorities();
        $this->service_types = [
            'support' => ['plan', 'renewal', 'user_information'],
            'billing' => ['renewal', 'delete_account', 'question_an_account'],
            'sales' => ['new_contract', 'demos'],
            'feature' => ['new_feature'],
        ];
    }

    public function render()
    {
        return view('livewire.create-ticket');
    }


    public function createTicket()
    {
        $this->validate();
        $ticket = request()->user()->tickets()->create([
            'type' => 'garage',
            'department' => $this->department,
            'priority' => $this->priority,
            'service_type' => $this->service_type,
            'subject' => $this->subject,
        ]);
        $ticket->replies()->create([
            'type' => SupportType::Garage,
            'user_id' => auth()->id(),
            'message' => $this->message,
            'attachments' => $this->files
        ]);

        return redirect()->route('supports.index')->with('success', trans('general.new_ticket_success'));
    }

    public function selectDepartment($type)
    {
        $this->department = $type;
        $this->updatedDepartment();
        $this->is_type_selected = true;
    }

    // on changing selecting departments
    public function updatedDepartment()
    {
        $this->services = SupportService::whereDepartment($this->department)->get();
        $this->service_type = $this->services->first()->service;
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

    public function clearFields()
    {
        $this->is_type_selected = false;
        $this->department = '';
        $this->service_type = '';
        // $this->periority = '';
        $this->priority = '';
        $this->subject = '';
        $this->message = '';
    }
}
