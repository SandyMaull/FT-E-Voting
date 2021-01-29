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
Route::get('/masuk', 'Auth\VotersLoginController@showLoginForm')->name('masuk')->middleware('votingcheck');
Route::get('/masuk/{token}', 'DashboardController@redirectLoginAfterRegis')->middleware('votingcheck');
Route::post('/masuk2', 'Auth\VotersLoginController@login');
Route::post('/logout2', 'Auth\VotersLoginController@logout')->name('logoutvoters');
Route::get('/beranda', 'DashboardController@beranda')->name('beranda');
Route::get('/register', 'DashboardController@register_index')->name('register');
Route::post('/register_post', 'DashboardController@register_post');

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
        // Route::post('/administrator/kandidat/deltim', 'AdminController@kandidat_deltim');
        Route::post('/administrator/kandidat/edittim', 'AdminController@kandidat_edittim');
        Route::post('/administrator/kandidat/addkandidat', 'AdminController@kandidat_addkandidat');
        Route::post('/administrator/kandidat/editkandidat', 'AdminController@kandidat_editkandidat');
        Route::post('/administrator/kandidat/delkandidat', 'AdminController@kandidat_delkandidat');
        
    // Voters Controller
        Route::get('/admin/voters/verif', 'AdminController@voter_verif')->name('adminVotersVer');
        Route::post('/admin/voters/revoke_verif', 'AdminController@voter_revoke_verif');
        Route::get('/admin/voters/unverif', 'AdminController@voter_unverif')->name('adminVotersunVer');
        Route::post('/admin/voters/unverif_post', 'AdminController@voter_unverif_post');
        Route::post('/admin/voters/delete_unverif', 'AdminController@voter_delete_unverif');

    // GENERATE QR CODE
        Route::get('/administrator/qrcode', 'AdminController@getQRCodeWa');