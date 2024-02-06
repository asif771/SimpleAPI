<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('signUp', [UserController::class, 'register']);
Route::post('signIn', [UserController::class, 'login']);
Route::get('/articles',[ArticleController::class,'index']);
Route::get('/search/article/{name}',[ArticleController::class,'search']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/article',[ArticleController::class,'store']);
    Route::get('/article/{articleId}',[ArticleController::class,'show']);
    Route::put('/article/{articleId}',[ArticleController::class,'update']);
    Route::delete('/article/{articleId}',[ArticleController::class,'destroy']);
    Route::post('/logout',[UserController::class,'logout']);
});
