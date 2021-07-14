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
            ->editColumn('photos_in', function($item){
                return $item->photos_in ? '<img src"'. Storage::url($item->photos_in) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('photos_out', function($item){
                return $item->photos_out ? '<img src"'. Storage::url($item->photos_out) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('times_in', function($item){
                return Carbon::parse($item->times_in)->format('d-m-Y H:i');
            })
            ->editColumn('times_out', function($item){
                return Carbon::parse($item->times_out)->format('d-m-Y H:i');
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
            ->rawColumns(['photos_in','photos_out','times_in','times_out','flag','action'])
            ->make();
        }

        return view('pages.monitoring_kehadiran.index');
    }
}
