<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'payment_method', 
        'payment_number', 'status'
    ];

    // রিলেশন: কোন ইউজার টাকা দাবি করেছেন?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
