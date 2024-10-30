<?php

use App\Http\Controllers\publikasiCOntroller;
use Illuminate\Support\Facades\Route;

Route::get('/', [publikasiCOntroller::class, 'index']);
Route::post('/post', [publikasiCOntroller::class, 'store']);
