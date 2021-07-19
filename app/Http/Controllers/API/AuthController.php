<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user'=>auth()->user(), 'access_token'=>$accessToken]);
        # code...
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        // return ResponseFormatter::success($token, 'Token Berhasil dihapus');
        return $this->error(200, 'Berhasil Logout');
    }
}
