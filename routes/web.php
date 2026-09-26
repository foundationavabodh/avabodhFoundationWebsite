<?php

use App\Http\Controllers\InternshipController;
use App\Http\Controllers\ProjectController;
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

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::prefix('internships')->name('internships.')->group(function () {
    Route::get('/', [InternshipController::class, 'index'])->name('index');

    // Small AJAX endpoints behind the "Apply for Internship" form's email
    // verification step (Part 3) -- issuing/checking a code, not the application
    // itself, which is a normal POST below. Throttled (Laravel's built-in limiter,
    // no new package) so the code-sending endpoint in particular can't be used to
    // spam arbitrary inboxes.
    Route::post('/verify-email/send', [InternshipController::class, 'sendVerificationCode'])
        ->name('verify-email.send')
        ->middleware('throttle:5,1');
    Route::post('/verify-email/confirm', [InternshipController::class, 'confirmVerificationCode'])
        ->name('verify-email.confirm')
        ->middleware('throttle:10,1');

    Route::post('/apply', [InternshipController::class, 'store'])
        ->name('apply')
        ->middleware('throttle:10,1');
});
