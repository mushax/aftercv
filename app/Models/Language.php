<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'name',
        'level',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}