<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        try {
            // validasi input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // cek Credentials Login
            $user = Siswa::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'Email Siswa Salah'], 400);

            }
            if($user->status == "non-aktif"){
                return response()->json(['message' => 'Akun siswa belum aktif, Silahkan hubungi admin'], 400);
            }

            // jika hash tidak sesuai muncul alert
            if (!Hash::check($request->password, $user->password, [])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email or Password salah'
                ], 401);
            }

            // jika berhasil 
            $token = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Berhasil Login');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error->getMessage()
            ], 'Authentication failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // validasi 
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:siswas'],
                'phone' => ['required', 'string', 'max:255', 'unique:siswas'],
                'alamat' => ['required', 'string', 'max:255'],
                'kelas_id' => ['required', 'integer'],
                'jenis_kelamin' => ['required','in:laki-laki,perempuan'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            

            Siswa::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'alamat' => $request->alamat,
                'kelas_id' => $request->kelas_id,
                'jenis_kelamin' => $request->jenis_kelamin,
                'password' => Hash::make($request->password),
            ]);

            $user = Siswa::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Authentication failed', 500);
        }
    }
}
