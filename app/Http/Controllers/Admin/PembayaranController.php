<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayaran = Tagihan::latest()->when(request()->q, function ($pembayaran) {
            $pembayaran = $pembayaran->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi data
        $this->validate($request, [
            'name' => 'required|unique:tagihans',
            'nominal' => 'required|numeric',
        ]);

        // simpan data ke database
        $pembayaran = Tagihan::create([
            'name' => $request->input('name'),
            'nominal' => $request->input('nominal'),
            'tahun' => date('Y'),
            'description' => $request->input('description'),
        ]);

        // alert
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data berhasil ditambahkan');
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
    public function edit($id)
    {
        //get by id
        $pembayaran = Tagihan::findOrFail($id);
        return view('admin.pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pembayaran = Tagihan::findOrFail($id);
        // validasi data
        $this->validate($request, [
            'name' => 'required|unique:tagihans,name,' . $pembayaran->id,
            'nominal' => 'required|numeric',
        ]);

        $pembayaran->update([
            'name' => $request->input('name'),
            'nominal' => $request->input('nominal'),
            'tahun' => date('Y'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembayaran = Tagihan::findOrFail($id);
        $pembayaran->delete();
        if ($pembayaran) {
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
