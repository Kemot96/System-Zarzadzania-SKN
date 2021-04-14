<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ClubMemberController;
use App\Http\Controllers\ReportController;
use App\Models\Club;


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
Auth::routes();
Route::resource('users', UserController::class);
Route::resource('clubs', ClubController::class);
Route::resource('sections', SectionController::class);
Route::resource('clubMembers', ClubMemberController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/index', [App\Http\Controllers\ClubController::class, 'frontPage'])->name('index');

Route::get('/{club}', [App\Http\Controllers\ClubController::class, 'mainPage'])->middleware(['auth', 'club.access'])->name('clubMainPage');

Route::post('/{club}', [App\Http\Controllers\FileController::class, 'store'])->middleware(['auth', 'club.access'])->name('clubMainPageFile.store');

Route::get('/{club}/editReport', [App\Http\Controllers\ReportController::class, 'edit'])->middleware(['auth'])->name('clubEditReport.edit');
Route::post('/{club}/editReport', [App\Http\Controllers\ReportController::class, 'store'])->middleware(['auth'])->name('clubEditReport.store');
//
Route::get('/{club}/members', [App\Http\Controllers\ClubMemberController::class, 'index2'])->middleware(['auth'])->name('clubMembers.index2');
Route::patch('/{club}/members/{clubMember}', [App\Http\Controllers\ClubMemberController::class, 'update2'])->middleware(['auth'])->name('clubMembers.update2');
Route::delete('/{club}/members/{clubMember}', [App\Http\Controllers\ClubMemberController::class, 'destroy2'])->middleware(['auth'])->name('clubMembers.destroy2');
//
Route::get('/{club}/join', [App\Http\Controllers\ClubMemberController::class, 'joinPage'])->name('joinClub');

Route::get('/{club}/join/send', [App\Http\Controllers\ClubMemberController::class, 'join'])->name('join');

require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

