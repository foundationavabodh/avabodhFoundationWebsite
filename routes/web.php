<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerRegistrationController;
use App\Http\Controllers\ProjectController;
use App\Models\Partner;
use App\Models\Slider;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Homepage swapped to the "index-4" design (resources/views/pages/home-4.blade.php).
    // Both pages.home (the original) and pages.home-3 (the previous design) are left in
    // place, untouched and unrouted, so either can be restored instantly by pointing this
    // back at it if home-4 needs to be rolled back.
    return view('pages.home-4', [
        'slides' => Slider::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get(),
    ]);
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/ngo', function () {
    return view('pages.ngo', [
        'partners' => Partner::active()->get(),
    ]);
})->name('ngo');

// Public NGO self-registration (the "NGO Information Collection Form"). Submissions
// are saved as pending and listed only after an admin approves them. Declared before
// /ngo/{partner:slug} so "register" is never treated as a slug.
Route::get('/ngo/register', [PartnerRegistrationController::class, 'create'])->name('ngo.register');
Route::post('/ngo/register', [PartnerRegistrationController::class, 'store'])
    ->name('ngo.register.store')
    ->middleware('throttle:5,10');

// Public detail page for a single NGO / partner ("Read More" on the /ngo cards).
Route::get('/ngo/{partner:slug}', [PartnerController::class, 'show'])->name('ngo.show');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Public "Send Us A Message" form submission (see ContactController + its
// StoreContactMessageRequest / ContactFormSubmitted notification). Throttled
// the same way the internship endpoints are, since this is a public,
// unauthenticated POST that emails the foundation's inbox.
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit')
    ->middleware('throttle:5,1');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::prefix('internships')->name('internships.')->group(function () {
    Route::get('/', [InternshipController::class, 'index'])->name('index');

    Route::post('/apply', [InternshipController::class, 'store'])
        ->name('apply')
        ->middleware('throttle:10,1');
});
