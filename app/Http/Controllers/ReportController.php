<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Report;
use App\Models\Club;
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
        $current_academic_year_id = getCurrentAcademicYear();

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
        // use the dompdf class
        $content = view('templates.report') -> render();

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
