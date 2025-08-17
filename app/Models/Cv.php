<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'template',
        'locale',
        'public_url_hash',
        'is_public',
    ];
    
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }
}