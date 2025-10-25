<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examquestion extends Model
{
    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }

    public function question(){
        return $this->belongsTo('App\Models\Question');
    }
}
