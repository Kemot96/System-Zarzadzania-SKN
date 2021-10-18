<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\InstituteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
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
    Route::resource('emails', EmailController::class);
    Route::resource('institutes', InstituteController::class);
    Route::get('clubMembers/{club:name?}/{academicYear?}', [ClubMemberController::class, 'index'])->name('clubMembers.index');
    Route::get('clubMembers/{club:name}/{academicYear}/create', [ClubMemberController::class, 'create'])->name('clubMembers.create');
    Route::post('clubMembers/{club:name}/{academicYear}/create', [ClubMemberController::class, 'store'])->name('clubMembers.store');
    Route::get('clubMembers/{club:name}/{academicYear}/{clubMember}/edit', [ClubMemberController::class, 'edit'])->name('clubMembers.edit');
    Route::patch('clubMembers/{club:name}/{academicYear}/{clubMember}/edit', [ClubMemberController::class, 'update'])->name('clubMembers.update');
    Route::get('clubMembers/{club:name}/{academicYear}/generatePDF', [ClubMemberController::class, 'generatePDF'])->name('clubMembers.generatePDF');
    Route::get('clubMembers/{club:name}/{academicYear}/generateDoc', [ClubMemberController::class, 'generateDoc'])->name('clubMembers.generateDoc');
    Route::delete('clubMembers/{club:name}/{academicYear}/{clubMember}', [ClubMemberController::class, 'destroy'])->name('clubMembers.destroy');
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
    Route::get('/{club:name}/profil', [App\Http\Controllers\ClubPageController::class, 'previewProfile'])->name('clubMainPage.previewProfile');

    Route::get('/{club:name}/pliki', [App\Http\Controllers\ClubPageController::class, 'filesPage'])->name('clubFilesPage');
    Route::post('/{club:name}/pliki', [App\Http\Controllers\ClubPageController::class, 'storeFile'])->name('clubFilesPageFile.store');
    Route::delete('/{club:name}/{file}/pliki', [App\Http\Controllers\ClubPageController::class, 'destroyFile'])->name('clubFilesPageFile.destroyFile');


    Route::middleware(['supervisorAndChairman'])->group(function () {
    Route::get('/{club:name}/dziennik-spotkan', [App\Http\Controllers\MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/{club:name}/dziennik-spotkan/create', [App\Http\Controllers\MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/{club:name}/dziennik-spotkan/create', [App\Http\Controllers\MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/{club:name}/dziennik-spotkan/{meeting}', [App\Http\Controllers\MeetingController::class, 'show'])->name('meetings.show');
    Route::get('/{club:name}/dziennik-spotkan/{meeting}/edit', [App\Http\Controllers\MeetingController::class, 'edit'])->name('meetings.edit');
    Route::patch('/{club:name}/dziennik-spotkan/{meeting}/edit', [App\Http\Controllers\MeetingController::class, 'update'])->name('meetings.update');
    Route::patch('/{club:name}/dziennik-spotkan/{meeting}', [App\Http\Controllers\MeetingController::class, 'actionAsSupervisor'])->name('meetings.ActionAsSupervisor');
    Route::delete('/{club:name}/dziennik-spotkan/{meeting}', [App\Http\Controllers\MeetingController::class, 'destroy'])->name('meetings.destroy');
    });


    Route::get('/{club:name}/plany-wydatkow', [App\Http\Controllers\SpendingPlanController::class, 'menu'])->name('spendingPlan.menu');
    Route::get('/{club:name}/plany-wydatkow/archiwum/{report}', [App\Http\Controllers\SpendingPlanController::class, 'show'])->name('spendingPlan.show');
    Route::middleware(['spendingPlan'])->group(function () {
    Route::get('/{club:name}/{report}/plan-wydatkow', [App\Http\Controllers\SpendingPlanController::class, 'edit'])->name('spendingPlan.edit');
    Route::post('/{club:name}/{report}/plan-wydatkow', [App\Http\Controllers\SpendingPlanController::class, 'store'])->name('spendingPlan.store');
    Route::patch('/{club:name}/{report}/plan-wydatkow/{order}', [App\Http\Controllers\SpendingPlanController::class, 'update'])->name('spendingPlan.update');
    Route::delete('/{club:name}/{report}/plan-wydatkow/{order}', [App\Http\Controllers\SpendingPlanController::class, 'destroy'])->name('spendingPlan.destroy');
    Route::get('/{club:name}/{report}/plan-wydatkow/generatePDF', [App\Http\Controllers\SpendingPlanController::class, 'generatePDF'])->name('spendingPlan.generatePDF');
    Route::get('/{club:name}/{report}/plan-wydatkow/generateExcel', [App\Http\Controllers\SpendingPlanController::class, 'generateExcel'])->name('spendingPlan.generateExcel');
    });

    Route::middleware(['supervisor'])->group(function () {
    Route::get('/{club:name}/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'showReportsForApprovalForClub'])->name('clubReport.showReportsForApproval');
    Route::patch('/{club:name}/pisma-do-akceptacji', [App\Http\Controllers\ReportActionsController::class, 'ReportActionAsSupervisor'])->name('clubReport.ReportActionAsSupervisor');
    });

    Route::middleware(['supervisorAndChairman'])->group(function () {
    Route::post('/{club:name}/{report}/submit', [App\Http\Controllers\ReportActionsController::class, 'submit'])->name('clubReport.submitToSupervisor');
    });


    Route::get('/{club:name}/sprawozdania', [App\Http\Controllers\ReportController::class, 'menu'])->name('clubReport.menu');
    Route::get('/{club:name}/sprawozdania/archiwum/{report}', [App\Http\Controllers\ReportController::class, 'show'])->name('clubReport.show');
    Route::middleware(['report'])->group(function () {
    Route::get('/{club:name}/{report}/sprawozdanie', [App\Http\Controllers\ReportController::class, 'edit'])->name('clubReport.edit');
    Route::patch('/{club:name}/{report}/sprawozdanie', [App\Http\Controllers\ReportController::class, 'update'])->name('clubReport.update');
    Route::get('/{club:name}/{report}/sprawozdanie/generatePDF', [App\Http\Controllers\ReportController::class, 'generatePDF'])->name('clubReport.generatePDF');
    Route::get('/{club:name}/{report}/sprawozdanie/generateDoc', [App\Http\Controllers\ReportController::class, 'generateDoc'])->name('clubReport.generateDoc');
    });


    Route::get('/{club:name}/plany-dzialan', [App\Http\Controllers\ActionPlanController::class, 'menu'])->name('clubActionPlan.menu');
    Route::get('/{club:name}/plany-dzialan/archiwum/{report}', [App\Http\Controllers\ActionPlanController::class, 'show'])->name('clubActionPlan.show');
    Route::middleware(['actionPlan'])->group(function () {
    Route::get('/{club:name}/{report}/plan-dzialan', [App\Http\Controllers\ActionPlanController::class, 'edit'])->name('clubActionPlan.edit');
    Route::patch('/{club:name}/{report}/plan-dzialan', [App\Http\Controllers\ActionPlanController::class, 'update'])->name('clubActionPlan.update');
    Route::get('/{club:name}/{report}/plan-dzialan/generatePDF', [App\Http\Controllers\ActionPlanController::class, 'generatePDF'])->name('clubActionPlan.generatePDF');
    Route::get('/{club:name}/{report}/plan-dzialan/generateDoc', [App\Http\Controllers\ActionPlanController::class, 'generateDoc'])->name('clubActionPlan.generateDoc');
    });

    Route::get('/{club:name}/czlonkowie', [App\Http\Controllers\ListOfClubMembersController::class, 'index'])->name('listClubMembers.index');
    Route::patch('/{club:name}/czlonkowie', [App\Http\Controllers\ListOfClubMembersController::class, 'removeRequest'])->name('listClubMembers.removeRequest');
    Route::get('/{club:name}/czlonkowie/{clubMember}/edit', [App\Http\Controllers\ListOfClubMembersController::class, 'edit'])->name('listClubMembers.edit');
    Route::patch('/{club:name}/czlonkowie/{clubMember}/edit', [App\Http\Controllers\ListOfClubMembersController::class, 'update'])->name('listClubMembers.update');
    Route::patch('/{club:name}/czlonkowie/{clubMember}', [App\Http\Controllers\ListOfClubMembersController::class, 'confirm'])->name('listClubMembers.confirm');
    Route::delete('/{club:name}/czlonkowie/{clubMember}', [App\Http\Controllers\ListOfClubMembersController::class, 'destroy'])->name('listClubMembers.destroy');

    Route::middleware(['supervisorAndChairman'])->group(function () {
    Route::get('/{club:name}/edycja-opisu', [App\Http\Controllers\ClubPageController::class, 'editDescription'])->name('club.description.edit');
    Route::patch('/{club:name}/edycja-opisu', [App\Http\Controllers\ClubPageController::class, 'updateDescription'])->name('club.description.update');
    });
});


Route::get('/{club:name}/dolacz', [App\Http\Controllers\ClubPageController::class, 'joinPage'])->name('joinClub');
Route::post('/{club:name}/dolacz', [App\Http\Controllers\ClubPageController::class, 'join'])->name('join');

Route::get('/download/attachment/{path}', [App\Http\Controllers\ReportActionsController::class, 'downloadAttachment'])->name('downloadAttachment')->where('path', '.*');
Route::get('/download/file/{path}', [App\Http\Controllers\ClubPageController::class, 'downloadFile'])->name('downloadFile')->where('path', '.*');
