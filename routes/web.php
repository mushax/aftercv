<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Log;


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
    });

    require __DIR__ . '/auth.php';
});
// ==========================================================