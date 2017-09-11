<?php
namespace App\Repositories\File;


use App\Models\File;

abstract class FileUploader
{
    public function __construct()
    {
        $this->setFileName($this->generateFileName());
        $this->upload();
        $this->model = $this->createFile($this->getFileName());
    }

    /**
     * @var
     */
    protected $fileName;
    /**
     * @var
     */

    public $file;

    /**
     * @var
     */
    protected $destination;
    /**
     * @var
     */

    public $model;
    /**
     * @var int
     */

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }


    /**
     * @return string
     */
    public function generateFileName()
    {
        return time() . '_' . rand(0,100) . '.' . $this->file->getClientOriginalExtension();
    }


    public function upload()
    {
        $this->uploadFile($this->getFileName());
    }

    public function uploadFile($filename)
    {
        return $this->file->move(public_path($this->destination),  $filename);
    }

    public function createFile($filename)
    {
        return File::create([
            'path' => $this->destination,
            'name' => $filename,
        ]);
    }
}