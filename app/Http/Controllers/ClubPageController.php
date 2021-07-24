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

class ClubPageController extends Controller
{
    public function mainPage(Club $club)
    {
        $files = $club->files;

        $imageFiles = array();
        $noImageFiles = array();


        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu',
            'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

        foreach ($files as $file) {
            $explodeImage = explode('.', $file->name);

            $extension = end($explodeImage);

            if (in_array($extension, $imageExtensions)) {
                $imageFiles[] = $file;
            } else {
                $noImageFiles[] = $file;
            }
        }

        $current_academic_year_id = getCurrentAcademicYear()->id;
        $report_id = TypeOfReport::latest()->where('name', 'Sprawozdanie')->first()->id;
        $action_plan_id = TypeOfReport::latest()->where('name', 'Plan działań')->first()->id;
        $spending_plan_id = TypeOfReport::latest()->where('name', 'Plan wydatków')->first()->id;

        $report = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $report_id)->first();
        $action_plan = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $action_plan_id)->first();
        $spending_plan = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->where('types_id', $spending_plan_id)->first();

        return view('club', compact('club', 'imageFiles', 'noImageFiles', 'report', 'action_plan', 'spending_plan'));
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

        //$this->validateJoinClubMember();



        ClubMember::create([
            'users_id' => $user_id,
            'roles_id' => $role_id,
            'clubs_id' => $club_id,
            'academic_years_id' => $current_academic_year_id,
        ]);

        $supervisor = getClubSupervisor($club);
        $supervisor->notify(new RequestToJoinClub());

        $chairman = getClubChairman($club);
        $chairman->notify(new RequestToJoinClub());


        return back();
    }

    public function storeFile(Request $request, Club $club)
    {
        //$this->validateStoreClub();

        $original_name = $request->file->getClientOriginalName();
        $path = $request->file('file')->store('clubsFiles', 'public');

        File::create([
            'name' => $path,
            'clubs_id' => $club -> id,
            'users_id' => Auth::user() -> id,
            'original_file_name' => $original_name,
        ]);

        return back();
    }

    public function destroyFile(Club $club, File $file)
    {
        $file->delete();

        return back();
    }
}
