<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbassadorProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance', 'total_earned'];

    // এই প্রোফাইলটি কোন ইউজারের, তা জানার জন্য রিলেশন
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
