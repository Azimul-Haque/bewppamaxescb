<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionexplanation extends Model
{
    public function qustion(){
        return $this->belongsTo('App\Question');
    }
}
