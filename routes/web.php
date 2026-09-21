<?php

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
