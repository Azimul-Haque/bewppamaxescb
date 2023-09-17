<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;

    public function blog() {
      return $this->belongsTo('App\Blog');
    } 
}
