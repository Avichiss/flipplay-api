<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// CRUD Media.
// 'media' bentuk jamaknya "medium" menurut Laravel, jadi nama parameter route
// dipaksa tetap {media} supaya Route Model Binding ke `Media $media` bekerja.
Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);

// Pengguna (hanya baca)
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

// Custom action: koleksi media milik pengguna (mengubah relasi pivot)
Route::get('/users/{user}/collection', [UserController::class, 'collection']);
Route::post('/users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('/users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);
