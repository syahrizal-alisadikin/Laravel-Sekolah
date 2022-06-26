<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->latest()->when(request()->q, function($events) {
            $events = $events->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        // dd($kelas);
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kelas.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi
        $this->validate($request, [
            'name' => 'required',
        ]);

        // simpan data kelas
        $kelas = Kelas::create($request->all());
        // dd($kelas);
        // redirect ke halaman kelas
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Siswa Per Kelas
        $siswa = Siswa::where('kelas_id', $id)->when(request()->q, 
            function($query) {
                $query->where('name',request()->q);
            }
        )->paginate(10);
        $kela = Kelas::findOrFail($id); 
        return view('admin.kelas.show', compact('kela', 'siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kela)
    {
        return view('admin.kelas.edit', compact('kela'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
