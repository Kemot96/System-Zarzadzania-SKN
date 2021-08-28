<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Role;
use App\Models\TypeOfReport;
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
        $this->validateUpdateActionPlan();

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
        $current_date = now()->toDateString();

        $person_name = $report->user->name;

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

    public function generateDoc(Club $club, Report $report)
    {
        $report_description = $report->description;
        $club_name = $club->name;
        $current_academic_year = getCurrentAcademicYear()->name;
        $current_date = now()->toDateString();

        $person_name = $report->user->name;

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


        // use the dompdf class
        $content = view('templates.actionPlan', compact('club', 'report', 'report_description', 'current_academic_year', 'club_name', 'current_date', 'supervisor_name', 'chairman_name', 'person_name')) -> render();

        return response($content)
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment;Filename=document.doc');
    }

    protected function validateUpdateActionPlan()
    {
        return request()->validate([
            'description' => 'nullable|string',
        ]);
    }
}
