<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'iso_code', 'country_code', 'flag_emoji'];
    protected $casts = ['name' => 'array'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}