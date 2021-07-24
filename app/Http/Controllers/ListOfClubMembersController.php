<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Notification;
use App\Models\Role;
use App\Notifications\RemoveClubMemberRequest;
use App\Notifications\SubmitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListOfClubMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Club $club)
    {
        $current_academic_year = getCurrentAcademicYear();

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year->id)->get();

        $club_members_with_removal_request = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year->id)
            ->where('removal_request', TRUE)->get();

        return view('members', compact('club', 'club_members', 'club_members_with_removal_request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Club $club, ClubMember $clubMember)
    {
        $roles = Role::latest()->where('special_role', '0')->where('name', '!=', 'nieaktywny')->get();

        return view('editMembers', compact('club', 'clubMember', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, ClubMember $clubMember)
    {
        //$this->validateUpdateClubMember();

        $clubMember->update(array(
            'roles_id' => $request['roles_id'],
        ));

        return redirect()->route('listClubMembers.index', $club);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ClubMember $clubMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club, ClubMember $clubMember)
    {
        $clubMember->delete();

        return back();
    }

    public function confirm(Request $request, Club $club, ClubMember $clubMember)
    {
        //$this->validateUpdateClubMember();

        $clubMember->update(array(
            'roles_id' => Role::where('name', 'członek_koła')->first()->id,
        ));

        return back();
    }

    public function removeRequest(Request $request, Club $club)
    {
        if($request -> action == "removeRequest")
        {
            //$request["modal-input-reason"]
            $clubMember = ClubMember::find($request["modal-input-club-member-id"]);
            $club_id = $clubMember->club->id;
            $clubMember->update(array(
                'removal_request' => TRUE,
            ));

            $supervisor = getClubSupervisor($club);
            $supervisor->notify(new RemoveClubMemberRequest());
        }
        elseif($request -> action == "undoRemoveRequest")
        {
            $clubMember = ClubMember::find($request["clubMember"]);
            $clubMember->update(array(
                'removal_request' => FALSE,
            ));
        }
        elseif($request -> action == "discardRemoveRequest")
        {
            $clubMember = ClubMember::find($request -> clubMember);

            $clubMember->removal_request = FALSE;

            $clubMember->save();
        }
        return back();
    }
}
