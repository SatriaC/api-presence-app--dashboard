<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NewPasswordController extends Controller
{

    public function ubah(Request $request)
    {
        $request->validate([
            // 'token' => 'required',
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::where('id', Auth::guard('api')->user()->id)->orderBy('id', 'desc')->first();

        # code...
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Password Berhasil dirubah!'
        ]);

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => bcrypt($request->password),
        //             // 'remember_token' => Str::random(60),
        //         ])->save();

        //         $user->tokens()->delete();

        //         event(new PasswordReset($user));
        //     }
        // );

        // if ($status == Password::PASSWORD_RESET) {
        //     return response([
        //         'message'=> 'Password reset successfully'
        //     ]);
        // }

        // return response([
        //     'message'=> __($status)
        // ], 500);

    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->orderBy('created_at', 'desc')->first();
        $user->password = bcrypt('Building2021');
        $user->save();

        Mail::to($request->email)->send(new ResetPasswordEmail($user));

        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Password Berhasil direset dan Pemberitahuan email telah dikirim!'
        ]);

    }
}
