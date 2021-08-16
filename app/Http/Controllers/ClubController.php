<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\TypeOfReport;
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
        $clubs = Club::latest()->paginate(10);

        return view('databaseTables.clubs.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('databaseTables.clubs.create');
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

        $club = Club::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'icon' => $path,
        ]);


        Report::create([
            'clubs_id' => $club->id,
            'academic_years_id' => getCurrentAcademicYear()->id,
            'types_id' => TypeOfReport::getReportID(),
            'supervisor_approved' => FALSE,
            'secretariat_approved' => FALSE,
            'vice-rector_approved' => FALSE,
        ]);

        Report::create([
            'clubs_id' => $club->id,
            'academic_years_id' => getCurrentAcademicYear()->id,
            'types_id' => TypeOfReport::getSpendingPlanID(),
            'supervisor_approved' => FALSE,
            'secretariat_approved' => FALSE,
            'vice-rector_approved' => FALSE,
        ]);

        Report::create([
            'clubs_id' => $club->id,
            'academic_years_id' => getCurrentAcademicYear()->id,
            'types_id' => TypeOfReport::getActionPlanID(),
            'supervisor_approved' => FALSE,
            'secretariat_approved' => FALSE,
            'vice-rector_approved' => FALSE,
            'description' => 'Uwaga: Prosimy o przedstawienie planowanych działań w punktach',
        ]);

        return redirect()->route('clubs.index')->with('status', 'Dodano nowe koło/sekcję!');
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
        return view('databaseTables.clubs.edit', compact('club'));
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

        return redirect()->route('clubs.index')->with('status', 'Zmodyfikowano koło/sekcję!');
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

        return redirect()->route('clubs.index')->with('status', 'Usunięto koło/sekcję');
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
