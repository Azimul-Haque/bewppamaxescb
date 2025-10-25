<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courseexam extends Model
{
    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }
}
