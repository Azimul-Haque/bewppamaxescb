<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meritlist extends Model
{
    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
