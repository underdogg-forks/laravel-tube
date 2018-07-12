<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\CommentRate;
use App\Models\User;
use App\Repositories\Rate\CommentRateRepository;

class CommentRepository extends BaseRepository{

    public function __construct(Comment $model){
        $this->model = $model;
    }

    public function getVideoComments($video_id){
        $commentRate = new CommentRateRepository(new CommentRate);

        $comments =  parent::getWhere([
            'video_id' => $video_id
        ]);
        
        foreach($comments as $comment){
            $comment->creator_name = User::find($comment->user_id)->name;
            $comment->likes = $commentRate->countLikes($comment->id);
            $comment->dislikes = $commentRate->countDislikes($comment->id);
        }
        
        return $comments;
    }
}