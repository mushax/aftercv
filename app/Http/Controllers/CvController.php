<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\StorePersonalInfoRequest;
use App\Http\Requests\StoreWorkExperienceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    private function prepareCvData()
    {
        /** @var \App\Models\User $user */
    $user = Auth::user();
    $cv = $user->cvs()->with(['workExperiences', 'education', 'skills', 'languages', 'projects', 'certificates', 'references'])->firstOrCreate(
        ['user_id' => $user->id],
        ['title' => 'Default CV', 'template' => 'default', 'locale' => app()->getLocale()]
    );
    
    $countries = Country::all()->map(function ($country) {
        // استخدم دالة لتحويل ISO code إلى emoji
        $flagEmoji = $this->isoToEmoji(strtoupper($country->iso_code));
        
        return [
            'id' => $country->id,
            'name' => $country->name[app()->getLocale()] ?? $country->name['en'],
            'iso_code' => $country->iso_code,
            'flag_emoji' => $flagEmoji,
            'country_code' => $country->country_code,
        ];
    });
    return [
        'cv' => $cv,
        'workExperiences' => $cv->workExperiences,
        'education' => $cv->education,
        'skills' => $cv->skills,
        'languages' => $cv->languages,
        'projects' => $cv->projects,
        'certificates' => $cv->certificates,
        'references' => $cv->references,
        'countries' => $countries,
    ];
    }

    public function showPersonal()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'personal');
    }

    public function showExperience()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'experience');
    }

    public function showEducation()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'education');
    }

    public function showSkills()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'skills');
    }

    public function showLanguages()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'languages');
    }

    public function showProjects()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'projects');
    }

    public function showCertificates()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'certificates');
    }

    public function showReferences()
    {
        $data = $this->prepareCvData();
        return view('cv.builder-layout', $data)->with('currentStep', 'references');
    }

    public function storePersonalInfo(StorePersonalInfoRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $validated = $request->validated();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => ['en' => $validated['first_name_en'], 'ar' => $validated['first_name_ar']],
                'last_name' => ['en' => $validated['last_name_en'], 'ar' => $validated['last_name_ar']],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'nationality_country_id' => $validated['nationality_country_id'],
                'residence_country_id' => $validated['residence_country_id'],
                'phone_numbers' => [['country_id' => $validated['phone_country_id'], 'number' => $validated['phone_number']]],
            ]
        );

        $cv = $user->cvs()->first();
        $cv->update(['job_title' => $validated['job_title'], 'summary' => $validated['summary']]);
        
        return to_route('cv.builder.experience', ['locale' => app()->getLocale()])
            ->with('status', 'Personal information saved successfully!');
    }

    public function storeWorkExperience(StoreWorkExperienceRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cv = $user->cvs()->first();
        $cv->workExperiences()->create($request->validated());

        // CORRECTED REDIRECT
        return to_route('cv.builder.experience', ['locale' => app()->getLocale()])
            ->with('status_work_experience', 'Work experience added successfully!');
    }

    public function storeEducation(StoreEducationRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cv = $user->cvs()->first();
        $cv->education()->create($request->validated());

        // CORRECTED REDIRECT
        return to_route('cv.builder.education', ['locale' => app()->getLocale()])
            ->with('status_education', 'Education added successfully!');
    }

    public function storeSkill(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cv = $user->cvs()->first();
        $cv->skills()->create($request->only('name'));

        // CORRECTED REDIRECT
        return to_route('cv.builder.skills', ['locale' => app()->getLocale()])
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

        // CORRECTED REDIRECT
        return to_route('cv.builder.languages', ['locale' => app()->getLocale()])
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

        // CORRECTED REDIRECT
        return to_route('cv.builder.projects', ['locale' => app()->getLocale()])
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

        // CORRECTED REDIRECT
        return to_route('cv.builder.certificates', ['locale' => app()->getLocale()])
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

        // CORRECTED REDIRECT
        return to_route('cv.builder.references', ['locale' => app()->getLocale()])
            ->with('status_reference', 'Reference added successfully!');
    }

    public function downloadPdf()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate();
        $cv = $user->cvs()->with([
            'workExperiences', 'education', 'skills', 'languages', 
            'projects', 'certificates', 'references'
        ])->first();

        if (!$cv) {
            return redirect()->back()->with('error', 'Please fill out your CV first.');
        }

        $data = ['user' => $user, 'cv' => $cv, 'profile' => $profile];
        $pdf = Pdf::loadView('cv.templates.default', $data);
        $firstName = $profile->first_name['en'] ?? 'cv';
        $lastName = $profile->last_name['en'] ?? time();

        return $pdf->download('cv-' . $firstName . '-' . $lastName . '.pdf');
    }

private function isoToEmoji($countryCode)
{
    return preg_replace_callback('/[A-Z]/', function ($matches) {
        return mb_chr(ord($matches[0]) + 127397);
    }, $countryCode);
}
}
