<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
    'register' => false,
    'reset' => false
]);

// User Controller
Route::get('/', 'DashboardController@home')->name('home');
Route::get('/masuk', 'DashboardController@index')->name('masuk')->middleware('votingcheck');
Route::post('/masuk2', 'DashboardController@masuk');

// Admin Controller
    //Voting Controller
        Route::get('/admin', 'AdminController@redirectindex');
        Route::get('/administrator', 'AdminController@index')->name('adminDashboard');
        Route::get('/administrator/voting', 'AdminController@votingpage')->name('adminVoting');
        Route::get('/administrator/votingedit', 'AdminController@votingpageedit');
        Route::post('/administrator/votingpost', 'AdminController@votingpage_post');

    // Kandidat Controller
        Route::get('/administrator/kandidat', 'AdminController@kandidat_index')->name('adminKandidat');
        Route::post('/administrator/kandidat/addtim', 'AdminController@kandidat_addtim');
        Route::post('/administrator/kandidat/deltim', 'AdminController@kandidat_deltim');
        Route::get('/administrator/kandidat/edittim/{id}', 'AdminController@kandidat_edittim')->name('editTim');
        Route::post('/administrator/kandidat/tim', 'AdminController@kandidat_edittim_post');
        Route::post('/administrator/kandidat/addkandidat', 'AdminController@kandidat_addkandidat');
        
