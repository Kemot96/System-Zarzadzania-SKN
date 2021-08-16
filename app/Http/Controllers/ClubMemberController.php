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
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class ClubMemberController extends Controller
{
    public function index(Club $club, AcademicYear $academicYear)
    {
        $clubs = Club::orderBy('name')->get();
        $academic_years = AcademicYear::orderBy('name')->get();

        if ($club->exists == FALSE || $academicYear->exists == FALSE) {
            $club = Club::orderBy('name')->first();
            $academicYear = getCurrentAcademicYear();
            return redirect()->route('clubMembers.index', ['club' => $club, 'academicYear' => $academicYear]);
        } elseif ($club->exists == FALSE) {
            $club = Club::orderBy('name')->first();
            return redirect()->route('clubMembers.index', ['club' => $club, 'academicYear' => $academicYear]);
        } elseif ($academicYear->exists == FALSE) {
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
    public function create(Club $club, AcademicYear $academicYear)
    {
        $users = User::latest()->get();
        $roles = Role::orderBy('name')->where('special_role', '0')->where('name', '!=', 'nieaktywny')->get();

        return view('databaseTables.clubMembers.create', compact('users', 'roles', 'club', 'academicYear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club, AcademicYear $academicYear)
    {
        $this->validateStoreClubMember($request, $club, $academicYear);

        ClubMember::create([
            'users_id' => $request['users_id'],
            'roles_id' => $request['roles_id'],
            'clubs_id' => $club->id,
            'academic_years_id' => $academicYear->id,
            'removal_request' => FALSE,
        ]);

        return redirect()->route('clubMembers.index', [$club, $academicYear])->with('status', 'Dodano nowego użytkownika!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function show(ClubMember $clubMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, AcademicYear $academicYear, ClubMember $clubMember)
    {
        $roles = Role::latest()->where('special_role', '0')->get();

        return view('databaseTables.clubMembers.edit', compact('clubMember', 'roles', 'club', 'academicYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, AcademicYear $academicYear, ClubMember $clubMember)
    {
        $this->validateUpdateClubMember();

        $clubMember->update(array(
            'roles_id' => $request['roles_id'],
        ));

        return redirect()->route('clubMembers.index', [$club, $academicYear])->with('status', 'Zmodyfikowano użytkownika!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club, AcademicYear $academicYear, ClubMember $clubMember)
    {
        $clubMember->delete();

        return redirect()->route('clubMembers.index', [$club, $academicYear])->with('status', 'Usunięto użytkownika!');
    }

    public function generatePDF(Club $club, AcademicYear $academicYear)
    {
        $club_name = $club->name;

        $member_role_id = Role::where('name', 'członek_koła')->first()->id;

        $chairman_name = NULL;
        $chairman = getClubChairman($club);
        if($chairman)
        {
            $chairman_name = $chairman->name;
        }

        $supervisor_name = NULL;
        $supervisor = getClubSupervisor($club);
        if($supervisor)
        {
            $supervisor_name = $supervisor->name;
        }

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $academicYear->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.membershipReport', compact('club_name', 'club_members', 'supervisor_name', 'chairman_name', 'academicYear'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function generateDoc(Club $club, AcademicYear $academicYear)
    {
        $club_name = $club->name;

        $member_role_id = Role::where('name', 'członek_koła')->first()->id;

        $chairman_name = NULL;
        $chairman = getClubChairman($club);
        if($chairman)
        {
            $chairman_name = $chairman->name;
        }

        $supervisor_name = NULL;
        $supervisor = getClubSupervisor($club);
        if($supervisor)
        {
            $supervisor_name = $supervisor->name;
        }

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $academicYear->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.membershipReport', compact('club_name', 'club_members', 'supervisor_name', 'chairman_name', 'academicYear'))->render();


        return response($content)
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment;Filename=document.doc');
    }


    protected function validateStoreClubMember(Request $request, Club $club, AcademicYear $academicYear)
    {
        return request()->validate([
            'users_id' => ['required',
                'exists:App\Models\User,id',
                Rule::unique('club_members')->where(function ($query) use ($request, $club, $academicYear) {
                    return $query->where('clubs_id', $club->id)
                        ->where('academic_years_id', $academicYear->id);
                })],
            'roles_id' => 'required|exists:App\Models\Role,id,special_role,0',
        ]);
    }

    protected function validateUpdateClubMember()
    {
        return request()->validate([
            'roles_id' => 'required|exists:App\Models\Role,id,special_role,0',
        ]);
    }
}


