<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PekerjaanController extends Controller
{

    public function index()
    {
        return Task::all();
    }

    public function show($id)
    {
        $item = Task::find($id);
        return $item;
    }

    public function store(Request $request)
    {
        $item = Task::create($request->all());

        return response()->json($item, 201);
    }

    public function reportSebelum(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'id_sow' => 'required',
            'id_kategori' => 'required',
            'id_detail' => 'required',
            'laporan' => 'required',
            'foto_before' => 'required',
            // 'foto_after' => 'required',
        ]);

        // if($validator->fails()){
        //     return ResponseFormatter::error([
        //         'errors' => $validator->errors()->all(),
        //         // 'message' => 'Terjadi kesalahan '
        //     ], 'Terjadi kesalahan pada input', 500);
        // }

        $file_name = null;
        if($request->foto_before){
            $file = $request->foto_before;
            // $file = $request->foto_before->storeAs('public/file/pekerjaan/',$file_name);
            $file = str_replace('data:image/png;base64,', '', $file);
            $file = str_replace(' ', '+', $file);
            $data = base64_decode($file);
            // $request->foto_before->store(public_path('/Foto Pekerjaan/'))->put($file_name, $data);

            $file_name = "foto-pekerjaan-sebelum-".date('Y-m-d His').'-'.Auth::guard('api')->user()->id.'-'.Auth::guard('api')->user()->nama.".png";
            // $save_file = $file->storeAs('file/foto-profil', $file_name, 'public');
            $save_file = Storage::disk('public')->put($file_name, $data);
        }

        $file_name1 = null;
        if($request->foto_after){
            $file1 = $request->foto_after;
            $file1 = str_replace('data:image/png;base64,', '', $file1);
            $file1 = str_replace(' ', '+', $file1);
            $data1 = base64_decode($file1);
            $file_name1 = "foto-pekerjaan-sesudah-".date('Y-m-d His').'-'.Auth::guard('api')->user()->id.'-'.Auth::guard('api')->user()->nama.".png";
            $save_file = Storage::disk('public')->put($file_name1, $data1);
        }

        Task::create([
            'id_user' => Auth::user()->id,
            'id_bagian' => Auth::user()->id_bagian,
            'id_sow' => $request->id_sow,
            'id_kategori' => $request->id_kategori,
            'id_detail' => $request->id_detail,
            'reported_at' => date('Y-m-d H:i:s'),
            'laporan' => $request->laporan,
            'foto_before' => $file_name,
            'note' => $request->note,
            // 'foto_after' => $file_name1
        ]);

        return response()->json([
                'success' => true,
                // 'foto before' => $request->foto_before,
                'status' => 200,
                'title' => 'success',
                'message' => 'Data Pekerjaan Masuk Berhasil!'
        ]);
    }

    public function reportSesudah(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
             'foto_after' => 'required',
            ]
        );

        // if($validator->fails()){
        //     return ResponseFormatter::error([
        //         'errors' => $validator->errors()->all(),
        //         // 'message' => 'Terjadi kesalahan '
        //     ], 'Terjadi kesalahan pada input', 500);
        // }
        $update_pekerjaan = Task::find($id);
        // $update_pekerjaan = Task::where([['id_user', Auth::guard('api')->user()->id],['id_sow', $id]])->orderBy('id', 'desc')->first();

        $file_name1 = null;
        if($request->foto_after){
            $file1 = $request->foto_after;
            $file1 = str_replace('data:image/png;base64,', '', $file1);
            $file1 = str_replace(' ', '+', $file1);
            $data1 = base64_decode($file1);
            $file_name1 = "foto-pekerjaan-sesudah-".date('Y-m-d His').'-'.Auth::guard('api')->user()->id.'-'.Auth::guard('api')->user()->nama.".png";
            $save_file = Storage::disk('public')->put($file_name1, $data1);
        }

        $update_pekerjaan->foto_after = $file_name1;
        $update_pekerjaan->flag = 2;

        $update_pekerjaan->save();

        return response()->json([
            'status' => 200,
            'title' => 'success',
            'message' => 'Laporan Sesudah Berhasil!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Task::find($id);
        $item->update($request->all());

        return response()->json($item, 200);
    }

    public function delete($id)
    {
        $item = Task::find($id);
        $item->delete();

        return response()->json(null, 204);
    }
}
