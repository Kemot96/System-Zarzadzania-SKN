<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Club;
use App\Models\User;
use App\Models\Role;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $club_members = ClubMember::latest()->get();

        return view('clubMembers.index', compact('club_members'));
    }

    public function index2($club)
    {
        $current_academic_year = AcademicYear::latest()->where('current_year', '1')->first();

        $club_members = ClubMember::latest()->where('clubs_id', $club)->where('academic_years_id', $current_academic_year->id)->get();

        return view('members', compact('club', 'club_members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::latest()->get();
        $roles = Role::latest()->where('special_role', '0')->get();
        $clubs = Club::latest()->get();
        $academic_years = AcademicYear::latest()->get();

        return view('clubMembers.create',  compact('users', 'roles', 'clubs', 'academic_years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreClubMember();

        ClubMember::create([
            'users_id' => $request['users_id'],
            'roles_id' => $request['roles_id'],
            'clubs_id' => $request['clubs_id'],
            'academic_years_id' => $request['academic_years_id'],
        ]);

        return redirect('/clubMembers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClubMember  $clubMember
     * @return \Illuminate\Http\Response
     */
    public function show(ClubMember $clubMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClubMember  $clubMember
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubMember $clubMember)
    {
        $roles = Role::latest()->where('special_role', '0')->get();
        $clubs = Club::latest()->get();
        $academic_years = AcademicYear::latest()->get();


        return view('clubMembers.edit', compact('clubMember', 'roles', 'clubs', 'academic_years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClubMember  $clubMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubMember $clubMember)
    {
        $this->validateUpdateClubMember();

        $clubMember->update(array(
            'roles_id' => $request['roles_id'],
            'clubs_id' => $request['clubs_id'],
            'academic_years_id' => $request['academic_years_id'],
        ));

        return redirect('/clubMembers');
    }

    public function update2($club, ClubMember $clubMember)
    {
        //$this->validateUpdateClubMember();



        $clubMember->update(array(
            'roles_id' => 2,
        ));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClubMember  $clubMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubMember $clubMember)
    {
        $clubMember->delete();

        return redirect('/clubMembers');
    }

    public function destroy2($club, ClubMember $clubMember)
    {
        $clubMember->delete();

        return back();
    }

    public function joinPage(Club $club)
    {
        return view('joinClub', compact('club'));
    }


    public function join(Request $request)
    {
        $user_id = Auth::user()->id;
        $club_id = $request->club;
        $role_id = Role::latest()->find(1)->where('name', 'nieaktywny')->first()->id;
        $current_academic_year_id = AcademicYear::latest()->where('current_year', '1')->first()->id;

        //$this->validateStoreClubMember();

        ClubMember::create([
            'users_id' => $user_id,
            'roles_id' => $role_id,
            'clubs_id' => $club_id,
            'academic_years_id' => $current_academic_year_id,
        ]);

        return redirect('/index');
    }

    protected function validateStoreClubMember()
    {
        return request()->validate([
            'users_id' => 'required|exists:App\Models\User,id',
            'roles_id' => 'required|exists:App\Models\Role,id,special_role,0',
            'clubs_id' => 'required|exists:App\Models\Club,id',
            'academic_years_id' => 'required|exists:App\Models\AcademicYear,id',
        ]);
    }

    protected function validateUpdateClubMember()
    {
        return request()->validate([
            'roles_id' => 'required|exists:App\Models\Role,id,special_role,0',
            'clubs_id' => 'required|exists:App\Models\Club,id',
            'academic_years_id' => 'required|exists:App\Models\AcademicYear,id',
        ]);
    }
}


