<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentRate extends Model
{
    public $table = 'comment_rates';
    public $timestamps = false;
    public $guarded = ['id'];
}
