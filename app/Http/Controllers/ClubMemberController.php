<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Club;
use App\Models\User;
use App\Models\Role;
use App\Models\ClubMember;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class ClubMemberController extends Controller
{
    public function index(Club $club, AcademicYear $academicYear)
    {
        $clubs = Club::orderBy('name')->get();
        $academic_years = AcademicYear::orderBy('name')->get();

        if($club->exists == FALSE || $academicYear->exists == FALSE)
        {
            $club = Club::orderBy('name')->first();
            $academicYear = getCurrentAcademicYear();
            return redirect()->route('clubMembers.index', ['club' => $club, 'academicYear' => $academicYear]);
        }
        elseif($club->exists == FALSE)
        {
            $club = Club::orderBy('name')->first();
            return redirect()->route('clubMembers.index', ['club' => $club, 'academicYear' => $academicYear]);
        }

        elseif($academicYear->exists == FALSE)
        {
            $academicYear = getCurrentAcademicYear();
            return redirect()->route('clubMembers.index', ['club' => $club, 'academicYear' => $academicYear]);
        }


        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $academicYear->id)->paginate(10);

        return view('databaseTables.clubMembers.index', compact('club_members', 'clubs', 'club', 'academic_years', 'academicYear'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::latest()->get();
        $roles = Role::orderBy('name')->where('special_role', '0')->where('name', '!=', 'nieaktywny')->get();
        $clubs = Club::latest()->get();
        $academic_years = AcademicYear::latest()->get();

        return view('databaseTables.clubMembers.create',  compact('users', 'roles', 'clubs', 'academic_years'));
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

        return redirect('/admin/clubMembers');
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


        return view('databaseTables.clubMembers.edit', compact('clubMember', 'roles', 'clubs', 'academic_years'));
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

        return redirect('/admin/clubMembers');
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

        return redirect('/admin/clubMembers');
    }

    public function generate(Club $club, AcademicYear $academicYear)
    {
        $club_name = $club->name;

        $member_role_id = Role::where('name', 'członek_koła')->first()->id;
        $supervisor_role_id = Role::where('name', 'opiekun_koła')->first()->id;
        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $supervisor_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', $academicYear->id) -> where('roles_id', $supervisor_role_id)->first()->users_id;
        $chairman_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', $academicYear->id) -> where('roles_id', $chairman_role_id)->first()->users_id;

        $supervisor_name = User::where('id', $supervisor_id)->first()->name;
        $chairman_name = User::where('id', $chairman_id)->first()->name;

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $academicYear->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.membershipReport', compact('club_name','club_members', 'supervisor_name', 'chairman_name', 'academicYear')) -> render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();

        return back();
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


