<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class WalletController extends Controller
{
    public function withdrawForm()
    {
        $withdrawals = Withdrawal::where('id_user', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('wallet.withdraw', compact('withdrawals'));
    }

    public function storeWithdraw(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'jumlah' => 'required|numeric|min:10000|max:' . $user->saldo,
            'bank_tujuan' => 'required|string|max:50',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100'
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user) {
            // Kurangi saldo
            $user->saldo -= $request->jumlah;
            $user->save();

            // Buat record withdrawal
            Withdrawal::create([
                'id_user' => $user->id,
                'jumlah' => $request->jumlah,
                'bank_tujuan' => $request->bank_tujuan,
                'nomor_rekening' => $request->nomor_rekening,
                'atas_nama' => $request->atas_nama,
                'status' => 'menunggu'
            ]);
        });

        return redirect()->back()->with('success', 'Permintaan penarikan dana berhasil dikirim. Silakan tunggu konfirmasi Admin.');
    }
}
