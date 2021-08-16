<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Club;
use App\Models\Role;
use App\Models\TypeOfReport;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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

        return view('editReport', compact('club', 'report', 'attachments_send'));
    }

    public function update(Request $request, Club $club, Report $report)
    {
        $report->update(array(
            'description' => $request['description'],
        ));

        return back();
    }

    public function generatePDF(Club $club, Report $report)
    {
        $report_description = $report->description;
        $club_name = $club->name;
        $current_academic_year = getCurrentAcademicYear()->name;

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

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', getCurrentAcademicYear()->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.report', compact('club_name', 'current_academic_year', 'club_members', 'supervisor_name', 'chairman_name', 'report_description')) -> render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function generateDoc(Club $club, Report $report)
    {
        $report_description = $report->description;
        $club_name = $club->name;
        $current_academic_year = getCurrentAcademicYear()->name;

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

        $club_members = ClubMember::latest()->where('clubs_id', $club->id)->where('academic_years_id', getCurrentAcademicYear()->id)->where('roles_id', $member_role_id)->get();

        // use the dompdf class
        $content = view('templates.report', compact('club_name', 'current_academic_year', 'club_members', 'supervisor_name', 'chairman_name', 'report_description')) -> render();

        return response($content)
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment;Filename=document.doc');
    }
}
