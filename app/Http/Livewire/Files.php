<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\FileUpload;

class Files extends Component
{
    use WithFileUploads, FileUpload;

    public $attachments = [];
    public $iteration = 1;
    public $files;
    public $images = [];
    public $videos = [];
    public $media = [];

    public function mount()
    {
        $this->media = json_encode($this->files);
    }

    public function render()
    {
        return view('livewire.files');
    }

    // uploading files on choosen
    public function updatedAttachments()
    {
        $this->validate([
            'attachments.*' => ['mimes:jpg,jpeg,png,webp,webm,mp4,mov,webm,mkv,flv,avi']
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
                // upload file
                $path = $this->fileUpload($file);
                $item['file'] = $path;
                // check file type
                if (in_array($file->getClientOriginalExtension(), $image_types)) {
                    // file is image
                    $item['type'] = 'image';
                } else {
                    // file is video
                    $item['type'] = 'video';
                }
                $this->files[] = $item;
            }
            $this->media = json_encode($this->files);
        }
    }

    // separating files to iamges and videos
    public function separate_files()
    {
        foreach ($this->files as $file) {
            if ($file['type'] === 'image') {
                $this->images[] = $file['file'];
            } else {
                $this->videos[] = $file['file'];
            }
        }
    }

    // delete file
    public function delete_file($index, $file)
    {
        unset($this->files[$index]);
        array_splice($this->files, 0, 0);
        $this->media = json_encode($this->files);

        $this->deleteFile($file);
    }

    // clear fields
    private function clearFields()
    {
        $this->files = [];
        $this->attachments = [];
        $this->images = [];
        $this->videos = [];
    }
}
