<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attachment;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

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

    public function submit(Request $request, $club, $report_id)
    {
        if($request -> action == "submit")
        {
            foreach($request->file('attachments') as $item)
            {
                $path = $item->store('attachments', 'public');
                Attachment::create([
                    'reports_id' => $report_id,
                    'name' => $path,
                ]);
            }
        }
        elseif($request -> action == "undo")
        {
            $attachment_paths = Attachment::where('reports_id', $report_id)->pluck('name')->all();
            foreach($attachment_paths as $attachment_path)
            {
                $this->deleteAttachmentFromDisk($attachment_path);
            }
            Attachment::where('reports_id', $report_id)->delete();
        }

        return redirect('/'.$club);
    }

    public function showReportsForApprovalSecretariat()
    {
        $current_academic_year = getCurrentAcademicYear()->id;

        $send_reports_ids = Attachment::pluck('reports_id')->all();

        $reports = Report::whereIn('id', $send_reports_ids)->latest()->where('academic_years_id', $current_academic_year)->where('supervisor_approved', TRUE)->get();

        return view('reportsForApprovalSecretariat', compact('reports'));
    }

    public function showReportsForApprovalViceRector()
    {
        $current_academic_year = getCurrentAcademicYear()->id;

        $send_reports_ids = Attachment::pluck('reports_id')->all();

        $reports = Report::whereIn('id', $send_reports_ids)->latest()->where('academic_years_id', $current_academic_year)->where('secretariat_approved', TRUE)->get();

        return view('reportsForApprovalViceRector', compact('reports'));
    }



    public function showReportsForApprovalForClub($club)
    {
        $current_academic_year = getCurrentAcademicYear()->id;

        $send_reports_ids = Attachment::pluck('reports_id')->all();

        $reports = Report::whereIn('id', $send_reports_ids)->latest()->where('academic_years_id', $current_academic_year)->where('clubs_id', $club)->get();

        return view('reportsForApprovalForClub', compact('club', 'reports'));
    }

    public function ReportActionAsSupervisor(Request $request, $club, Report $report)
    {
        if($request -> action == "accept")
        {
            $report->update(array(
                'supervisor_approved' => true,
            ));
        }
        else if($request -> action == "dismiss")
        {
            $report->update(array(
                'supervisor_approved' => false,
            ));
        }
        else if($request -> action == "undo")
        {
            $report->update(array(
                'supervisor_approved' => NULL,
            ));
        }

        return back();
    }

    public function ReportActionAsSecretariat(Request $request, Report $report)
    {
        //dd($report);
        if($request -> action == "accept")
        {
            $report->update(array(
                'secretariat_approved' => true,
            ));
        }
        else if($request -> action == "dismiss")
        {
            $report->update(array(
                'secretariat_approved' => false,
            ));
        }
        else if($request -> action == "undo")
        {
            $report->update(array(
                'secretariat_approved' => NULL,
            ));
        }

        return back();
    }

    public function ReportActionAsViceRector(Request $request, Report $report)
    {
        if($request -> action == "accept")
        {
            $report->update(array(
                'vice-rector_approved' => true,
            ));
        }
        else if($request -> action == "dismiss")
        {
            $report->update(array(
                'vice-rector_approved' => false,
            ));
        }
        else if($request -> action == "undo")
        {
            $report->update(array(
                'vice-rector_approved' => NULL,
            ));
        }

        return back();
    }

    public function download($path)
    {
        $path = 'storage/'.$path;
        //$file_path = public_path($path);
        //return Storage::download($path);
        return response()->download($path);
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

    protected function deleteAttachmentFromDisk($attachment_path)
    {
        if (Storage::disk('public')->exists($attachment_path)) {
            Storage::disk('public')->delete($attachment_path);
        }
    }
}
