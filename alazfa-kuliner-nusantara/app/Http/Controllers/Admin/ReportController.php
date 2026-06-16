<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::with('user')->latest()->get();
        if ($request->wantsJson()) return response()->json($reports);
        return view('admin.reports.index', compact('reports'));
    }

    public function resolve(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'selesai']);

        if ($request->wantsJson()) return response()->json(['message' => 'Laporan diselesaikan']);
        return redirect()->back()->with('success', 'Laporan telah diselesaikan');
    }
}
