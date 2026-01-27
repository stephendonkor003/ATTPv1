<?php

namespace App\Http\Controllers;

use App\Models\{SiteVisit, SiteVisitMedia};
use Illuminate\Http\Request;

class SiteVisitMediaController extends Controller
{
    public function store(Request $request, SiteVisit $siteVisit)
    {
        $this->authorize('edit', $siteVisit);

        $request->validate([
            'file'           => 'required|file',
            'observation_id' => 'nullable|exists:site_visit_observations,id',
        ]);

        $path = $request->file('file')->store('site-visits');

        $media = SiteVisitMedia::create([
            'site_visit_id'  => $siteVisit->id,
            'observation_id' => $request->observation_id,
            'file_path'      => $path,
            'file_type'      => $request->file('file')->getClientMimeType(),
            'uploaded_by'    => auth()->id(),
        ]);

        return response()->json($media, 201);
    }
}