<?php

namespace App\Http\Controllers;

use App\Models\SystemAuditLog;
use Illuminate\Http\Request;

class SystemAuditController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemAuditLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->string('user') . '%')
                    ->orWhere('email', 'like', '%' . $request->string('user') . '%');
            });
        }

        $logs = $query->paginate(50);

        return view('system.audit.index', compact('logs'));
    }
}
