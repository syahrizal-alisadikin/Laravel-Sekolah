<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;

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
}
