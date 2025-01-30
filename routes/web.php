<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;

Route::get('/', function () {
    return view('urlshortener');
});

Route::get('/list', function () {
    return view('userurllist');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Redirect from shortened url to site
Route::get('/u/{any}', [UrlShortenerController::class, 'handle']);

//Save shorten urls
Route::post('/url/shorten', [UrlShortenerController::class, 'store']);

//Get shorten urls
Route::get('/url_list/{id}', [UrlShortenerController::class, 'getUserUrls']);