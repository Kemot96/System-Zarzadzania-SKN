<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::latest()->get();

        return view('clubs.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreClub();

        $path = NULL;

        if($request->file('icon') != NULL)
        {
            $path = $request->file('icon')->store('clubsIcons', 'public');
        }

        Club::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'icon' => $path,
        ]);

        return redirect('/admin/clubs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        //return view('clubs.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('clubs.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $this->validateUpdateClub($club);

        if($request->file('icon') != NULL)
        {
            $this->deleteIconFromDisk($club);

            $path = $request->file('icon')->store('clubsIcons', 'public');

            $club->update(array(
                'name' => $request['name'],
                'description' => $request['description'],
                'icon' => $path,
            ));
        }
        else{
            $club->update(array(
                'name' => $request['name'],
                'description' => $request['description'],
            ));
        }

        return redirect('/admin/clubs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $this->deleteIconFromDisk($club);

        $club->delete();

        return redirect('/admin/clubs');
    }

    public function frontPage()
    {
        $clubs = Club::latest()->get();

        return view('index', compact('clubs'));
    }

    public function mainPage(Club $club)
    {
        $files = $club->files;

        $current_academic_year_id = getCurrentAcademicYear()->id;

        $report = NULL;

        if (Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->exists()) {
            $report = Report::where('clubs_id', $club->id)->where('academic_years_id', $current_academic_year_id)->first();
        }

        return view('club', compact('club', 'files', 'report'));
    }


    protected function validateStoreClub()
    {
        return request()->validate([
            'name' => 'required|unique:clubs',
            'description' => 'nullable|string',
            'icon' => 'nullable|image',
        ]);
    }

    protected function validateUpdateClub($club)
    {
        return request()->validate([
            'name' => ['required',
                Rule::unique('clubs')->ignore($club->id)],
            'description' => 'nullable|string',
            'icon' => 'nullable|image',
        ]);
    }

    protected function deleteIconFromDisk($club)
    {
        $icon = $club->icon;
        if (Storage::disk('public')->exists($icon)) {
            Storage::disk('public')->delete($icon);
        }
    }
}
