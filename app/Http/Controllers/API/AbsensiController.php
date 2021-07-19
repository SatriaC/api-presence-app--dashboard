<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{

    public function absenMasuk(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'latitude_masuk' => 'required',
            'longitude_masuk' => 'required',
            'foto_masuk' => 'required',
        ],
        [
            'latitude_masuk.required' => 'Latitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
            'longitude_masuk.required' => 'Longitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
        ]);

        // if($validator->fails()){
        //     return ResponseFormatter::error([
        //         'errors' => $validator->errors()->all(),
        //         // 'message' => 'Terjadi kesalahan '
        //     ], 'Terjadi kesalahan pada input', 500);
        // }

        $file_name = null;
        if($request->foto_masuk){
            $file = $request->foto_masuk;
            $file_name = date('Ymd').'-'.$file->getClientOriginalName();
            $file = str_replace('data:image/png;base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $data = base64_decode($file);
            // $request->foto_masuk->store(public_path('/Foto Pekerjaan/'))->put($file_name, $data);

            // $save_file = $file->storeAs('file/foto-profil', $file_name, 'public');
            $save_file = Storage::disk('public')->put($file_name, $data);
        }

        Attendance::create([
            'id_user' => Auth::user()->id,
            'latitude_masuk' => $request->latitude_masuk,
            'longitude_masuk' => $request->longitude_masuk,
            'jam_masuk' => date('Y-m-d H:i:s'),
            'foto_masuk' => $file_name,
        ]);

        return response()->json([
                'status' => 200,
                'title' => 'success',
                'message' => 'Data Pekerjaan Masuk Berhasil!'
        ]);
    }

    public function absenPulang(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'latitude_pulang' => 'required',
            'longitude_pulang' => 'required',
        ],
        [
            'latitude_pulang.required' => 'Latitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
            'longitude_pulang.required' => 'Longitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
        ]
    );

        // if($validator->fails()){
        //     return ResponseFormatter::error([
        //         'errors' => $validator->errors()->all(),
        //         // 'message' => 'Terjadi kesalahan '
        //     ], 'Terjadi kesalahan pada input', 500);
        // }
        $update_jam_keluar = Attendance::where('id_user', Auth::guard('api')->user()->id)->orderBy('id', 'desc')->first();

        $file_name = null;
        if($request->foto_pulang){
            $file = $request->foto_pulang;
            $file_name = date('Ymd').'-'.$file->getClientOriginalName();
            $file = str_replace('data:image/png;base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $data = base64_decode($file);
            // $save_file = $file->storeAs('file/foto-profil', $file_name, 'public');
            $save_file = Storage::disk('public')->put($file_name, $data);

        }

        // print_r($request->all());

        $update_jam_keluar->jam_pulang = date('Y-m-d H:i:s');
        $update_jam_keluar->latitude_pulang = $request->latitude_pulang;
        $update_jam_keluar->longitude_pulang = $request->longitude_pulang;
        $update_jam_keluar->foto_pulang = $file_name;

        $update_jam_keluar->save();

        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Data Pekerjaan Masuk Berhasil!'
        ]);
    }
}
