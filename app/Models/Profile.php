<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'father_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality_country_id',
        'residence_country_id',
        'phone_numbers',
        'emails',
        'profile_image_path',
        'passports',
        'addresses',
        'driving_license'
    ];

    protected $casts = [
        'first_name' => 'array',
        'father_name' => 'array',
        'last_name' => 'array',
        'phone_numbers' => 'array',
        'emails' => 'array',
        'passports' => 'array',
        'addresses' => 'array',
        'driving_license' => 'array',
    ];
}
