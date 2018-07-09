<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;

class VideoRepository extends BaseRepository{

    public function __construct(Video $model){
        $this->model = $model;
    }

    public function getVideosWithTitle($tile){
        return $this->model->where('title','LIKE','%'.$tile.'%')->get();
    }

}