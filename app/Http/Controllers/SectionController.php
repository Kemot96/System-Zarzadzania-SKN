<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::latest()->paginate(10);

        return view('databaseTables.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clubs = Club::latest()->get();

        return view('databaseTables.sections.create',  compact('clubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateSection();

        Section::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'clubs_id' => $request['clubs_id'],
        ]);

        return redirect('/admin/sections');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $clubs = Club::latest()->get();

        return view('databaseTables.sections.edit', compact('section', 'clubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $this->validateSection();

        $section->update(array(
            'name' => $request['name'],
            'description' => $request['description'],
            'clubs_id' => $request['clubs_id'],
        ));

        return redirect('/admin/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return redirect('/admin/sections');
    }

    protected function validateSection()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'clubs_id' => 'required|exists:App\Models\Club,id',
        ]);
    }
}
