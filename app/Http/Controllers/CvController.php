<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePersonalInfoRequest;
use App\Models\WorkExperience;
use App\Http\Requests\StoreWorkExperienceRequest;
use App\Http\Requests\StoreEducationRequest; 
use App\Models\Cv;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use Barryvdh\DomPDF\Facade\Pdf;


class CvController extends Controller
{
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cv = $user->cvs()->with(['workExperiences', 'education', 'skills', 'languages', 'projects', 'certificates','references'])->firstOrCreate(
            ['user_id' => $user->id],
            ['title' => 'Default CV', 'template' => 'default', 'locale' => app()->getLocale()]
        );
        
        $countries = Country::all()->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name[app()->getLocale()] ?? $country->name['en'],
                'flag_emoji' => $country->flag_emoji,
                'country_code' => $country->country_code, // <<< THE FIX IS HERE
            ];
        });

        return view('cv.create', [
            'cv' => $cv,
            'workExperiences' => $cv->workExperiences,
            'education' => $cv->education,
            'skills' => $cv->skills,
            'languages' => $cv->languages,
            'projects' => $cv->projects,
            'certificates' => $cv->certificates,
            'references' => $cv->references,
            'countries' => $countries,
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
    public function storeEducation(StoreEducationRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $cv = $user->cvs()->first();

        $cv->education()->create($request->validated());
        
        return to_route('cv.create', ['locale' => app()->getLocale()])
            ->with('status_education', 'Education added successfully!');
    }
    public function storeSkill(Request $request)
{
    $request->validate(['name' => 'required|string|max:255']);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->first();

    $cv->skills()->create($request->only('name'));

    return to_route('cv.create', ['locale' => app()->getLocale()])
        ->with('status_skill', 'Skill added successfully!');
}
public function storeLanguage(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'level' => 'required|string|in:Native,Fluent,Intermediate,Beginner',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->first();

    $cv->languages()->create($request->only('name', 'level'));

    return to_route('cv.create', ['locale' => app()->getLocale()])
        ->with('status_language', 'Language added successfully!');

}
public function storeProject(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'link' => 'nullable|url|max:255',
        'description' => 'nullable|string',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->first();

    $cv->projects()->create($request->only('name', 'link', 'description'));

    return to_route('cv.create', ['locale' => app()->getLocale()])
        ->with('status_project', 'Project added successfully!');
}
public function storeCertificate(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'issuing_organization' => 'required|string|max:255',
        'issue_date' => 'required|date_format:Y-m',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->first();

    $cv->certificates()->create($request->only('name', 'issuing_organization', 'issue_date'));

    return to_route('cv.create', ['locale' => app()->getLocale()])
        ->with('status_certificate', 'Certificate added successfully!');
}
public function storeReference(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'job_title' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->first();

    $cv->references()->create($request->all());

    return to_route('cv.create', ['locale' => app()->getLocale()])
        ->with('status_reference', 'Reference added successfully!');
}
public function downloadPdf()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // تأكد من إنشاء الملف الشخصي إذا لم يكن موجودًا
    $profile = $user->profile()->firstOrCreate();

    // قم بتحميل السيرة الذاتية مع كل علاقاتها
    $cv = $user->cvs()->with([
        'workExperiences', 
        'education', 
        'skills', 
        'languages', 
        'projects', 
        'certificates', 
        'references'
    ])->first();

    if (!$cv) {
        return redirect()->back()->with('error', 'Please fill out your CV first.');
    }

    $data = [
        'user' => $user,
        'cv' => $cv,
        'profile' => $profile, // نمرر الملف الشخصي بشكل مباشر وآمن
    ];

    $pdf = PDF::loadView('cv.templates.default', $data);

    // إنشاء اسم ملف آمن
    $firstName = $profile->first_name['en'] ?? 'cv';
    $lastName = $profile->last_name['en'] ?? time();
    
    return $pdf->download('cv-'. $firstName .'-'. $lastName .'.pdf');
}
}
