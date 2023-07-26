<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users =  User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            // Add any other attributes you want to set during user creation
        ]);

        // Assign the role to the user
        $role = Role::find($request->input('role'));
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validation rules for name and email
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Add any other validation rules as needed
        ];

        // Check if the password field is not empty
        if ($request->filled('password')) {
            // Add the password validation rule if it's provided and not empty
            $rules['password'] = 'required|min:8';
        }

        // Validate the request data
        $request->validate($rules);

        // Prepare the data for update
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // Add any other attributes you want to update for the user
        ];

        // Check if the password field is not empty before updating
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        // Update the user
        $user->update($data);
        
        // Assign the new role to the user
        $role = Role::find($request->input('role'));
        $user->syncRoles([$role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
