<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class CommentRepository extends BaseRepository{

    public function __construct(Comment $model){
        $this->model = $model;
    }
}