<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Category;
use App\DetailSow;
use App\Http\Controllers\Controller;
use App\Sow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterDataController extends Controller
{

    public function sow()
    {
        $bagian = Auth::user()->id_bagian;
        $item = Sow::where([['flag','=', 1],['id_bagian', '=', $bagian]])->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function kategoriSow($id)
    {
        $item = Category::where([['flag','=', 1],['id_sow','=',$id]])->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function detailSow($id)
    {
        $item = DetailSow::where([['flag','=', 1],['id_kategori','=',$id]])->get();

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
}
