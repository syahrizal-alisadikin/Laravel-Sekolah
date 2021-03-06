<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Snap;

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
        $transactions = Transaction::where('siswa_id', $request->user()->id)
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

    public function DeleteTransaction($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Data Transaction Berhasil Dihapus"
            ]
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

    public function tagihan()
    {
        $tagihan = Tagihan::all();

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Tagihan"
            ],
            "data" => $tagihan
        ], 200);
    }

    public function detailTagihan($id)
    {
        $tagihan = Tagihan::find($id);

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Tagihan"
            ],
            "data" => $tagihan
        ], 200);
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create([
            'siswa_id' => $request->user()->id,
            'tagihan_id' => $request->tagihan_id,
            'status' => 'PENDING',
            'nominal' => $request->nominal,
        ]);

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat Aray untuk dikirim ke midtrans
        $midtrans = [
            "transaction_details" => [
                "order_id" => $transaction->id,
                "gross_amount" => (int) $transaction->nominal,
            ],
            "customer_details" => [
                "first_name" => $request->user()->name,
                "email" => $request->user()->email,
            ],
            "enabled_payments" => [
                "gopay", "bank_transfer"
            ],
            "vtweb" => []
        ];

        $paymentUrl = Snap::getSnapToken($midtrans);
        $transaction->update([
            'midtrans_id' =>  $paymentUrl //midtrans_id diisi dengan hasil snap::getSnapToken(),
        ]);

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Data Transaction Berhasil Ditambahkan"
            ],
            "data" => $transaction
        ], 200);
    }
}
