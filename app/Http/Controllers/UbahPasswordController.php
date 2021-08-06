<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UbahPasswordController extends Controller
{

    public function index()
    {
        return view('auth.passwords.ubah-password');
    }

    public function changePassword(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                "password" => 'required|string|min:6|confirmed'
            ],
            [
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok'
            ]
        );

        // dd($validation);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $karyawan = User::findOrFail(Auth::user()->id);
        $karyawan->password = Hash::make($request->password);
        // $karyawan->changePassword = 1;
        $karyawan->save();

        return redirect()->route('dashboard')->with('success', 'Password Berhasil Diupdate');
    }
}
