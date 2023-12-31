<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = [];
        $authUser = auth()->user();
        $perPageRecords = 25;
        if (!$authUser->hasAnyRole(['Administrator','Manager'])) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

        $users = User::with('roles');
        if ($authUser->hasRole(['Administrator'])) {
            // show all
        } else {
            $subordinateIds = $authUser->getUsersAtLevel();
            $users->whereIn('id',$subordinateIds);
        }
        // Search by user name
        $searchTerm = $request->input('q');
        if (!empty($searchTerm)) {
            $users->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $users = $users->paginate($perPageRecords);
        return view('users.index', compact('users','searchTerm'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authUser = auth()->user();
        if (!$authUser->hasAnyRole(['Administrator','Manager'])) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }
        if ($authUser->hasRole(['Administrator'])) {
            $roles = Role::all();
            $managers = Role::where('name', 'Manager')->firstOrFail()->users;
        } else {
            $roles = Role::where('name', '!=', 'Administrator')->get();
            $managers = $authUser->subordinateManagers->push($authUser);
        }

        return view('users.create', compact('roles', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authUser = auth()->user();
        if (!$authUser->hasAnyRole(['Administrator','Manager'])) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }
        //$this->authorize('manage users');
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,id',
            'daily_lead_limit' => 'nullable|integer',
            'manager_id' => 'nullable|exists:users,id',
            'type' => 'nullable|in:Incoming calls,Incoming leads,Old leads,Missed appointment',
            'comment' => 'nullable|string',
            'phone_number' => 'required|min:10',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'daily_lead_limit' => $request->input('daily_lead_limit'),
            'manager_id' => $request->input('manager_id'),
            'type' => $request->input('type'),
            'comment' => $request->input('comment'),
            'phone_number' => $request->input('phone_number'),
        ]);

        if (!$authUser->hasAnyRole(['Administrator']) && $request->input('role') == 'Administrator') {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

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
        $authUser = auth()->user();
        if (!$authUser->hasAnyRole(['Administrator','Manager'])) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }
        if ($authUser->hasRole(['Administrator'])) {
            $roles = Role::all();
            $managers = Role::where('name', 'Manager')->firstOrFail()->users;
        } else {
            $roles = Role::where('name', '!=', 'Administrator')->get();
            $managers = $authUser->subordinateManagers->push($authUser);
        }

        return view('users.edit', compact('user', 'roles', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();
        if (!$authUser->hasAnyRole(['Administrator','Manager'])) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }
        // Validation rules for name and email
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'daily_lead_limit' => 'nullable|integer',
            'manager_id' => 'nullable|exists:users,id',
            'type' => 'nullable|in:Incoming calls,Incoming leads,Old leads,Missed appointment',
            'comment' => 'nullable|string',
            'phone_number' => 'required|min:10',
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
            'daily_lead_limit' => $request->input('daily_lead_limit'),
            'manager_id' => $request->input('manager_id'),
            'type' => $request->input('type'),
            'comment' => $request->input('comment'),
            'phone_number' => $request->input('phone_number'),
        ];

        // Check if the password field is not empty before updating
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        // Update the user
        $user->update($data);

        if (!$authUser->hasAnyRole(['Administrator']) && $request->input('role') == 'Administrator') {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }
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
