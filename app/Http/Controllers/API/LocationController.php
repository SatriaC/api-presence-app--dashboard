<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function locations()
    {
        $location = Location::where('regions_id', request()->regions_id)
            ->get();
            
        return response()->json([
            "code" => 200,
            "status" => 'success',
            "data" => $location
        ]);
    }
}
