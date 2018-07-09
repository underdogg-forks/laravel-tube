<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rate;

class RateRepository extends BaseRepository{

    public function __construct(Rate $model){
        $this->model = $model;
    }

    public function countLikes($video_id){
        
        return $this->model->where([
            'video_id' => $video_id,
            'type' => 'L'
        ])->get()->count();
    }

    public function countDislikes($video_id){
        
        return $this->model->where([
            'video_id' => $video_id,
            'type' => 'D'
        ])->get()->count();
    }

}