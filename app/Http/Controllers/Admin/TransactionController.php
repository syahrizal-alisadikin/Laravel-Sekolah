<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Exception;
use Midtrans\Snap;
use Midtrans\Config;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::latest()->when(request()->q, function ($transactions) {
            $transactions->whereHas('siswa', function ($query) {
                $query->where('name', 'like', '%' . request()->q . '%');
            });
        })->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagihan = Tagihan::all();
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        return view('admin.transactions.create', [
            'tagihan' => $tagihan,
            'siswa' => $siswa,
            'kelas' => $kelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->select == "siswa") {
            // Validasi
            $request->validate([
                'siswa_id' => 'required',
                'tagihan_id' => 'required',
            ], [
                'siswa_id.required' => 'Siswa harus diisi!',
                'tagihan_id.required' => 'Tagihan harus diisi!',

            ]);



            // Simpan Data
            $transaction = Transaction::create([
                'siswa_id' => $request->siswa_id,
                'tagihan_id' => $request->tagihan_id,
                'status' => $request->status,
                'nominal' => $request->nominal,
            ]);

            // jika status Pending hit ke midtrans
            if ($request->status == "PENDING") {
                $siswa = Siswa::find($request->siswa_id);
                // Config Midtrans
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
                        "first_name" => $siswa->name,
                        "email" => $siswa->email,
                    ],
                    "enabled_payments" => [
                        "gopay", "bank_transfer"
                    ],
                    "vtweb" => []
                ];

                $paymentUrl = Snap::getSnapToken($midtrans);
                $transaction->update([
                    'midtrans_id' => $request->status == "PENDING" ? $paymentUrl : null,
                ]);
            }

            // Redirect
            return redirect()->route('admin.transactions.index')->with('success', 'Data ' . $transaction->siswa->name . ' berhasil ditambahkan!');
        } else {
            // Validasi
            $request->validate([
                'kelas_id' => 'required',
                'tagihan_id' => 'required',
            ], [
                'kelas_id.required' => 'Kelas harus diisi!',
                'tagihan_id.required' => 'Tagihan harus diisi!',

            ]);

            // Jika Transaction Langsung 1 Kelas
            $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();
            foreach ($siswa as $item) {


                // Simpan Data
                $transaction = Transaction::create([
                    'siswa_id' => $item->id,
                    'tagihan_id' => $request->tagihan_id,
                    'status' => $request->status,
                    'nominal' => $request->nominal,
                ]);
                // jika status Pending hit ke midtrans
                if ($request->status == "PENDING") {
                    // Config Midtrans
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
                            "first_name" => $item->name,
                            "email" => $item->email,
                        ],
                        "enabled_payments" => [
                            "gopay", "bank_transfer"
                        ],
                        "vtweb" => []
                    ];

                    $paymentUrl = Snap::getSnapToken($midtrans);
                    $transaction->update([
                        'midtrans_id' => $request->status == "PENDING" ? $paymentUrl : null,
                    ]);
                }
            }

            return redirect()->route('admin.transactions.index')->with('success', 'Data  berhasil ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $tagihan = Tagihan::all();
        return view('admin.transactions.edit', compact('transaction', 'tagihan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //update transaction
        $transaction->update([
            'tagihan_id' => $request->tagihan_id,
            'nominal' => $request->nominal,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Data ' . $transaction->siswa->name . ' berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get Transction
        $transaction = Transaction::findOrFail($id);
        if ($transaction) {
            $transaction->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
