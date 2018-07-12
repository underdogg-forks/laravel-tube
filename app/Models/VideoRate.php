<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoRate extends Model
{
    public $table = 'video_rates';
    public $timestamps = false;
    public $guarded = ['id'];
}
