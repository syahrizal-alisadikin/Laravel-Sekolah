<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Auth;

class SiswaController extends Controller
{
    public function friend(Request $request)
    {
        // $user = Auth::user(); //Bisa juga menggunakan $request->user()
        // $user = $request->user();
        $friend = Siswa::where('kelas_id', $request->user()->kelas_id)->get();

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Friend"
            ],
            "data" => $friend
        ], 200);
    }
}
