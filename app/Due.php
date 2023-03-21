<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    public function creditor(){
        return $this->belongsTo('App\Creditor');
    }
}
