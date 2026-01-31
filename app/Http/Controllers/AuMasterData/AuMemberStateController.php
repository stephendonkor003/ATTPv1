<?php

namespace App\Http\Controllers\AuMasterData;

use App\Http\Controllers\Controller;
use App\Models\AuMemberState;
use Illuminate\Http\Request;

class AuMemberStateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings.au_master_data.view')->only(['index']);
        $this->middleware('permission:settings.au_master_data.create')->only(['create', 'store']);
        $this->middleware('permission:settings.au_master_data.edit')->only(['edit', 'update']);
        $this->middleware('permission:settings.au_master_data.delete')->only(['destroy']);
    }

    public function index()
    {
        $memberStates = AuMemberState::ordered()->get();
        return view('au-master-data.member-states.index', compact('memberStates'));
    }

    public function create()
    {
        return view('au-master-data.member-states.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:myb_au_member_states,name',
            'code' => 'nullable|string|max:3',
            'code_alpha2' => 'nullable|string|max:2',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        AuMemberState::create($validated);

        return redirect()
            ->route('settings.au.member-states.index')
            ->with('success', 'Member state created successfully.');
    }

    public function edit(AuMemberState $member_state)
    {
        return view('au-master-data.member-states.edit', ['memberState' => $member_state]);
    }

    public function update(Request $request, AuMemberState $member_state)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:myb_au_member_states,name,' . $member_state->id,
            'code' => 'nullable|string|max:3',
            'code_alpha2' => 'nullable|string|max:2',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $member_state->update($validated);

        return redirect()
            ->route('settings.au.member-states.index')
            ->with('success', 'Member state updated successfully.');
    }

    public function destroy(AuMemberState $member_state)
    {
        $member_state->delete();

        return redirect()
            ->route('settings.au.member-states.index')
            ->with('success', 'Member state deleted successfully.');
    }
}
