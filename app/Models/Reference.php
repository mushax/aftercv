<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $fillable = ['cv_id', 'name', 'job_title', 'company', 'phone', 'email'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}