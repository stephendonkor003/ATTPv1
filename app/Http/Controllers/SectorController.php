<?php

 namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{

    public function __construct()
{
    $this->middleware('permission:sector.view')->only(['index','show']);
    $this->middleware('permission:sector.create')->only(['create','store']);
    $this->middleware('permission:sector.edit')->only(['edit','update']);
    $this->middleware('permission:sector.delete')->only(['destroy']);
}

    public function index()
    {
        $sectors = Sector::all();
        return view('sectors.index', compact('sectors'));
    }

    public function create()
    {
        return view('sectors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Sector::create($request->all());

        return back()->with('success', 'Sector created successfully.');
    }
}