<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionimage extends Model
{
    public function qustion(){
        return $this->belongsTo('App\Question');
    }
}
