<?php 

namespace App\Repositories\Rate;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\CommentRate;

class VideoRateRepository extends BaseRepository{

    public function __construct(CommentRate $model){
        $this->model = $model;
    }
    
   public function createAuthLike($comment_id){
        
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'comment_id' => $comment_id,
            'type' => 'L'
        ]);
    }

    public function createAuthDislike($comment_id){
        
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'comment_id' => $comment_id,
            'type' => 'D'
        ]);
    }

    public function deleteRateAuth($comment_id){
        $this->model->where([
            'comment_id' => $comment_id,
            'user_id' => auth()->user()->id
        ]
        )->delete();
    }
    
    public function alreadyLiked($comment_id){
        if($this->model->where([
            'user_id' => auth()->user()->id,
            'comment_id' => $comment_id,
            'type' => 'L'    
        ])->get()->count() >0 ) return true;

        else return false;
    }

    public function alreadyDisliked($comment_id){
        if($this->model->where([
            'user_id' => auth()->user()->id,
            'comment_id' => $comment_id,
            'type' => 'D'    
        ])->get()->count() >0 ) return true;

        else return false;
    }
   
    public function countLikes($comment_id){
        
        return $this->model->where([
            'comment_id' => $comment_id,
            'type' => 'L'
        ])->get()->count();
    }

    public function countDislikes($comment_id){
        
        return $this->model->where([
            'comment_id' => $comment_id,
            'type' => 'D'
        ])->get()->count();
    }

}