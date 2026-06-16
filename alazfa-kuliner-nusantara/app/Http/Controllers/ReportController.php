<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|string',
            'id_referensi' => 'required|integer',
            'alasan' => 'required|string|max:1000',
        ]);

        $report = Report::create([
            'id_user' => auth()->id(),
            'jenis_laporan' => $request->jenis_laporan,
            'id_referensi' => $request->id_referensi,
            'alasan' => $request->alasan,
            'status' => 'menunggu',
        ]);

        // Kirim Notifikasi ke semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'id_user' => $admin->id,
                'judul' => 'Laporan Pengguna Baru',
                'pesan' => 'Ada laporan baru dari pengguna terkait ' . $report->jenis_laporan . ' #' . $report->id_referensi . '. Segera tinjau.',
                'status_baca' => false,
                'tanggal_kirim' => now()
            ]);
        }

        if ($request->wantsJson()) return response()->json(['message' => 'Laporan berhasil dikirim.']);
        return redirect()->back()->with('success', 'Laporan Anda telah berhasil dikirim dan akan segera ditinjau oleh Admin.');
    }
}
