<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function blogcategory() {
      return $this->belongsTo('App\Models\Blogcategory');
    }
}
