<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccountCreated;

class UserAccessController extends Controller
{
    /* ======================================================
     | USERS LIST
     ====================================================== */
    public function index()
    {
        return view('system.users.index', [
            'users' => User::with(['role.permissions'])->latest()->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    /* ======================================================
     | CREATE USER
     ====================================================== */
    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('system.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
        ]);

        $plainPassword = str()->random(10);

        $user = User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => Hash::make($plainPassword),
            'role_id'              => $request->role_id,
            'user_type'            => 'staff',
            'must_change_password' => true,
        ]);

        Mail::to($user->email)->send(
            new UserAccountCreated($user, $plainPassword)
        );

        return redirect()
            ->route('system.users.index')
            ->with('success', 'User account created successfully.');
    }

    /* ======================================================
     | EDIT USER
     ====================================================== */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('system.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin cannot be modified.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()
            ->route('system.users.index')
            ->with('success', 'User updated successfully.');
    }

    /* ======================================================
     | DELETE USER
     ====================================================== */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin cannot be deleted.');
        }

        $user->delete();

        return redirect()
            ->route('system.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /* ======================================================
     | INLINE ROLE UPDATE (USED IN INDEX)
     ====================================================== */
    public function updateRole(Request $request, User $user)
    {
        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be changed.');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return back()->with('success', 'User role updated successfully.');
    }

    /* ======================================================
     | USER DIRECT PERMISSIONS (OPTIONAL)
     ====================================================== */
    public function permissions(User $user)
    {
        return view('system.users.permissions', [
            'user'        => $user,
            'permissions' => Permission::orderBy('module')->get()->groupBy('module'),
        ]);
    }

    public function syncPermissions(Request $request, User $user)
    {
        $user->permissions()->sync(
            $request->input('permissions', [])
        );

        return back()->with('success', 'Permissions updated successfully.');
    }
}