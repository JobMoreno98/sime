<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AxisController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\ThemeController;

include_once 'auth.php';

Route::get('/', [HomeController::class, 'index'])->name('inicio');


Route::get('/indicadores', [HomeController::class, 'indicators'])->name('indicadores-user');
Route::get('/indicador/{indicador}', [IndicatorController::class, 'show_user'])->name('indicatores.show');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::resource('ejes', AxisController::class)->names('ejes');

    
    Route::get('/ejes', [AxisController::class, 'index'])
        ->name('admin.ejes');

    Route::resource('tematicas', ThemeController::class)->names('tematicas');

    Route::resource('indicadores', IndicatorController::class)->names('indicadores')->parameters(['indicadores' => 'indicador']);

    Route::post('indicadores/{indicador}/avance', [IndicatorController::class, 'storeProgress'])
        ->name('indicadores.avance');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::get('/detalle-indicador/{eje}/{tematica}', function ($eje, $tematica) {
    return view('pages.detalle-indicador', [
        'eje' => $eje,
        'tematica' => $tematica,
    ]);
})->name('detalle-indicador');


// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// pages
// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// authentication pages
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

/*
Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');
*/