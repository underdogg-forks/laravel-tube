<?php 

namespace App\Repositories\Rate;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\VideoRate;

class VideoRateRepository extends BaseRepository{

    public function __construct(VideoRate $model){
        $this->model = $model;
    }

    public function getLikesPercentage($id){
        
        $likes = $this->countLikes($id);
        $dislikes = $this->countDislikes($id);

        if($likes+$dislikes==0) return 0;
        
        return round($likes/($likes+$dislikes)*100,2);
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

    public function deleteRateAuth($video_id){
        $this->model->where([
            'video_id' => $video_id,
            'user_id' => auth()->user()->id
        ]
        )->delete();
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