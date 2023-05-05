<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function topic(){
        return $this->belongsTo('App\Topic');
    }

    public function questionexplanation(){
        return $this->hasOne('App\Questionexplanation');
    }

    public function questionimage(){
        return $this->hasOne('App\Questionimage');
    }

    public function examquestion(){
        return $this->hasOne('App\Examquestion');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

    public function reportedquestions(){
        return $this->hasMany('App\Reportedquestion');
    }
}
