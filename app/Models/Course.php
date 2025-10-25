<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function Courseexams(){
        return $this->hasMany('App\Models\Courseexam');
    }

    public function meritlists(){
        return $this->hasMany('App\Models\Meritlist');
    }
}
