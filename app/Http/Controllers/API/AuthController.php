<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:55',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'nik' => 'required',
            'id_bagian' => 'required',
            'id_lokasi' => 'required',
            'id_wilayah' => 'required',
            'privilege' => 'required',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=>$accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['success' => false,'message' => 'Email/Password salah']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $user = User::select(['bm_user.*','bm_bagian.nama AS nama_bagian','bm_lokasi.nama AS nama_lokasi'])
        ->leftJoin('bm_lokasi', 'bm_lokasi.id', '=', 'bm_user.id_lokasi')
        ->leftJoin('bm_bagian', 'bm_bagian.id', '=', 'bm_user.id_bagian')
        ->where('bm_user.id', auth()->user()->id)->first();
        // return response(['success' => true,'user'=>auth()->user(), 'access_token'=>$accessToken]);
        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Login Berhasil!',
            "data" => [
                // 'success' => true,
                'user'=>$user,
                // 'user'=>auth()->user(),
                'access_token'=>$accessToken,
            ]
        ]);
        # code...
    }

    public function logout () {
        // $token = $request->user()->token();
        // $token->revoke();
        // // return ResponseFormatter::success($token, 'Token Berhasil dihapus');
        // return $this->error(200, 'Berhasil Logout');
        if(Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' => true, 'message' => "Success! You are logged out."], 200);
        }
        return response()->json(['success' => false, 'message' => "Failed! You are already logged out."], 403);
    }
}
