<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrustedContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_number',
        'contact_email',
    ];

    // Define the inverse relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
