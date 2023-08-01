<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function examcategory(){
        return $this->belongsTo('App\Examcategory');
    }

    public function examquestions(){
        return $this->hasMany('App\Examquestion');
    }

    public function course(){
        return $this->hasOne('App\Course');
    }

    public function courseexams(){
        return $this->hasMany('App\Courseexam');
    }

    public function meritlists(){
        return $this->hasMany('App\Meritlist');
    }
}
