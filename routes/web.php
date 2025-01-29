<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;

Route::get('/', function () {
    return view('urlshortener');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Redirect from shortened url to site
Route::get('/u/{any}', [UrlShortenerController::class, 'handle']);

//Save shorten urls
Route::post('/url/shorten', [UrlShortenerController::class, 'store']);