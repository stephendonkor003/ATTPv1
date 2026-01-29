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

    public function impactMap()
    {
        // Comprehensive dummy data for funding partners and projects by country/region
        $impactData = [
            'funding_partners' => [
                ['id' => 1, 'name' => 'African Development Bank', 'amount' => 250000000, 'projects' => 45, 'countries' => 32, 'focus' => 'Infrastructure, Agriculture'],
                ['id' => 2, 'name' => 'World Bank Group', 'amount' => 180000000, 'projects' => 32, 'countries' => 28, 'focus' => 'Education, Health'],
                ['id' => 3, 'name' => 'European Union', 'amount' => 150000000, 'projects' => 28, 'countries' => 25, 'focus' => 'Governance, Trade'],
                ['id' => 4, 'name' => 'UN Development Programme', 'amount' => 120000000, 'projects' => 38, 'countries' => 35, 'focus' => 'SDGs, Climate'],
                ['id' => 5, 'name' => 'Gates Foundation', 'amount' => 90000000, 'projects' => 15, 'countries' => 18, 'focus' => 'Health, Agriculture'],
                ['id' => 6, 'name' => 'USAID', 'amount' => 85000000, 'projects' => 24, 'countries' => 22, 'focus' => 'Democracy, Economic Growth'],
                ['id' => 7, 'name' => 'UK Aid Direct', 'amount' => 75000000, 'projects' => 19, 'countries' => 16, 'focus' => 'Education, Gender'],
            ],
            'regional_data' => [
                'North Africa' => ['projects' => 15, 'funding' => 85000000, 'partners' => 12, 'countries' => ['Egypt', 'Morocco', 'Tunisia', 'Algeria', 'Libya']],
                'West Africa' => ['projects' => 42, 'funding' => 165000000, 'partners' => 18, 'countries' => ['Nigeria', 'Ghana', 'Senegal', 'Ivory Coast', 'Mali', 'Burkina Faso', 'Niger', 'Benin', 'Togo']],
                'Central Africa' => ['projects' => 28, 'funding' => 95000000, 'partners' => 10, 'countries' => ['Cameroon', 'Chad', 'Central African Republic', 'Democratic Republic of Congo', 'Gabon']],
                'East Africa' => ['projects' => 38, 'funding' => 145000000, 'partners' => 16, 'countries' => ['Kenya', 'Ethiopia', 'Tanzania', 'Uganda', 'Rwanda', 'Burundi', 'Somalia', 'Sudan']],
                'Southern Africa' => ['projects' => 32, 'funding' => 120000000, 'partners' => 14, 'countries' => ['South Africa', 'Zimbabwe', 'Zambia', 'Mozambique', 'Botswana', 'Namibia', 'Angola']],
            ],
            'country_data' => [
                'Nigeria' => ['projects' => 12, 'funding' => 45000000, 'sector' => 'Agriculture, Healthcare', 'region' => 'West Africa', 'population' => 206],
                'Kenya' => ['projects' => 10, 'funding' => 38000000, 'sector' => 'Education, Infrastructure', 'region' => 'East Africa', 'population' => 53],
                'South Africa' => ['projects' => 8, 'funding' => 32000000, 'sector' => 'Energy, Technology', 'region' => 'Southern Africa', 'population' => 59],
                'Egypt' => ['projects' => 7, 'funding' => 28000000, 'sector' => 'Infrastructure, Tourism', 'region' => 'North Africa', 'population' => 102],
                'Ghana' => ['projects' => 9, 'funding' => 25000000, 'sector' => 'Agriculture, Education', 'region' => 'West Africa', 'population' => 31],
                'Ethiopia' => ['projects' => 11, 'funding' => 35000000, 'sector' => 'Agriculture, Water', 'region' => 'East Africa', 'population' => 115],
                'Tanzania' => ['projects' => 8, 'funding' => 22000000, 'sector' => 'Healthcare, Education', 'region' => 'East Africa', 'population' => 59],
                'Morocco' => ['projects' => 6, 'funding' => 20000000, 'sector' => 'Energy, Manufacturing', 'region' => 'North Africa', 'population' => 37],
                'Uganda' => ['projects' => 7, 'funding' => 18000000, 'sector' => 'Healthcare, Agriculture', 'region' => 'East Africa', 'population' => 45],
                'Senegal' => ['projects' => 5, 'funding' => 15000000, 'sector' => 'Infrastructure, Fisheries', 'region' => 'West Africa', 'population' => 17],
            ],
        ];

        return view('impact-map', compact('impactData'));
    }

    public function submitInformationRequest(Request $request)
    {
        $validated = $request->validate([
            'requester_type' => 'required|string',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'request_type' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        // Store the request (you can create a database model for this later)
        // For now, we'll just send the email

        // Send acknowledgement email
        try {
            \Mail::to($validated['email'])->send(new \App\Mail\InformationRequestAcknowledgement($validated));

            return response()->json([
                'success' => true,
                'message' => 'Your request has been submitted successfully. You will receive an acknowledgement email shortly.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Request submitted but email could not be sent. We will process your request.'
            ], 500);
        }
    }

}