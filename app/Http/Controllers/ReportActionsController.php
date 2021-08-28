<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Club;
use App\Models\File;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;
use App\Notifications\DismissReport;
use App\Notifications\SubmitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportActionsController extends Controller
{
    public function submit(Request $request, Club $club, Report $report)
    {
        if ($request->action == "submit") {
            foreach ($request->file('file') as $item) {
                $original_name = $item->getClientOriginalName();
                $path = $item->store('attachments', 'public');
                Attachment::create([
                    'reports_id' => $report->id,
                    'name' => $path,
                    'original_file_name' => $original_name,
                ]);
            }

            if ($club->getLoggedUserRoleName() == 'opiekun_koła') {
                $report->update(array(
                    'users_id' => Auth::user()->id,
                    'supervisor_approved' => true,
                ));

                $secretariat_id = Role::where('name', 'sekretariat_prorektora')->value('id');
                $secretariat_users = User::where('roles_id', $secretariat_id)->get();
                foreach ($secretariat_users as $secretariat) {
                    $secretariat->notify(new SubmitReport());
                }
            } else {
                $report->update(array(
                    'users_id' => Auth::user()->id,
                ));

                $supervisor = getClubSupervisor($club);
                if ($supervisor) {
                    $supervisor->notify(new SubmitReport());
                }
            }

        } elseif ($request->action == "undo") {
            $attachment_paths = Attachment::where('reports_id', $report->id)->pluck('name')->all();
            foreach ($attachment_paths as $attachment_path) {
                $this->deleteAttachmentFromDisk($attachment_path);
            }
            Attachment::where('reports_id', $report->id)->delete();

            $report->update(array(
                'remarks' => NULL,
                'supervisor_approved' => NULL,
                'secretariat_approved' => NULL,
                'vice-rector_approved' => NULL,
            ));
        }

        return back();
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


    public function showReportsForApprovalForClub(Club $club)
    {
        $current_academic_year = getCurrentAcademicYear()->id;

        $send_reports_ids = Attachment::pluck('reports_id')->all();

        $reports = Report::whereIn('id', $send_reports_ids)->latest()->where('academic_years_id', $current_academic_year)->where('clubs_id', $club->id)->get();

        return view('reportsForApprovalForClub', compact('club', 'reports'));
    }

    public function ReportActionAsSupervisor(Request $request, Club $club)
    {
        $report = Report::findOrFail($request["modal-input-report-id"]);
        if ($request->action == "accept") {
            $report->update(array(
                'supervisor_approved' => true,
            ));

            $secretariat_id = Role::where('name', 'sekretariat_prorektora')->value('id');
            $secretariat_users = User::where('roles_id', $secretariat_id)->get();
            foreach ($secretariat_users as $secretariat) {
                $secretariat->notify(new SubmitReport());
            }
        } else if ($request->action == "dismiss") {
            $this->validateReportRemarks();

            $report->update(array(
                'remarks' => $request["modal-input-remarks"],
                'supervisor_approved' => false,
            ));

            $chairman = getClubChairman($club);
            if ($chairman) {
                $chairman->notify(new DismissReport());
            }

        } else if ($request->action == "undo") {
            $report->update(array(
                'remarks' => NULL,
                'supervisor_approved' => NULL,
            ));
        }

        return back();
    }

    public function ReportActionAsSecretariat(Request $request)
    {
        $report = Report::findOrFail($request["modal-input-report-id"]);
        if ($request->action == "accept") {
            $report->update(array(
                'secretariat_approved' => true,
            ));

            $vice_rector_id = Role::where('name', 'prorektor')->value('id');
            $vice_rector_users = User::where('roles_id', $vice_rector_id)->get();
            foreach ($vice_rector_users as $vice_rector) {
                $vice_rector->notify(new SubmitReport());
            }
        } else if ($request->action == "dismiss") {
            $this->validateReportRemarks();

            $report->update(array(
                'remarks' => $request["modal-input-remarks"],
                'secretariat_approved' => false,
            ));

            $club = Club::where('id', $report->clubs_id)->first();

            $chairman = getClubChairman($club);
            if ($chairman) {
                $chairman->notify(new DismissReport());
            }

            $supervisor = getClubSupervisor($club);
            if ($supervisor) {
                $supervisor->notify(new DismissReport());
            }

        } else if ($request->action == "undo") {
            $report->update(array(
                'remarks' => NULL,
                'secretariat_approved' => NULL,
            ));
        }

        return back();
    }

    public function ReportActionAsViceRector(Request $request)
    {
        $report = Report::findOrFail($request["modal-input-report-id"]);
        if ($request->action == "accept") {
            $report->update(array(
                'vice-rector_approved' => true,
            ));
        } else if ($request->action == "dismiss") {
            $this->validateReportRemarks();

            $report->update(array(
                'remarks' => $request["modal-input-remarks"],
                'vice-rector_approved' => false,
            ));

            $club = Club::where('id', $report->clubs_id)->first();

            $chairman = getClubChairman($club);
            if ($chairman) {
                $chairman->notify(new DismissReport());
            }


            $supervisor = getClubSupervisor($club);
            if ($supervisor) {
                $supervisor->notify(new DismissReport());
            }

        } else if ($request->action == "undo") {
            $report->update(array(
                'remarks' => NULL,
                'vice-rector_approved' => NULL,
            ));
        }

        return back();
    }

    public function downloadAttachment($path)
    {
        $name = Attachment::where('name', $path)->first()->original_file_name;
        $path = 'storage/' . $path;
        return response()->download($path, $name);
    }

    protected function deleteAttachmentFromDisk($attachment_path)
    {
        if (Storage::disk('public')->exists($attachment_path)) {
            Storage::disk('public')->delete($attachment_path);
        }
    }

    protected function validateReportRemarks()
    {
        return request()->validate([
            'modal-input-remarks' => 'nullable|string',
        ]);
    }
}
