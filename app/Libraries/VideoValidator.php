<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile as UploadedFile;

class VideoValidator
{
    private $video;
    private $validExtensions = ['mp4','mpeg','avi','3gpp'];

    public function __construct(UploadedFile $video){
        $this->video = $video;    
    }

    public function validate(){
        $fileExtension = $this->video->getClientOriginalExtension();

        if(in_array($fileExtension,$this->validExtensions) )
            return true;
        else
            return false;
    }
    
    public function getRedirectErrorMessage(){
        return 'Video must be of types: '.$this->getStringOfValidExtension();
    }
    
    public function getStringOfValidExtension(){
        $extensions = '';
        
        for($i=0; $i<count($this->validExtensions); $i++)
            $extensions.= $this->validExtensions[$i].', '; 
        
        return $extensions;
    }


}
