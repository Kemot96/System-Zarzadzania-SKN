<?php


use App\Models\AcademicYear;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Role;
use App\Models\User;

if (! function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear() {
        return AcademicYear::latest()->where('current_year', '1')->first();
    }
}

if (! function_exists('getClubSupervisor')) {
    function getClubSupervisor(Club $club) {

        $supervisor_role_id = Role::where('name', 'opiekun_koła')->first()->id;

        $supervisor_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $supervisor_role_id)->first()->users_id;

        return User::where('id', $supervisor_id)->first();;
    }
}

if (! function_exists('getClubChairman')) {
    function getClubChairman(Club $club) {

        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $chairman_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $chairman_role_id)->first()->users_id;

        return User::where('id', $chairman_id)->first();;
    }
}

if (! function_exists('getActiveChairmenAndSupervisors')) {
    function getActiveChairmenAndSupervisors() {
        $supervisor_role_id = Role::where('name', 'opiekun_koła')->first()->id;
        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $supervisors_ids = ClubMember::latest()->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $supervisor_role_id)->pluck('users_id')->all();
        $chairman_ids = ClubMember::latest()->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $chairman_role_id)->pluck('users_id')->all();

        return User::whereIn('id', $supervisors_ids)->orWhereIn('id', $chairman_ids)->get();
    }
}

