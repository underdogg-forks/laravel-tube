<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rate;

class RateRepository extends BaseRepository{

    public function __construct(Rate $model){
        $this->model = $model;
    }

    public function createAuthLike($video_id){
        
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'L'
        ]);
    }

    public function createAuthDislike($video_id){
        
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'D'
        ]);
    }

    public function deleteRate($video_id){
        $this->model->where('video_id','=',$video_id)->delete();
    }
    
    public function alreadyLiked($video_id){
        if($this->model->where([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'L'    
        ])->get()->count() >0 ) return true;

        else return false;
    }

    public function alreadyDisliked($video_id){
        if($this->model->where([
            'user_id' => auth()->user()->id,
            'video_id' => $video_id,
            'type' => 'D'    
        ])->get()->count() >0 ) return true;

        else return false;
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