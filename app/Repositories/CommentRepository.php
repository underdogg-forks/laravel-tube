<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class CommentRepository extends BaseRepository{

    public function __construct(Comment $model){
        $this->model = $model;
    }

    public function getVideoComments($video_id){
        return parent::getWhere([
            'video_id' => $video_id
        ]);
    }
}