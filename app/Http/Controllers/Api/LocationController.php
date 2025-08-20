<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function cities(Country $country)
    {
        return response()->json($country->cities()->get()->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name[app()->getLocale()] ?? $city->name['en'],
            ];
        }));
    }
}