<?php

namespace App\Libraries;

use Illuminate\Http\UploadedFile as UploadedFile;

class FileNameMaker
{
    private $file;

    public function __construct(UploadedFile $file){
        $this->file = $file;    
    }

    public function getFileNameToStore(){
        return $this->getFileName().'_'.time().'.'.$this->getExtension();
    }

    private function getFileName(){
        return pathinfo($this->file->getClientOriginalName(),PATHINFO_FILENAME);
    }

    private function getExtension(){
        return $this->file->getClientOriginalExtension();
    }

}
