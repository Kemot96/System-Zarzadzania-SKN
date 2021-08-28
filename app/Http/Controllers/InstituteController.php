<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Institute::latest()->paginate(10);

        return view('databaseTables.institutes.index', compact('institutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('databaseTables.institutes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreInstitute();

        Institute::create([
            'name' => $request['name'],
        ]);

        return redirect()->route('institutes.index')->with('status', 'Dodano nowy instytut!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Institute $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Institute $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        return view('databaseTables.institutes.edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Institute $institute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institute $institute)
    {
        $this->validateUpdateInstitute($institute);

        $institute->update(array(
            'name' => $request['name'],
        ));

        return redirect()->route('institutes.index')->with('status', 'Zmodyfikowano instytut!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Institute $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {
        $institute->delete();

        return redirect()->route('institutes.index')->with('status', 'Usunięto instytut!');
    }

    protected function validateStoreInstitute()
    {
        return request()->validate([
            'name' => 'required|unique:institutes|string|max:255',
        ]);
    }

    protected function validateUpdateInstitute($institute)
    {
        return request()->validate([
            'name' => ['required',
                'string',
                'max:255',
                Rule::unique('institutes')->ignore($institute->id)],
        ]);
    }
}
