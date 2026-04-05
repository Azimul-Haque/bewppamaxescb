<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    public function payments(){
        return $this->hasMany('App\Models\Payment');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }

    public function meritlists(){
        return $this->hasMany('App\Models\Meritlist');
    }

    public function reportedquestions(){
        return $this->hasMany('App\Models\Reportedquestion');
    }

    public function blogs(){
        return $this->hasMany('App\Models\Blog');
    }

    public function ambassadorProfile()
    {
        // ১ জন ইউজারের ১টিই অ্যাম্বাসেডর প্রোফাইল থাকবে
        return $this->hasOne(AmbassadorProfile::class);
    }

    public function isAmbassador()
    {
        return $this->role === 'ambassador' && $this->ambassadorProfile !== null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password',
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

    protected static function boot()
    {
        parent::boot();

        // ইউজার তৈরি হওয়ার ঠিক আগে এই ফাংশনটি কল হবে
        static::creating(function ($user) {
            // যদি আগে থেকে কোনো কোড না থাকে, তবেই নতুন কোড তৈরি করবে
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateUniqueCode();
            }
        });
    }

    /**
     * একটি ইউনিক ৬ অক্ষরের মিক্সড কোড জেনারেট করার ফাংশন
     */
    public static function generateUniqueCode()
    {
        do {
            // ৬ অক্ষরের রেন্ডম স্ট্রিং (যেমন: X72B9P)
            $code = strtoupper(Str::random(6));
        } while (self::where('referral_code', $code)->exists()); // ডাটাবেসে চেক করবে ডুপ্লিকেট আছে কি না

        return $code;
    }
}
