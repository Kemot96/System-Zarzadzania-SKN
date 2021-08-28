<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Club $club)
    {
        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('layouts.meetings', compact('club', 'meetings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        $current_academic_year = getCurrentAcademicYear();

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year->id)->get();

        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('meetingsCreate', compact('club', 'club_members', 'meetings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club)
    {
        $this->validateMeeting();

        Meeting::create([
            'topic' => $request['topic'],
            'present_members' => $request['present_members'],
            'clubs_id' => $club->id,
            'supervisor_approved' => NULL,
        ]);

        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('layouts.meetings', compact('club', 'meetings'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club, Meeting $meeting)
    {
        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('meetingsShow', compact('club', 'meeting', 'meetings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, Meeting $meeting)
    {
        $current_academic_year = getCurrentAcademicYear();

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year->id)->get();

        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('meetingsEdit', compact('club', 'meeting', 'meetings', 'club_members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, Meeting $meeting)
    {
        $this->validateMeeting();

        $meeting->update(array(
            'topic' => $request['topic'],
            'present_members' => $request['present_members'],
            'supervisor_approved' => NULL,
        ));

        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('meetingsShow', compact('club', 'meeting', 'meetings'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club, Meeting $meeting)
    {
        $meeting->delete();

        $meetings = Meeting::latest()->where('clubs_id', $club->id)->paginate(10);

        return view('layouts.meetings', compact('club', 'meetings'));
    }

    public function actionAsSupervisor(Request $request, Club $club, Meeting $meeting)
    {
        if($request -> action == "accept")
        {
            $meeting->update(array(
                'supervisor_approved' => TRUE,
            ));
        }
        else if($request -> action == "dismiss")
        {
            $meeting->update(array(
                'supervisor_approved' => FALSE,
            ));
        }
        else if($request -> action == "undo")
        {
            $meeting->update(array(
                'supervisor_approved' => NULL,
            ));
        }

        return back();
    }

    protected function validateMeeting()
    {
        return request()->validate([
            'present_members' => 'required',
        ]);
    }



}
