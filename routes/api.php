<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookBorrowController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\BookBorrowDetailsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/login_check', [UserController::class, 'getAuthenticatedUser']);

Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin,Customers']], function ()
{
    //SUPER ADMIN
    Route::group(['middleware' => ['jwt.verify:SuperAdmin']], function (){
    //DELETE
        Route::delete('/Students/{id}', [StudentsController::class, 'delete']);
        Route::delete('/Grade/{id}', [GradeController::class, 'delete']);
        Route::delete('/Book/{id}', [BookController::class, 'delete']);
        Route::delete('/BookBorrow/{id}', [BookBorrowController::class, 'delete']);
        Route::delete('/BookReturn/{id}', [BookReturnController::class, 'delete']);
        Route::delete('/BookBorrowDetails/{id}', [BookBorrowDetailsController::class, 'delete']);
});

    //ADMIN
    Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin']],function(){
    //POST
        Route::post('/Students', [StudentsController::class, 'store']);
        Route::post('/Grade', [GradeController::class, 'store']);
        Route::post('/Book', [BookController::class, 'store']);
        Route::post('/BookBorrow', [BookBorrowController::class, 'store']);
        Route::post('/BookReturn', [BookReturnController::class, 'store']);
        Route::post('/BookBorrowDetails', [BookBorrowDetailsController::class, 'store']);

    //PUT
        Route::put('/Students/{id}', [StudentsController::class, 'update']);
        Route::put('/Grade/{id}', [GradeController::class, 'update']);
        Route::put('/Book/{id}', [BookController::class, 'update']);
        Route::put('/BookBorrow/{id}', [BookBorrowController::class, 'update']);
        Route::get('/BookReturn/{id}', [BookReturnController::class, 'update']);
        Route::put('/BookBorrowDetails/{id}', [BookBorrowDetailsController::class, 'update']);
});
    //POST
    Route::post('/addItem/{id}', [BookBorrowController::class, 'addItem']);
    //GET
    Route::get('/Students', [StudentsController::class, 'show']);
    Route::get('/Students/{id}', [StudentsController::class, 'detail']);

    Route::get('/Grade', [GradeController::class, 'show']);
    Route::get('/Grade/{id}', [GradeController::class, 'detail']);

    Route::get('/Book', [BookController::class, 'show']);
    Route::get('/Book/{id}', [BookController::class, 'detail']);

    Route::get('/BookBorrow', [BookBorrowController::class, 'show']);
    Route::get('/BookBorrow/{id}', [BookBorrowController::class, 'detail']);

    Route::get('/BookReturn', [BookReturnController::class, 'show']);
    Route::get('/BookReturn/{id}', [BookReturnController::class, 'detail']);

    Route::get('/BookBorrowDetails', [BookBorrowDetailsController::class, 'show']);
    Route::get('/BookBorrowDetails/{id}', [BookBorrowDetailsController::class, 'detail']);

});