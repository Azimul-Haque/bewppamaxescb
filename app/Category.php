<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function site(){
        return $this->belongsTo('App\Site');
    }

    public function expenses(){
        return $this->hasMany('App\Expense');
    }
}
