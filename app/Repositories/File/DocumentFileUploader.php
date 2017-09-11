<?php
namespace App\Repositories\File;

use Illuminate\Support\Facades\File;

class DocumentFileUploader extends FileUploader
{
    public function __construct($file)
    {
        $this->file = $file;
        $this->destination = 'uploads/files/';

        if (!is_dir(public_path($this->destination)))
        {
            File::makeDirectory(public_path($this->destination), $mode = 0777, true);
        }

        parent::__construct();
    }
}