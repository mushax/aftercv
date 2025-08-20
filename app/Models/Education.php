<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    // Use a different table name convention
    protected $table = 'education';

    protected $fillable = [
        'cv_id',
        'degree',
        'institution',
        'city',
        'start_date',
        'end_date',
        'description',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}