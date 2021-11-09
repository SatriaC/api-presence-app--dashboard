<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Category;
use App\DetailSow;
use App\Http\Controllers\Controller;
use App\Sow;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MasterDataController extends Controller
{

    public function sow()
    {
        $bagian = Auth::user()->id_bagian;
        $item = Sow::where([['flag', '=', 1], ['id_bagian', '=', $bagian]])->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function kategoriSow($id)
    {
        $item = Category::where([['flag', '=', 1], ['id_sow', '=', $id]])->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function detailSow($id)
    {
        $item = DetailSow::where([['flag', '=', 1], ['id_kategori', '=', $id]])->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function absen()
    {
        $item = Attendance::where('id_user', Auth::guard('api')->user()->id)->orderBy('id', 'desc')->first();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function statusLaporan()
    {
        $itemApproved = Task::whereNotNull('approved_by')->whereNull('alasan_reject')->where('id_user', Auth::guard('api')->user()->id)->count();
        $itemRejected = Task::whereNotNull(['approved_by', 'alasan_reject'])->where('id_user', Auth::guard('api')->user()->id)->count();
        $itemPending = Task::whereNull(['approved_by', 'alasan_reject'])->where('id_user', Auth::guard('api')->user()->id)->count();
        $itemOnProgress = Task::where([['id_user', Auth::guard('api')->user()->id], ['flag', 1]])->count();
        $itemCompleted = Task::where([['id_user', Auth::guard('api')->user()->id], ['flag', 2]])->count();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => ['itemApproved' => $itemApproved, 'itemPending' => $itemPending, 'itemRejected' => $itemRejected, 'itemOnProgress' => $itemOnProgress, 'itemCompleted' => $itemCompleted]
        ]);
    }

    public function pekerjaanOnProgress()
    {
        // $item = Task::where([['id_user', Auth::guard('api')->user()->id], ['flag', 1]])->orderBy('id', 'desc')->get();
        $item = Task::select(['bm_pekerjaan.*','bm_sow.nama AS nama_sow','bm_kategorisow.nama AS nama_kategori_sow','bm_detailsow.nama AS nama_detail_sow'])
        ->leftJoin('bm_sow', 'bm_sow.id', '=', 'bm_pekerjaan.id_sow')
        ->leftJoin('bm_kategorisow', 'bm_kategorisow.id', '=', 'bm_pekerjaan.id_kategori')
        ->leftJoin('bm_detailsow', 'bm_detailsow.id', '=', 'bm_pekerjaan.id_detail')
        ->where([['bm_pekerjaan.id_user', Auth::guard('api')->user()->id], ['bm_pekerjaan.flag', 1], ['bm_pekerjaan.laporan', '!=', null]])
        ->orderBy('bm_pekerjaan.id', 'desc')->get();
        // nama Sow, kategori dan detail
        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function fotoPekerjaan($filename)
    {
        $path = storage_path('app/public/foto_pekerjaan/' . $filename);
        if (!File::exists($path)) {
            return response(['message' => 'File tidak ada'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-type', $type);
        return $response;
    }

    public function fotoSow($filename)
    {
        $path = storage_path('app/public/assets/ikon-sow/' . $filename);
        if (!File::exists($path)) {
            return response(['message' => 'File tidak ada'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-type', $type);
        return $response;
    }

    public function fotoAbsensi($filename)
    {
        $path = storage_path('app/public/foto_absensi/' . $filename);
        if (!File::exists($path)) {
            return response(['message' => 'File tidak ada'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-type', $type);
        return $response;
    }

    public function manualbook()
    {
        // $path = '/Manual Book/' . 'manual-book-mobile.pdf';
        // return Storage::disk('local')->download($path);
        $path = storage_path('app/Manual Book/' . 'manual-book-mobile.pdf');
        return response()->download($path);

        // return response()->json([
        //     'status' => 200,
        //     'title' => 'success',
        //     'message' => 'Absen Masuk Berhasil!',
        //     "data" => [
        //         'foto_masuk' => $file_name,
        //         'date' => $date,
        //         'time' => $time
        //     ]
        // ]);
    }
}
