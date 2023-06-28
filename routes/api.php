<?php

use App\Http\Controllers\UrlShorterController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/short-urls', [UrlShorterController::class, 'shortUrl'])
->middleware(ValidateToken::class);
