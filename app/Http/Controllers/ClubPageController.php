<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\File;
use App\Models\Report;
use App\Models\Role;
use App\Models\TypeOfReport;
use App\Notifications\RequestToJoinClub;
use App\Notifications\SubmitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClubPageController extends Controller
{
    public function mainPage(Club $club)
    {
        $current_academic_year_id = getCurrentAcademicYear()->id;
        $report_id = TypeOfReport::latest()->where('name', 'Sprawozdanie')->first()->id;
        $action_plan_id = TypeOfReport::latest()->where('name', 'Plan działań')->first()->id;
        $spending_plan_id = TypeOfReport::latest()->where('name', 'Plan wydatków')->first()->id;

        $report = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $report_id)->first();
        $action_plan = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $action_plan_id)->first();
        $spending_plan = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $spending_plan_id)->first();

        return view('club', compact('club', 'report', 'action_plan', 'spending_plan'));
    }

    public function filesPage(Club $club)
    {
        $files = File::latest()->where('clubs_id', $club->id)->get();

        $imageFiles = collect();
        $otherFiles = collect();

        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu',
            'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

        foreach ($files as $file) {
            $explode_file_name = explode('.', $file->name);

            $extension = end($explode_file_name);

            if (in_array($extension, $imageExtensions)) {
                $imageFiles[] = $file;
            } else {
                $otherFiles[] = $file;
            }
        }

        $imageFiles = $imageFiles->paginate(12);

        return view('clubFiles', compact('club', 'imageFiles', 'otherFiles'));
    }

    public function previewProfile(Club $club)
    {
        return view('previewClubProfile', compact('club'));
    }

    public function joinPage(Club $club)
    {
        $request_to_join_send = false;

        if (ClubMember::where('users_id', Auth::user()->id)->where('clubs_id', $club->id)->where('academic_years_id', getCurrentAcademicYear()->id)->exists()) {
            $request_to_join_send = true;
        }

        return view('joinClub', compact('club', 'request_to_join_send'));
    }


    public function join(Request $request, Club $club)
    {
        $user_id = Auth::user()->id;
        $club_id = $club->id;
        $role_id = Role::latest()->find(1)->where('name', 'nieaktywny')->first()->id;
        $current_academic_year_id = getCurrentAcademicYear()->id;

        ClubMember::create([
            'users_id' => $user_id,
            'roles_id' => $role_id,
            'clubs_id' => $club_id,
            'academic_years_id' => $current_academic_year_id,
            'removal_request' => FALSE,
        ]);

        $supervisor = getClubSupervisor($club);
        if ($supervisor) {
            $supervisor->notify(new RequestToJoinClub());
        }

        $chairman = getClubChairman($club);
        if ($chairman) {
            $chairman->notify(new RequestToJoinClub());
        }


        return back();
    }

    public function storeFile(Request $request, Club $club)
    {
        $original_name = $request->file->getClientOriginalName();
        $path = $request->file('file')->store('clubfiles/' . $club->id, 'public');

        File::create([
            'name' => $path,
            'clubs_id' => $club->id,
            'users_id' => Auth::user()->id,
            'original_file_name' => $original_name,
        ]);

        return back();
    }

    public function downloadFile($path)
    {
        $name = File::where('name', $path)->first()->original_file_name;
        $path = 'storage/' . $path;
        return response()->download($path, $name);
    }

    public function destroyFile(Club $club, File $file)
    {
        $this->deleteFileFromDisk($file);

        $file->delete();

        return back();
    }

    public function editDescription(Club $club)
    {
        return view('editClubDescription', compact('club'));
    }

    public function updateDescription(Request $request, Club $club)
    {
        $this->validateUpdateDescription();

        $club->update(array(
            'description' => $request['description'],
        ));

        return redirect()->route('club.description.edit', compact('club'))->with('status', 'Zmodyfikowano opis koła/sekcji!');
    }


    protected function deleteFileFromDisk(File $file)
    {
        if (Storage::disk('public')->exists($file->name)) {
            Storage::disk('public')->delete($file->name);
        }
    }

    protected function validateUpdateDescription()
    {
        return request()->validate([
            'description' => 'nullable|string',
        ]);
    }
}
