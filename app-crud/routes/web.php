<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//GetAll
Route::get('/' , [ListingController::class, 'index']);

//Show Create Form
Route::get('/listing/create',  [ListingController::class, 'create'] )->middleware('auth');

//Store Listing
Route::post('/listing',  [ListingController::class, 'store'] )->middleware('auth');

//Store Show Edit Form
Route::get('/listing/{listing}/edit',  [ListingController::class, 'edit'] )->middleware('auth');

//Update Listing
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listing/manage', [ListingController::class, 'manage'])->middleware('auth');

//Show Single Listing
Route::get('/listing/{listing}',  [ListingController::class, 'show'] );

//Show register create form
Route::get('/register', [UserController::class, 'create'] )->middleware('guest');

//Create New User
Route::post('/users', [UserController::class, 'store'] );

//Logut User
Route::post('/logout',[UserController::class, 'logout'] )->middleware('auth');

//Show Login Form
Route::get('/login',[UserController::class, 'login'] )->name('login')->middleware('guest');

//Log In User
Route::post('/users/authenticate' , [UserController::class, 'authenticate']);

