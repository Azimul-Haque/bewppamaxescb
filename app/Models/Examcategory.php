<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examcategory extends Model
{
    public $timestamps = false;

    public function exams(){
        return $this->hasMany('App\Exam');
    }
}
