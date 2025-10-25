<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function topic(){
        return $this->belongsTo('App\Models\Topic');
    }

    public function questionexplanation(){
        return $this->hasOne('App\Models\Questionexplanation');
    }

    public function questionimage(){
        return $this->hasOne('App\Models\Questionimage');
    }

    public function examquestion(){
        return $this->hasOne('App\Models\Examquestion');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function reportedquestions(){
        return $this->hasMany('App\Models\Reportedquestion');
    }
}
