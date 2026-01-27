<?php

namespace App\Http\Controllers;

use App\Models\Funder;
use Illuminate\Http\Request;

class FunderController extends Controller
{
    /**
     * Display a listing of funders.
     */
    public function index()
    {
        $funders = Funder::orderBy('name')->paginate(15);

        return view('finance.funders.index', compact('funders'));
    }

    /**
     * Show the form for creating a new funder.
     */
    public function create()
    {
        return view('finance.funders.create');
    }

    /**
     * Store a newly created funder.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:myb_funders,name',
            'type'     => 'required|in:government,donor,internal,private',
            'currency' => 'required|string|max:10',
        ]);

        Funder::create($validated);

        return redirect()
            ->route('finance.funders.index')
            ->with('success', 'Funder created successfully.');
    }

    /**
     * Show the form for editing the specified funder.
     */
    public function edit(Funder $funder)
    {
        return view('finance.funders.edit', compact('funder'));
    }

    /**
     * Update the specified funder.
     */
    public function update(Request $request, Funder $funder)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:myb_funders,name,' . $funder->id,
            'type'     => 'required|in:government,donor,internal,private',
            'currency' => 'required|string|max:10',
        ]);

        $funder->update($validated);

        return redirect()
            ->route('finance.funders.index')
            ->with('success', 'Funder updated successfully.');
    }
}