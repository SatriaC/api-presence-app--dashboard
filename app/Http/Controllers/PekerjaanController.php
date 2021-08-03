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
            $query = Task::with(['user','user.division', 'detail', 'detail.category', 'detail.category.sow']);

            return DataTables::of($query)
            ->editColumn('foto_before', function($item){
                return $item->foto_before ? '<img src"'. Storage::url($item->foto_before) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('foto_after', function($item){
                return $item->foto_after ? '<img src"'. Storage::url($item->foto_after) .'"style="max-height:80px;"/>' : '';
            })
            ->editColumn('approved_at', function($item){
                return Carbon::parse($item->approved_at)->format('d-m-Y H:i');
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
            ->rawColumns(['foto_before','foto_after','approved_at','times_out','flag','action'])
            ->make();
        }

        return view('pages.monitoring_pekerjaan.index');
    }
}
