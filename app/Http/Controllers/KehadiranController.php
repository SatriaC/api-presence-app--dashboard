<?php

namespace App\Http\Controllers;

use App\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KehadiranController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Attendance::with(['user']);

            return DataTables::of($query)
            ->editColumn('foto_masuk', function($item){
                return $item->foto_masuk ? '<img src"'. Storage::url($item->foto_masuk) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('foto_pulang', function($item){
                return $item->foto_pulang ? '<img src"'. Storage::url($item->foto_pulang) .'"style="max-height:80px;"/>' : '';
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
            ->rawColumns(['foto_masuk','foto_pulang','jam_masuk','jam_pulang','flag','action'])
            ->make();
        }

        return view('pages.monitoring_kehadiran.index');
    }
}
