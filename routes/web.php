<?php

use App\Http\Controllers\publikasiCOntroller;
use Illuminate\Support\Facades\Route;

Route::get('/', [publikasiCOntroller::class, 'index']);
Route::post('https://deploy-test-vercel-omega.vercel.app/post', [publikasiCOntroller::class, 'store']);
