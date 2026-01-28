<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\GovernanceNode;
use App\Models\GovernanceReportingLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccountCreated;
use App\Mail\UserPasswordReset;
use Illuminate\Support\Facades\Auth;

class UserAccessController extends Controller
{
    /* ======================================================
     | USERS LIST
     ====================================================== */
    public function index()
    {
        $scopedNodeIds = $this->scopedNodeIds();

        return view('system.users.index', [
            'users' => User::with(['role.permissions', 'governanceNode'])
                ->when($scopedNodeIds !== null, function ($query) use ($scopedNodeIds) {
                    $query->whereIn('governance_node_id', $scopedNodeIds);
                })
                ->latest()
                ->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    /* ======================================================
     | CREATE USER
     ====================================================== */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $nodes = $this->availableNodes();

        return view('system.users.create', compact('roles', 'nodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'governance_node_id' => 'required|exists:myb_governance_nodes,id',
        ]);

        $this->assertNodeInScope((int) $request->governance_node_id);

        $plainPassword = str()->random(10);

        $user = User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => Hash::make($plainPassword),
            'role_id'              => $request->role_id,
            'governance_node_id'   => $request->governance_node_id,
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
        $this->assertUserInScope($user);
        $roles = Role::orderBy('name')->get();
        $nodes = $this->availableNodes();

        return view('system.users.edit', compact('user', 'roles', 'nodes'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin cannot be modified.');
        }

        $this->assertUserInScope($user);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'governance_node_id' => 'required|exists:myb_governance_nodes,id',
        ]);

        $this->assertNodeInScope((int) $request->governance_node_id);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'governance_node_id' => $request->governance_node_id,
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

        $this->assertUserInScope($user);

        $user->delete();

        return redirect()
            ->route('system.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /* ======================================================
     | RESET PASSWORD (EMAIL NEW PASSWORD)
     ====================================================== */
    public function resetPassword(User $user)
    {
        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin password cannot be reset here.');
        }

        $this->assertUserInScope($user);

        $plainPassword = str()->random(10);

        $user->update([
            'password' => Hash::make($plainPassword),
            'must_change_password' => true,
        ]);

        Mail::to($user->email)->send(
            new UserPasswordReset($user, $plainPassword)
        );

        return back()->with('success', 'Password reset and emailed successfully.');
    }

    /* ======================================================
     | INLINE ROLE UPDATE (USED IN INDEX)
     ====================================================== */
    public function updateRole(Request $request, User $user)
    {
        if ($user->role && $user->role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be changed.');
        }

        $this->assertUserInScope($user);

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
        $this->assertUserInScope($user);

        return view('system.users.permissions', [
            'user'        => $user,
            'permissions' => Permission::orderBy('module')->get()->groupBy('module'),
        ]);
    }

    public function syncPermissions(Request $request, User $user)
    {
        $this->assertUserInScope($user);

        $user->permissions()->sync(
            $request->input('permissions', [])
        );

        return back()->with('success', 'Permissions updated successfully.');
    }

    private function scopedNodeIds(): ?array
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->isAdmin()) {
            return null;
        }

        if (!$currentUser->governance_node_id) {
            return [];
        }

        return $this->descendantNodeIds($currentUser->governance_node_id);
    }

    private function availableNodes()
    {
        $scopedNodeIds = $this->scopedNodeIds();

        return GovernanceNode::orderBy('name')
            ->when($scopedNodeIds !== null, function ($query) use ($scopedNodeIds) {
                $query->whereIn('id', $scopedNodeIds);
            })
            ->get();
    }

    private function assertUserInScope(User $user): void
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds === null) {
            return;
        }

        if (!$user->governance_node_id || !in_array($user->governance_node_id, $scopedNodeIds, true)) {
            abort(403, 'You do not have access to manage this user.');
        }
    }

    private function assertNodeInScope(int $nodeId): void
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds === null) {
            return;
        }

        if (!in_array($nodeId, $scopedNodeIds, true)) {
            abort(403, 'You do not have access to assign this governance node.');
        }
    }

    private function descendantNodeIds(int $rootNodeId): array
    {
        $lines = GovernanceReportingLine::where('line_type', 'primary')->get(['parent_node_id', 'child_node_id']);
        $children = [];

        foreach ($lines as $line) {
            $children[$line->parent_node_id][] = $line->child_node_id;
        }

        $stack = [$rootNodeId];
        $seen = [];

        while ($stack) {
            $current = array_pop($stack);
            if (isset($seen[$current])) {
                continue;
            }
            $seen[$current] = true;

            foreach ($children[$current] ?? [] as $childId) {
                if (!isset($seen[$childId])) {
                    $stack[] = $childId;
                }
            }
        }

        return array_keys($seen);
    }
}
