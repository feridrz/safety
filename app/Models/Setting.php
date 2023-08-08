<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flashlight',
        'voice_announcement',
        'send_location',
        'send_live_location'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $rules = [
                'flashlight' => 'required|boolean',
                'voice_announcement' => 'required|boolean',
                'send_location' => 'required|boolean',
                'send_live_location' => 'required|boolean',
            ];

            $validator = Validator::make($model->attributesToArray(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }


}
