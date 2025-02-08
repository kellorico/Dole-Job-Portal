<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'gender', 'date_of_birth', 'address',
        'city', 'state', 'country', 'zip_code', 'about_me'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
