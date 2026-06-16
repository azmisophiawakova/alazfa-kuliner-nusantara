<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function update(Request $request, $id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);
        $request->validate(['status' => 'required|in:disetujui,ditolak']);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $withdrawal) {
            $withdrawal->update(['status' => $request->status]);

            // Jika ditolak, kembalikan saldo
            if ($request->status == 'ditolak') {
                $user = $withdrawal->user;
                $user->saldo += $withdrawal->jumlah;
                $user->save();
            }
        });

        return redirect()->back()->with('success', 'Status penarikan dana berhasil diperbarui.');
    }
}
