<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\DetailSow;
use App\Http\Controllers\Controller;
use App\Sow;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{

    public function sow()
    {
        $item = Sow::where('flag','=', 1)->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function kategoriSow()
    {
        $item = Category::where('flag','=', 1)->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }

    public function detailSow()
    {
        $item = DetailSow::where('flag','=', 1)->get();

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $item
        ]);
    }
}
