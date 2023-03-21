<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    // public function balances(){
    //     return $this->hasMany('App\Balance');
    // }

    // public function balances2(){
    //     return $this->hasMany('App\Balance', 'receiver_id', 'id');
    // }

    // public function expenses(){
    //     return $this->hasMany('App\Expense');
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
