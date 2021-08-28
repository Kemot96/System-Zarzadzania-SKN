<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Role;
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
        $users = User::latest()->paginate(10);

        return view('databaseTables.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutes = Institute::latest()->get();
        $roles = Role::latest()->where('special_role', '1')->get();

        return view('databaseTables.users.create', compact('institutes', 'roles'));
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
            'roles_id' => $request['roles_id'],
            'institutes_id' => $request['institutes_id'],
        ]);

        return redirect()->route('users.index')->with('status', 'Dodano nowego użytkownika!');
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
        $roles = Role::latest()->where('special_role', '1')->get();
        $institutes = Institute::latest()->get();

        return view('databaseTables.users.edit', compact('user', 'roles', 'institutes'));
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
                'roles_id' => $request['roles_id'],
                'institutes_id' => $request['institutes_id'],
            ));
        }
        else if($request['name'] == NULL)
        {
            $this->validateUpdateUserOnlyPassword();

            $user->update(array(
                'password' => Hash::make($request['password']),
            ));
        }

        return redirect()->route('users.index')->with('status', 'Zmodyfikowano użytkownika!');
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

        return redirect()->route('users.index')->with('status', 'Usunięto użytkownika!');
    }

    protected function validateStoreUser()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles_id' => 'nullable|exists:App\Models\Role,id,special_role,1',
            'institutes_id' => 'nullable|exists:App\Models\Institute,id',
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
            'roles_id' => 'nullable|exists:App\Models\Role,id,special_role,1',
            'institutes_id' => 'nullable|exists:App\Models\Institute,id',
        ]);
    }

    protected function validateUpdateUserOnlyPassword()
    {
        return request()->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
    }
}
