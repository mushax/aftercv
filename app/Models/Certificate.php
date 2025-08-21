<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = ['cv_id', 'name', 'issuing_organization', 'issue_date'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}