<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\LocationController;



Route::get('/', function () {
    return redirect(app()->getLocale());
});

// ================== THE CORRECT STRUCTURE ==================
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => function (Request $request, $next) {
        $locale = $request->route('locale');
        if (in_array($locale, config('app.supported_locales', ['en', 'ar']))) {
            App::setLocale($locale);
        }
        return $next($request);
    }
], function () {

    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('/privacy-policy', function () {
        return view('legal.privacy-policy');
    })->name('privacy.policy');

    Route::get('/terms-of-service', function () {
        return view('legal.terms-of-service');
    })->name('terms.service');
    // كل الروابط داخل هذه المجموعة ستستفيد من تحديد اللغة تلقائيا
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/cv/create', [CvController::class, 'create'])->name('cv.create');
        Route::post('/cv/create/personal-info', [CvController::class, 'storePersonalInfo'])->name('cv.storePersonalInfo');
        Route::post('/cv/create/work-experience', [CvController::class, 'storeWorkExperience'])->name('cv.storeWorkExperience');
        Route::post('/cv/create/education', [CvController::class, 'storeEducation'])->name('cv.storeEducation');
        Route::post('/cv/create/skill', [CvController::class, 'storeSkill'])->name('cv.storeSkill');
        Route::post('/cv/create/language', [CvController::class, 'storeLanguage'])->name('cv.storeLanguage');
        Route::get('/countries/{country}/cities', [LocationController::class, 'cities'])->name('api.countries.cities');
        Route::post('/cv/create/project', [CvController::class, 'storeProject'])->name('cv.storeProject');
        Route::post('/cv/create/certificate', [CvController::class, 'storeCertificate'])->name('cv.storeCertificate');
        Route::post('/cv/create/reference', [CvController::class, 'storeReference'])->name('cv.storeReference');
        Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
Route::get('/cv/download', [CvController::class, 'downloadPdf'])->name('cv.download');


    });

    require __DIR__ . '/auth.php';
});
// ==========================================================