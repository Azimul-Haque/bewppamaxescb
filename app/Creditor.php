<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    public function dues(){
        return $this->hasMany('App\Due');
    }
}
