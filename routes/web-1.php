<?php

use App\Http\Controllers\InternshipController;
use App\Http\Controllers\ProjectController;
use App\Models\Slider;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Homepage swapped to the "index-3" design (resources/views/pages/home-3.blade.php).
    // The original pages.home view is left in place, untouched and unrouted, so it can be
    // restored instantly by pointing this back at it if home-3 needs to be rolled back.
    return view('pages.home-3', [
        'slides' => Slider::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get(),
    ]);
})->name('home');

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
