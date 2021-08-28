<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $clubs = Club::latest()->get();

        if (Auth::check()) {
            $inactive_role_id = Role::where('name', 'nieaktywny')->first()->id;

            $my_clubs_ids = ClubMember::where('users_id', Auth::user()->id)->where('academic_years_id', getCurrentAcademicYear()->id)->where('roles_id', '!=', $inactive_role_id)->pluck('clubs_id')->toArray();

            $my_clubs = $clubs->only($my_clubs_ids);

            $clubs = $clubs->except($my_clubs_ids);

            return view('index', compact('clubs', 'my_clubs'));
        } else {
            return view('index', compact('clubs'));
        }


    }
}
