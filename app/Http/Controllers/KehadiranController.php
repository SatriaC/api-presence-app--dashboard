<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Location;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if (Auth::user()->privilege == 2 || 3) {
                $query = Attendance::with(['user','user.location','user.region'])->whereHas('user', function($user){
                    $user->where('id_wilayah', Auth::user()->id_wilayah);
                });
                // ->where('id_wilayah', Auth::user()->id_wilayah);
            } else {
                $query = Attendance::with(['user','user.location','user.region']);
            }

            if (request()->region != '') {
                $region = $request->region;
                $query->whereHas('user', function($q) use ($region)
                {
                    $q->where('id_wilayah', '=', $region);

                });
            }
            if (request()->location != '') {
                $location = $request->location;
                $query->whereHas('user', function($q) use ($location)
                {
                    $q->where('id_lokasi', '=', $location);

                });
            }

            $query->get();

            return DataTables::of($query)
            ->editColumn('foto_masuk', function($item){
                return $item->foto_masuk ? '<img src"'. Storage::url($item->foto_masuk) .'" border="0" width="100" class="img-rounded" align="center"' : '';
                // $url = asset('storage/'.$item->foto_masuk);
                // return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->editColumn('foto_pulang', function($item){
                // $url = asset('storage/'.$item->foto_pulang);
                // return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                return $item->foto_pulang ? '<img src"'. Storage::url($item->foto_pulang) .'" border="0" width="100" class="img-rounded" align="center"' : '';
            })
            ->editColumn('jam_masuk', function($item){
                return Carbon::parse($item->jam_masuk)->format('d-m-Y H:i');
            })
            ->editColumn('jam_pulang', function($item){
                return Carbon::parse($item->jam_pulang)->format('d-m-Y H:i');
            })
            ->addColumn('lokasi_masuk', function($item){
                $lokasi_absen_masuk = 'https://www.google.com/maps/?q='.$item->latitude_masuk.','.$item->longitude_masuk;
                return '<a href="'.$lokasi_absen_masuk.'" target="_blank">Lokasi Masuk</a>';
            })
            ->addColumn('lokasi_pulang', function($item){
                $lokasi_absen_pulang = 'https://www.google.com/maps/?q='.$item->latitude_pulang.','.$item->longitude_pulang;
                return '<a href="'.$lokasi_absen_pulang.'" target="_blank">Lokasi Pulang</a>';
            })
            ->addColumn('action', function($item){
                return '
                ';
            })
            ->rawColumns(['foto_masuk','foto_pulang','jam_masuk','jam_pulang','lokasi_masuk','lokasi_pulang','action'])
            ->make();
        }

        $lokasi = Location::where('flag', 1)->get();
        $wilayah = Region::where('flag', 1)->get();

        return view('pages.monitoring_kehadiran.index', compact(['lokasi','wilayah']));
    }
}
