<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function Courseexams(){
        return $this->hasMany('App\Courseexam');
    }

    public function meritlists(){
        return $this->hasMany('App\Meritlist');
    }
}
