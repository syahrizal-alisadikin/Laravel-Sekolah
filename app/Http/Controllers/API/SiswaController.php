<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;

class SiswaController extends Controller
{
    public function friend(Request $request)
    {
        // $user = Auth::user(); //Bisa juga menggunakan $request->user()
        // $user = $request->user();

        $friend = Siswa::where('kelas_id', $request->user()->kelas_id)
            ->when($request->name, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%')
                        ->orwhere('nisn', 'like', '%' . $request->name . '%')
                        ->orwhere('phone', 'like', '%' . $request->name . '%')
                        ->orwhere('email', 'like', '%' . $request->name . '%');
                });
            })
            ->whereNot('id', $request->user()->id)
            ->paginate($request->rows);

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Friend"
            ],
            "data" => $friend
        ], 200);
    }

    public function transaction(Request $request)
    {
        $siswa = Siswa::find($request->user()->id);
        $transactions = Transaction::where('siswa_id', $siswa->id)
            ->whereHas('tagihan', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->with('siswa', 'tagihan')->latest()->paginate($request->rows);

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Transaction " . $request->user()->name
            ],
            "data" => $transactions
        ], 200);
    }

    public function callback(Request $request)
    {
        // set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //instance midtrans notif
        $notification = new Notification();

        //assign ke variable untuk memuahka ke coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // cari transaksi berdasarkan id
        $transaction = Transaction::find($order_id);
        // handle notif status
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                    $transaction->tanggal_bayar = date('Y-m-d');
                }
            }
        } else if ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
            $transaction->tanggal_bayar = date('Y-m-d');
        } else if ($status == 'pending') {
            $transaction->status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->status = 'FAILED';
        } else if ($status == 'expire') {
            $transaction->status = 'FAILED';
        } else if ($status == 'cancel') {
            $transaction->status = 'FAILED';
        }

        //simpan transaksi 
        $transaction->save();
    }
}
