<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ClubMemberController;


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

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('clubs', ClubController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('emails', EmailController::class);
    Route::resource('clubMembers', ClubMemberController::class)->except('index');
    Route::get('clubMembers/{club:name?}/{academicYear?}', [ClubMemberController::class, 'index'])->name('clubMembers.index');
    Route::get('clubMembers/{club:name}/{academicYear}/generate', [ClubMemberController::class, 'generate'])->name('clubMembers.generate');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::middleware(['auth', 'secretariat'])->group(function () {
Route::get('/sekretariat/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'showReportsForApprovalSecretariat'])->name('secretariat.showReports');
Route::patch('sekretariat/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'ReportActionAsSecretariat'])->name('secretariat.reportAction');
});


Route::middleware(['auth', 'viceRector'])->group(function () {
Route::get('/prorektor/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'showReportsForApprovalViceRector'])->name('vice-rector.showReports');
Route::patch('prorektor/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'ReportActionAsViceRector'])->name('vice-rector.reportAction');
});

Route::middleware(['auth', 'club.access'])->group(function () {
    Route::get('/{club:name}', [App\Http\Controllers\ClubPageController::class, 'mainPage'])->name('clubMainPage');
    Route::post('/{club:name}', [App\Http\Controllers\ClubPageController::class, 'storeFile'])->name('clubMainPageFile.store');
    Route::delete('/{club:name}/{file}', [App\Http\Controllers\ClubPageController::class, 'destroyFile'])->name('clubMainPageFile.destroyFile');

    Route::get('/{club:name}/dziennik-spotkan', [App\Http\Controllers\MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/{club:name}/dziennik-spotkan/create', [App\Http\Controllers\MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/{club:name}/dziennik-spotkan/create', [App\Http\Controllers\MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/{club:name}/dziennik-spotkan/{meeting}', [App\Http\Controllers\MeetingController::class, 'show'])->name('meetings.show');


    Route::get('/{club:name}/{report}/plan-wydatkow', [App\Http\Controllers\SpendingPlanController::class, 'edit'])->name('spendingPlan.edit');
    Route::post('/{club:name}/{report}/plan-wydatkow', [App\Http\Controllers\SpendingPlanController::class, 'store'])->name('spendingPlan.store');
    Route::patch('/{club:name}/{report}/plan-wydatkow/{order}', [App\Http\Controllers\SpendingPlanController::class, 'update'])->name('spendingPlan.update');
    Route::delete('/{club:name}/{report}/plan-wydatkow/{order}', [App\Http\Controllers\SpendingPlanController::class, 'destroy'])->name('spendingPlan.destroy');
    Route::get('/{club:name}/{report}/plan-wydatkow/generate', [App\Http\Controllers\SpendingPlanController::class, 'generate'])->name('spendingPlan.generate');

    Route::get('/{club:name}/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'showReportsForApprovalForClub'])->name('clubReport.showReportsForApproval');
    Route::patch('/{club:name}/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'ReportActionAsSupervisor'])->name('clubReport.ReportActionAsSupervisor');

    Route::post('/{club:name}/{report}/submit', [App\Http\Controllers\ReportActionsController::class, 'submit'])->name('clubReport.submitToSupervisor');

    Route::get('/{club:name}/{report}/sprawozdanie', [App\Http\Controllers\ReportController::class, 'edit'])->name('clubReport.edit');
    Route::patch('/{club:name}/{report}/sprawozdanie', [App\Http\Controllers\ReportController::class, 'update'])->name('clubReport.update');
    Route::get('/{club:name}/{report}/sprawozdanie/generate', [App\Http\Controllers\ReportActionsController::class, 'generate'])->name('clubReport.generate');

    Route::get('/{club:name}/{report}/plan-dzialan', [App\Http\Controllers\ActionPlanController::class, 'edit'])->name('clubActionPlan.edit');
    Route::patch('/{club:name}/{report}/plan-dzialan', [App\Http\Controllers\ActionPlanController::class, 'update'])->name('clubActionPlan.update');
    Route::get('/{club:name}/{report}/plan-dzialan/generate', [App\Http\Controllers\ActionPlanController::class, 'generate'])->name('clubActionPlan.generate');

    Route::get('/{club:name}/czlonkowie', [App\Http\Controllers\ListOfClubMembersController::class, 'index'])->name('listClubMembers.index');
    Route::patch('/{club:name}/czlonkowie', [App\Http\Controllers\ListOfClubMembersController::class, 'removeRequest'])->name('listClubMembers.removeRequest');
    Route::get('/{club:name}/czlonkowie/{clubMember}/edit', [App\Http\Controllers\ListOfClubMembersController::class, 'edit'])->name('listClubMembers.edit');
    Route::patch('/{club:name}/czlonkowie/{clubMember}/edit', [App\Http\Controllers\ListOfClubMembersController::class, 'update'])->name('listClubMembers.update');
    Route::patch('/{club:name}/czlonkowie/{clubMember}', [App\Http\Controllers\ListOfClubMembersController::class, 'confirm'])->name('listClubMembers.confirm');
    Route::delete('/{club:name}/czlonkowie/{clubMember}', [App\Http\Controllers\ListOfClubMembersController::class, 'destroy'])->name('listClubMembers.destroy');
});


Route::get('/{club:name}/dolacz', [App\Http\Controllers\ClubPageController::class, 'joinPage'])->name('joinClub');
Route::post('/{club:name}/dolacz', [App\Http\Controllers\ClubPageController::class, 'join'])->name('join');

Route::get('/download/attachment/{path}', [App\Http\Controllers\ReportActionsController::class, 'downloadAttachment'])->name('downloadAttachment')->where('path', '.*');
Route::get('/download/file/{path}', [App\Http\Controllers\ReportActionsController::class, 'downloadFile'])->name('downloadFile')->where('path', '.*');



