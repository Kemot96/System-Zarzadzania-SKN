<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Report;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    //public function create(Club $club)
    //{
    //    return view('createReport', compact('club'));
    //}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*public function store(Request $request, Club $club)
    {
        $current_academic_year_id = getCurrentAcademicYear()->id;

        Report::create([
            'users_id' => Auth::user() -> id,
            'clubs_id' => $club -> id,
            'academic_years_id' => $current_academic_year_id,
            'types_id' => 1,
            'description' => $request['description'],
        ]);

        return back();
    }*/

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
        $send_reports_ids = Attachment::pluck('reports_id')->all();

        if (in_array($report->id, $send_reports_ids))
        {
            $attachments_send = TRUE;
        }
        else{
            $attachments_send = FALSE;
        }

        return view('editReport', compact('club', 'report', 'attachments_send'));
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


}
