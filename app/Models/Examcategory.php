<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examcategory extends Model
{
    public $timestamps = false;

    public function exams(){
        return $this->hasMany('App\Models\Exam');
    }
}
