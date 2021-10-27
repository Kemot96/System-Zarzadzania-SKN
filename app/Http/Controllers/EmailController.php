<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::latest()->paginate(10);

        return view('databaseTables.emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        return view('databaseTables.emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //dd($request);
        //$this->validateUpdateEmail();

        $email->update(array(
            'message' => $request['message'],
            'day' => $request['day'],
            'day2' => $request['day2'],
            'month' => $request['month'],
            'month2'=> $request['month2'],
            'enable_sending' => $request['enable_sending'],
            'send_on_schedule' => $request['send_on_schedule'],
            'send_on_schedule2' => $request['send_on_schedule2'],
        ));

        return redirect()->route('emails.index')->with('status', 'Zmodyfikowano treść emaila!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }

    protected function validateUpdateEmail()
    {
        return request()->validate([
            'message' => 'required|string',
        ]);
    }
}
