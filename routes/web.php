<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


/**
 * 'web' middleware applied to all routes
 *
 * @see \App\Providers\Route::mapWebRoutes
 */

 Livewire::setScriptRoute(function ($handle) {
    $base = request()->getBasePath();

    return Route::get($base . '/vendor/livewire/livewire/dist/livewire.min.js', $handle);
});

Route::get('/', function () {
    return view('home');
});
Route::get('/auth/register/{token?}', function ($token = null) {
    return view('auth.register.create', ['token' => $token]);
})->name('register');


Route::get('/auth/login', function () {
    return view('auth.login.create');
})->name('login');

 
Route::get('/register_new', function () {
    return view('auth.register.register_new');
})->name('register.new');

Route::get('features', fn () => view('pages.features'))->name('features');
Route::get('/pricing', fn () => view('pages.pricing'))->name('pricing');
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/blog', fn () => view('pages.blog'))->name('blog');