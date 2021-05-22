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

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('clubs', ClubController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('clubMembers', ClubMemberController::class);
});

Route::get('/', [App\Http\Controllers\ClubController::class, 'frontPage'])->name('index');


Route::get('/secretariat/reports-for-approval', [App\Http\Controllers\ReportController::class, 'showReportsForApprovalSecretariat'])->name('secretariat.showReports');
Route::patch('secretariat/reports-for-approval/{report}', [App\Http\Controllers\ReportController::class, 'ReportActionAsSecretariat'])->name('secretariat.reportAction');

Route::get('/vice-rector/reports-for-approval', [App\Http\Controllers\ReportController::class, 'showReportsForApprovalViceRector'])->name('vice-rector.showReports');
Route::patch('vice-rector/reports-for-approval/{report}', [App\Http\Controllers\ReportController::class, 'ReportActionAsViceRector'])->name('vice-rector.reportAction');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/{club}', [App\Http\Controllers\ClubController::class, 'mainPage'])->middleware(['auth', 'club.access'])->name('clubMainPage');

Route::post('/{club}', [App\Http\Controllers\FileController::class, 'store'])->middleware(['auth', 'club.access'])->name('clubMainPageFile.store');

Route::get('/{club}/reports-for-approval', [App\Http\Controllers\ReportController::class, 'showReportsForApprovalForClub'])->middleware(['auth'])->name('clubReport.showReportsForApproval');
Route::patch('/{club}/reports-for-approval/{report}', [App\Http\Controllers\ReportController::class, 'ReportActionAsSupervisor'])->middleware(['auth'])->name('clubReport.ReportActionAsSupervisor');
Route::get('/{club}/createReport', [App\Http\Controllers\ReportController::class, 'create'])->middleware(['auth'])->name('clubReport.create');
Route::get('/{club}/{report}/editReport', [App\Http\Controllers\ReportController::class, 'edit'])->middleware(['auth'])->name('clubReport.edit');
Route::post('/{club}/createReport', [App\Http\Controllers\ReportController::class, 'store'])->middleware(['auth'])->name('clubReport.store');
Route::patch('/{club}/{report}/editReport', [App\Http\Controllers\ReportController::class, 'update'])->middleware(['auth'])->name('clubReport.update');
Route::post('/{club}/{report}/editReport', [App\Http\Controllers\ReportController::class, 'submit'])->middleware(['auth'])->name('clubReport.submitToSupervisor');
Route::get('/{club}/{report}/editReport/generate', [App\Http\Controllers\ReportController::class, 'generate'])->middleware(['auth'])->name('clubReport.generate');
//
Route::get('/{club}/members', [App\Http\Controllers\ClubMemberController::class, 'index2'])->middleware(['auth'])->name('clubMembers.index2');
Route::patch('/{club}/members/{clubMember}', [App\Http\Controllers\ClubMemberController::class, 'update2'])->middleware(['auth'])->name('clubMembers.update2');
Route::delete('/{club}/members/{clubMember}', [App\Http\Controllers\ClubMemberController::class, 'destroy2'])->middleware(['auth'])->name('clubMembers.destroy2');
//
Route::get('/{club}/join', [App\Http\Controllers\ClubMemberController::class, 'joinPage'])->name('joinClub');
Route::post('/{club}/join', [App\Http\Controllers\ClubMemberController::class, 'join'])->name('join');

require __DIR__.'/auth.php';

Route::get('/download/{path}', [App\Http\Controllers\ReportController::class, 'download'])->name('report.download')->where('path', '.*');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

