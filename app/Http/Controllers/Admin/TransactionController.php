<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
                'status' => 'PENDING',
                'nominal' => $request->nominal,
            ]);

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
