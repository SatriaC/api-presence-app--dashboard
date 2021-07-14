<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PekerjaanController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Task::with(['user','user.division', 'detail', 'detail.sow']);

            return DataTables::of($query)
            ->editColumn('photos_before', function($item){
                return $item->photos_before ? '<img src"'. Storage::url($item->photos_before) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('photos_after', function($item){
                return $item->photos_after ? '<img src"'. Storage::url($item->photos_after) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('created_at', function($item){
                return Carbon::parse($item->created_at)->format('d-m-Y H:i');
            })
            ->editColumn('flag', function($item){
                if ($item->flag == 1) {
                    return 'Diapprove';
                } else {
                    return 'Tidak Diapprove';
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
            ->rawColumns(['photos_before','photos_after','created_at','times_out','flag','action'])
            ->make();
        }

        return view('pages.monitoring_pekerjaan.index');
    }
}
