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

        $supervisor = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $supervisor_role_id)->first();

        if($supervisor)
        {
            $supervisor_id = $supervisor -> users_id;

            return User::where('id', $supervisor_id)->first();
        }
        else{
            return NULL;
        }
    }
}

if (! function_exists('getClubChairman')) {
    function getClubChairman(Club $club) {

        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $chairman = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $chairman_role_id)->first();
        if($chairman)
        {
            $chairman_id = $chairman -> users_id;
            return User::where('id', $chairman_id)->first();
        }
        else{
            return NULL;
        }

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

