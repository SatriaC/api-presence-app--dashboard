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
                # code... //dikasih where wilayah
                $query = DB::table('bm_absen')
                ->selectRaw("bm_absen.* ,bm_user.nama,bm_user.id_wilayah,bm_user.id_lokasi ,CONCAT ('https://www.google.com/maps/?q=',bm_absen.latitude_masuk,',',bm_absen.longitude_masuk) AS 'lokasi_absen_masuk',
                CONCAT ('https://www.google.com/maps/?q=',bm_absen.latitude_pulang,',',bm_absen.longitude_pulang) AS 'lokasi_absen_pulang'")
                ->leftJoin('bm_user', 'bm_user.id', '=', 'bm_absen.id_user')
                ->where('id_wilayah',  Auth::user()->id_wilayah)
                ->get();
            }
            // elseif (Auth::user()->privilege == 3) {
            //     # code... //dikasih where wilayah
            //     $region = Auth::user()->id_wilayah;
            //     $query = Attendance::with(['user'])->whereHas('user', function($q) use ($region)
            //     {
            //         $q->where('id_wilayah', '=', $region);

            //     })->get();
            // }
            else {
                $query = DB::table('bm_absen')
                ->selectRaw("bm_absen.* ,bm_user.nama,bm_user.id_wilayah,bm_user.id_lokasi ,CONCAT ('https://www.google.com/maps/?q=',bm_absen.latitude_masuk,',',bm_absen.longitude_masuk) AS 'lokasi_absen_masuk',
                CONCAT ('https://www.google.com/maps/?q=',bm_absen.latitude_pulang,',',bm_absen.longitude_pulang) AS 'lokasi_absen_pulang'")
                ->leftJoin('bm_user', 'bm_user.id', '=', 'bm_absen.id_user')
                ->get();
            }

            if (request()->id_wilayah != '') {
                $query->where('bm_user.id_wilayah', $request->id_wilayah );
            }
            if (request()->id_lokasi != '') {
                $query->where('bm_user.id_lokasi', $request->id_lokasi );
            }

            return DataTables::of($query)
            ->editColumn('foto_masuk', function($item){
                // return $item->foto_masuk ? '<img src"'. Storage::url($item->foto_masuk) .'"style="max-height:80px;"/>' : '';
                $url = asset('storage/'.$item->foto_masuk);
                return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->editColumn('foto_pulang', function($item){
                $url = asset('storage/'.$item->foto_pulang);
                return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
                // return $item->foto_pulang ? '<img src"'. Storage::url($item->foto_pulang) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('jam_masuk', function($item){
                return Carbon::parse($item->jam_masuk)->format('d-m-Y H:i');
            })
            ->editColumn('jam_pulang', function($item){
                return Carbon::parse($item->jam_pulang)->format('d-m-Y H:i');
            })
            ->editColumn('flag', function($item){
                if ($item->flag == 1) {
                    return 'AKTIF';
                } else {
                    return 'TIDAK AKTIF';
                    # code...
                }
            })
            ->addColumn('lokasi_masuk', function($item){
                return '<a href="'.$item->lokasi_absen_masuk.'" target="_blank">Lokasi Masuk</a>';
            })
            ->addColumn('lokasi_pulang', function($item){
                return '<a href="'.$item->lokasi_absen_pulang.'" target="_blank">Lokasi Pulang</a>';
            })
            ->addColumn('lokasi_kerja', function($item){
                return $item->user->location->nama ?? '';
                //coba yang concat diedit di editColumn aja, setelah itu menggunakan eloquent aja
            })
            ->addColumn('wilayah_kerja', function($item){
                return $item->user->region->nama ?? '';
            })
            ->addColumn('action', function($item){
                return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                                Sunting
                            </a>
                            <form action="#" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                ';
            })
            ->rawColumns(['foto_masuk','foto_pulang','jam_masuk','jam_pulang','lokasi_masuk','lokasi_pulang','lokasi_kerja','wilayah_kerja','flag','action'])
            ->make();
        }

        $lokasi = Location::where('flag', 1)->get();
        $wilayah = Region::where('flag', 1)->get();

        return view('pages.monitoring_kehadiran.index', compact(['lokasi','wilayah']));
    }
}
