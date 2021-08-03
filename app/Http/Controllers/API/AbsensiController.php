<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function getAbsenMasuk()
    {
        $check = Attendance::find(1);
        $waktuMasuk = Carbon::parse($check->jam_masuk);
        $sekarang = Carbon::now();
        $hasilSelisih = abs(strtotime($sekarang)) - abs(strtotime($waktuMasuk));

        if ($hasilSelisih < 43200) {
            $dataAbsen = Attendance::where('id_user', Auth::guard('api')->user()->id)->orderBy('id', 'desc')->first();
            $date_time = date('Y-m-d H:i:s');
            $date = date('F j, Y');
            $time = date('H:i:s');
            return response()->json([
                'status' => 200,
                'title' => 'success',
                'message' => 'Absen Masuk Berhasil!',
                "data" => [
                    'dataAbsen' => $dataAbsen,
                    'date' => $date,
                    'date_time' => $date_time,
                    'time' => $time
                ]
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'title' => 'success',
                'message' => 'Anda telah melewatkan Absen Pulang!',
                // "data" => [
                // 'foto_masuk' => $file_name,
                // 'date' => $date,
                // 'time' => $time
                // ]
            ]);
        }
        // dd($hasil);
    }

    public function absenMasuk(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'latitude_masuk' => 'required',
                'longitude_masuk' => 'required',
                'foto_masuk' => 'required',
            ],
            [
                'latitude_masuk.required' => 'Latitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
                'longitude_masuk.required' => 'Longitude harus diisi.Mohon izinkan kami untuk mengetahui lokasi Anda',
            ]
        );

        // if($validator->fails()){
        //     return ResponseFormatter::error([
        //         'errors' => $validator->errors()->all(),
        //         // 'message' => 'Terjadi kesalahan '
        //     ], 'Terjadi kesalahan pada input', 500);
        // }

        $file_name = null;
        if ($request->foto_masuk) {
            $file = $request->foto_masuk;
            $file = str_replace('data:image/png;base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $data = base64_decode($file);
            $file_name = "foto-absen-masuk-" . date('Y-m-d His') . '-' . Auth::guard('api')->user()->id . '-' . Auth::guard('api')->user()->nama . ".png";
            Storage::disk('public')->put('foto_absensi/' . $file_name, $data);
        }

        $date_time = date('Y-m-d H:i:s');
        $date = date('F j, Y');
        $time = date('H:i:s');
        Attendance::create([
            'id_user' => Auth::user()->id,
            'latitude_masuk' => $request->latitude_masuk,
            'longitude_masuk' => $request->longitude_masuk,
            'jam_masuk' => $date_time,
            'foto_masuk' => $file_name,
        ]);

        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Absen Masuk Berhasil!',
            "data" => [
                'foto_masuk' => $file_name,
                'date' => $date,
                'time' => $time
            ]
        ]);
    }

    public function absenPulang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
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
        if ($request->foto_pulang) {
            $file = $request->foto_pulang;
            $file = str_replace('data:image/png;base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $data = base64_decode($file);
            $file_name = "foto-absen-pulang-" . date('Y-m-d His') . '-' . Auth::guard('api')->user()->id . '-' . Auth::guard('api')->user()->nama . ".png";
            Storage::disk('public')->put('foto_absensi/' . $file_name, $data);
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
            'message' => 'Absen Pulang Berhasil!'
        ]);
    }
}
