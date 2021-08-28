<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Index
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Index', route('index'));
});

// Index > Club
Breadcrumbs::for('clubMainPage', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('index');
    $trail->push($club->name, route('clubMainPage', $club));
});

// Index > Club > Members
Breadcrumbs::for('listClubMembers.index', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Członkowie', route('listClubMembers.index', $club));
});

// Index > Club > Members > Edit
Breadcrumbs::for('listClubMembers.edit', function (BreadcrumbTrail $trail, $club, $clubMember) {
    $trail->parent('listClubMembers.index', $club);
    $trail->push($clubMember->user->name, route('listClubMembers.index', $club, $clubMember));
});

// Index > Club > Reports for Approval
Breadcrumbs::for('clubReport.showReportsForApproval', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Pisma do akceptacji', route('clubReport.showReportsForApproval', $club));
});

// Index > Club > Report
Breadcrumbs::for('clubReport.edit', function (BreadcrumbTrail $trail, $club, $report) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Sprawozdanie', route('clubReport.edit', [$club, $report]));
});

// Index > Club > Action Plan
Breadcrumbs::for('clubActionPlan.edit', function (BreadcrumbTrail $trail, $club, $report) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Plan działań', route('clubActionPlan.edit', [$club, $report]));
});

// Index > Club > Spending Plan
Breadcrumbs::for('spendingPlan.edit', function (BreadcrumbTrail $trail, $club, $report) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Plan wydatków', route('spendingPlan.edit', [$club, $report]));
});

// Index > Club > Meetings
Breadcrumbs::for('meetings.index', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Dziennik spotkań', route('meetings.index', $club));
});

// Index > Club > Description
Breadcrumbs::for('club.description.edit', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Opis koła/sekcji', route('club.description.edit', $club));
});

// Index > Club > Profile
Breadcrumbs::for('clubMainPage.previewProfile', function (BreadcrumbTrail $trail, $club) {
    $trail->parent('clubMainPage', $club);
    $trail->push('Profil', route('clubMainPage.previewProfile', $club));
});
