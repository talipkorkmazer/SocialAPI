<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});


Route::group([
    'middleware' => 'api.token',
    'namespace' => 'App\Http\Controllers',
], function () {
    /** Users Routes  */
    /*Route::get('users', [UserController::class, 'index']); // List Users*/
    Route::get('users/{id}', [UserController::class, 'show']); // Detail of User
    Route::put('users', [UserController::class, 'update']); // Update User
    Route::post('users/picture', [UserController::class, 'updateProfilePicture']);
    Route::delete('users', [UserController::class, 'destroy']); // Delete User
    /** Users Routes  */

    /** User Follow Routes  */
    Route::get('followers', [FollowerController::class, 'index']); // List followed Users
    Route::post('followers/{id}', [FollowerController::class, 'store']); // Follow User
    Route::delete('followers/{id}', [FollowerController::class, 'destroy']); // Unfollow User
    /** User Follow Routes  */

    /** Post Routes  */
    Route::get('posts', [PostController::class, 'index']); // List Posts
    Route::post('posts', [PostController::class, 'store']); // Create Post
    Route::get('posts/{id}', [PostController::class, 'show']); // Detail of Post
    Route::put('posts/{id}', [PostController::class, 'update']); // Update Post
    Route::delete('posts/{id}', [PostController::class, 'destroy']); // Delete Post
    Route::get('posts/user/{username}', [PostController::class, 'list']); // List user Posts
    /** Post Routes  */

    /** Like Routes  */
    Route::get('likes', [LikeController::class, 'index']); // List liked Posts
    Route::post('likes/{id}', [LikeController::class, 'store']); // Like Post
    Route::delete('likes/{id}', [LikeController::class, 'destroy']); // Unlike Post
    /** Like Routes  */


});