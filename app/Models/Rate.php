<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public $table = 'rates';
    public $timestamps = false;
    public $guarded = ['id'];
}
