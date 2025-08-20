<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['cv_id', 'name'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}