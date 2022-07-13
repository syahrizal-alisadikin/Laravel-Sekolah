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

        $friend = Siswa::where('kelas_id', $request->user()->kelas_id)
            ->when($request->name, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%')
                        ->orwhere('nis', 'like', '%' . $request->name . '%');
                })->where(function ($query) use ($request) {
                    $query->where('email', 'like', '%' . $request->name . '%')
                        ->orwhere('phone', 'like', '%' . $request->name . '%');
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
}
