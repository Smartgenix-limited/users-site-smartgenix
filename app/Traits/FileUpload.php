<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    // uploding file
    public function fileUpload($file, $folderName = 'files', $oldFile = NULL)
    {
        $originalFileName = $file->getClientOriginalName();
        $filename = str_replace(' ', '-', pathinfo($originalFileName, PATHINFO_FILENAME));
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $fileName = $filename . "-" . time() . "." . $extension;
        $file->storeAs($folderName, $fileName, "public");
        if ($oldFile) {
            $path = str_replace('storage', '/public', $oldFile);
            Storage::delete($path);
        }
        $path = url('/') . '/storage/' . $folderName . '/' . $fileName;
        return $path;
    }

    // deleting file
    public function deleteFile($file)
    {
        $path = str_replace(url('/') . '/storage', '/public', $file);
        Storage::delete($path);
    }
}
