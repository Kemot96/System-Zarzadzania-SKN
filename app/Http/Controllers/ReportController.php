<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        return view('createReport', compact('club'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club)
    {
        $current_academic_year_id = AcademicYear::latest()->where('current_year', '1')->first()->id;

        Report::create([
            'users_id' => Auth::user() -> id,
            'clubs_id' => $club -> id,
            'academic_years_id' => $current_academic_year_id,
            'types_id' => 1,
            'description' => $request['description'],
            'remarks' => $request['remarks'],
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, Report $report)
    {
        return view('editReport', compact('club', 'report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, Report $report)
    {
        $current_academic_year_id = getCurrentAcademicYear()->id;

        $report->update(array(
            'users_id' => Auth::user() -> id,
            'clubs_id' => $club -> id,
            'academic_years_id' => $current_academic_year_id,
            'types_id' => 1,
            'description' => $request['description'],
            'remarks' => $request['remarks'],
        ));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }

    public function generate($club, $report)
    {
        $report_description = Report::where('id', $report)->first()->description;

        $club_name = Club::latest()->where('id', $club)->first()->name;
        $description = Club::latest()->where('id', $club)->first()->description;
        $current_academic_year = getCurrentAcademicYear()->name;

        $member_role_id = Role::where('name', 'członek_koła')->first()->id;
        $supervisor_role_id = Role::where('name', 'opiekun_koła')->first()->id;
        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $supervisor_id = ClubMember::where('clubs_id', $club) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $supervisor_role_id)->first()->users_id;
        $chairman_id = ClubMember::where('clubs_id', $club) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $chairman_role_id)->first()->users_id;

        $supervisor_name = User::where('id', $supervisor_id)->first()->name;
        $chairman_name = User::where('id', $chairman_id)->first()->name;

        $club_members = ClubMember::latest()->where('clubs_id', $club)->where('academic_years_id', getCurrentAcademicYear()->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.report', compact('club_name', 'description', 'current_academic_year', 'club_members', 'supervisor_name', 'chairman_name', 'report_description')) -> render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}
