<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SubmitReport;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActionPlanController extends Controller
{
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

        return view('editActionPlan', compact('club', 'report', 'attachments_send'));
    }

    public function update(Request $request, Club $club, Report $report)
    {
        $current_academic_year_id = getCurrentAcademicYear()->id;

        $report->update(array(
            'users_id' => Auth::user() -> id,
            'clubs_id' => $club -> id,
            'academic_years_id' => $current_academic_year_id,
            'types_id' => 2,
            'description' => $request['description'],
        ));

        return back();
    }


    public function generate(Club $club, Report $report)
    {
        $report_description = $report->description;
        $club_name = $club->name;
        $current_academic_year = getCurrentAcademicYear()->name;
        $current_date = now()->toDateString();

        $person_name = $report->user->name;

        $supervisor_role_id = Role::where('name', 'opiekun_koła')->first()->id;
        $chairman_role_id = Role::where('name', 'przewodniczący_koła')->first()->id;

        $supervisor_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $supervisor_role_id)->first()->users_id;
        $chairman_id = ClubMember::where('clubs_id', $club->id) ->where('academic_years_id', getCurrentAcademicYear()->id) -> where('roles_id', $chairman_role_id)->first()->users_id;

        $supervisor_name = User::where('id', $supervisor_id)->first()->name;
        $chairman_name = User::where('id', $chairman_id)->first()->name;


        // use the dompdf class
        $content = view('templates.actionPlan', compact('club', 'report', 'report_description', 'current_academic_year', 'club_name', 'current_date', 'supervisor_name', 'chairman_name', 'person_name')) -> render();

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
