<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function index()
    {
        // Fetch all categories and their related open projects
        // $categories = Category::with(['projects' => function ($query) {
        //     $query->where('status', 'open');
        // }])->get();

        // Or: Fetch all open projects without category grouping
        // $projects = Project::where('status', 'open')->with('category')->latest()->get();

        return view('welcome');
    }

    public function showBid(Project $project)
    {
        return view('landing.show', compact('project'));
    }

    public function create()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }


}