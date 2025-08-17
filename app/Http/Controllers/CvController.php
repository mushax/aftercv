<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePersonalInfoRequest;
use App\Models\WorkExperience;
use App\Http\Requests\StoreWorkExperienceRequest;
use App\Models\Cv;
use Illuminate\Support\Facades\Auth;


class CvController extends Controller
{
    public function create()
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Find the user's first CV, or create a new one if it doesn't exist.
        // This is a temporary measure until we build multi-CV support.
        $cv = $user->cvs()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'title' => 'Default CV',
                'template' => 'default',
                'locale' => app()->getLocale(),
            ]
        );

        // Load the work experiences associated with this CV
        $workExperiences = $cv->workExperiences()->orderBy('start_date', 'desc')->get();

        return view('cv.create', [
            'workExperiences' => $workExperiences,
        ]);
    }
    public function storePersonalInfo(StorePersonalInfoRequest $request)
    {
        $user = $request->user();

        // Use updateOrCreate to either create a new profile or update the existing one.
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Condition to find the record
            $request->validated()     // Data to update or create
        );

        // For now, redirect back to the same page with a success message.
        // Later, we will redirect to the next step of the wizard.
        return to_route('cv.create', ['locale' => app()->getLocale()])
            ->with('status', 'Personal information saved successfully!');
    }
    public function storeWorkExperience(StoreWorkExperienceRequest $request)
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();
        $cv = $user->cvs()->first(); // Get the user's first CV

        $cv->workExperiences()->create($request->validated());

        return to_route('cv.create', ['locale' => app()->getLocale()])
            ->with('status_work_experience', 'Work experience added successfully!');
    }
}
