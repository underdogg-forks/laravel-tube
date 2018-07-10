<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;

class CommentRepository extends BaseRepository{

    public function __construct(Comment $model){
        $this->model = $model;
    }

    public function getVideoComments($video_id){
        $comments =  parent::getWhere([
            'video_id' => $video_id
        ]);
        
        foreach($comments as $comment){
            $comment->creator_name = User::find($comment->user_id)->name;
        }
        
        return $comments;
    }
}