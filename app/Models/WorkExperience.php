<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'job_title',
        'company',
        'city',
        'country',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}