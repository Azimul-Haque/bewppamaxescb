<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reportedquestion extends Model
{
    public $timestamps = true;
    
    public function question(){
        return $this->belongsTo('App\Question');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
