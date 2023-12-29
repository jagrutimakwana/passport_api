<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\passportController;

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

Route::get('/', function () {
    echo "Hello";
});

Route::get('/passport',[passportController::class,'allshow']); // datafetch http://127.0.0.1:8000/api/passport/

Route::post('/insertpassport',[passportController::class,'store']); // insert http://127.0.0.1:8000/api/insertpassport/

Route::post('/login',[passportController::class,'passport_login']); // login http://127.0.0.1:8000/api/login/

Route::put('/updatepassport/{id}',[passportController::class,'update']); // update http://127.0.0.1:8000/api/updatepassport/5

Route::delete('/passport/{id}',[passportController::class,'destroy']); // delete http://127.0.0.1:8000/api/passport/4

Route::get('/passport/{id}',[passportController::class,'single_show']); // edit

Route::get('/search/{key}',[passportController::class,'search']); // search

Route::put('/updatestatus/{id}',[passportController::class,'updatestatus']); // block unblock
