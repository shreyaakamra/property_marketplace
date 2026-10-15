<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'properties' => \App\Models\Property::where('is_active', true)->latest()->take(6)->get(),
    ]);
})->name('home');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');

use App\Http\Controllers\RequirementController;

Route::prefix('shared-spaces')->name('shared-spaces.')->group(function () {
    Route::get('/all', [RequirementController::class, 'index'])->name('index');
    Route::get('/post', [RequirementController::class, 'create'])->name('create');
    Route::post('/', [RequirementController::class, 'store'])->name('store');
    Route::get('/{requirement}', [RequirementController::class, 'show'])->name('show');
});
Route::get('/', function () {
    return view('home', [
        'properties' => \App\Models\Property::where('is_active', true)->latest()->take(6)->get(),
        'requirements' => \App\Models\PropertyRequirement::where('is_active', true)->latest()->take(4)->get(),
    ]);
})->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/why-us', 'why-us')->name('why-us');
Route::view('/terms', 'terms')->name('terms');
use Illuminate\Http\Request;

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'message' => 'required|string|max:2000',
    ]);
    return redirect()->route('contact')->with('success', 'Thanks — your message is in! We\'ll get back to you soon.');
})->name('contact.submit');