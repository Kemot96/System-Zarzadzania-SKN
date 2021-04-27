<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreUser();

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request['password'] == NULL)
        {
            $this->validateUpdateUserWithoutPassoword($user);

            $user->update(array(
                'name' => $request['name'],
                'email' => $request['email'],
            ));
        }
        else if($request['name'] == NULL)
        {
            $this->validateUpdateUserOnlyPassword();

            $user->update(array(
                'password' => Hash::make($request['password']),
            ));
        }

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin/users');
    }

    protected function validateStoreUser()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    protected function validateUpdateUserWithoutPassoword($user)
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'email' => ['required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)],
        ]);
    }

    protected function validateUpdateUserOnlyPassword()
    {
        return request()->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
    }
}
