<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courseexam extends Model
{
    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
}
