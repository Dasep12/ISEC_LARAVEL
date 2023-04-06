<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/guardtour', function (Request $request) {
    return $request->user();
<<<<<<< HEAD
});

=======
});
>>>>>>> ad9ebfa0f56bc63ce53fb64d4baf6e89c240a5ff
