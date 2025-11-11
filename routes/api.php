<?php

use App\Http\Controllers\FilmsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ActorsController;
use App\Http\Controllers\DirectorsController;
use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;




Route::get('/films', [FilmsController::class, 'index']);
Route::post('/films', [FilmsController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/films/{id}', [FilmsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/films/{id}', [FilmsController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/series', [SeriesController::class, 'index']);
Route::post('/series', [SeriesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/series/{id}', [SeriesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/series/{id}', [SeriesController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/actors', [ActorsController::class, 'index']);
Route::post('/actors', [ActorsController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/actors/{id}', [ActorsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/actors/{id}', [ActorsController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/directors', [DirectorsController::class, 'index']);
Route::post('/directors', [DirectorsController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/directors/{id}', [DirectorsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/directors/{id}', [DirectorsController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');