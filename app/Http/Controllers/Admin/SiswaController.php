<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::latest()->when(request()->q, function ($siswa) {
            $siswa = $siswa->where('name', 'like', '%' . request()->q . '%');
        })->with('kelas')->paginate(10);

        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', [
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
        $this->validate($request, [
            'nisn'          => 'required',
            'name'          => 'required',
            'email'         => 'required|email|unique:siswas',
            'phone'         => 'required|unique:siswas',
            'kelas_id'      => 'required',
            'status'        => 'required',
            'jenis_kelamin' => 'required',
            'alamat'        => 'required',
            'password'      => 'required|confirmed'
        ]);

        $siswa = Siswa::create([
            'nisn'          => $request->input('nisn'),
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'phone'         => $request->input('phone'),
            'kelas_id'      => $request->input('kelas_id'),
            'status'        => $request->input('status'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'alamat'        => $request->input('alamat'),
            'password'      => bcrypt($request->input('password'))
        ]);

        //assign role

        if ($siswa) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.siswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $this->validate($request, [
            'nisn'          => 'required',
            'name'          => 'required',
            'email'         => 'required|email|unique:siswas,email,' . $siswa->id,
            'phone'         => 'required|unique:siswas,phone,' . $siswa->id,
            'kelas_id'      => 'required',
            'status'        => 'required',
            'jenis_kelamin' => 'required',
            'alamat'        => 'required',
        ]);
        $siswa = Siswa::findOrFail($siswa->id);

        if ($request->input('password') == "") {
            $siswa->update([
                'nisn'          => $request->input('nisn'),
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'phone'         => $request->input('phone'),
                'kelas_id'      => $request->input('kelas_id'),
                'status'        => $request->input('status'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'alamat'        => $request->input('alamat'),
            ]);
        } else {
            $siswa->update([
                'nisn'          => $request->input('nisn'),
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'phone'         => $request->input('phone'),
                'kelas_id'      => $request->input('kelas_id'),
                'status'        => $request->input('status'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'alamat'        => $request->input('alamat'),
                'password'      => bcrypt($request->input('password'))
            ]);
        }

        //assign role
        // $user->syncRoles($request->input('role'));

        if ($siswa) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.siswa.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.siswa.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();


        if ($siswa) {
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
