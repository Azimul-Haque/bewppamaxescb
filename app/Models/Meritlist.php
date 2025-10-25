<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meritlist extends Model
{
    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
