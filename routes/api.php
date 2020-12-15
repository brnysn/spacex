<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CapsuleController;


// Route::group(['middleware' =>'auth:api', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'capsules'], function () {
        Route::get('/', [CapsuleController::class, 'index'])->name('capsules.index');
        Route::get('?{status=}', [CapsuleController::class, 'index'])->name('capsules.index');
        Route::get('/{user_id?}', [CapsuleController::class, 'show'])->name('capsules.show');
    });
// });

// Route::get('/users', function () {
//     return UserResource::collection(User::all());
// });


// Route::get('/user/{user}', function (User $user) {
//     return $user;
// });


// Route::get('/user/{id}', function ($id) {
//     return new UserResource(User::findOrFail($id));
// });