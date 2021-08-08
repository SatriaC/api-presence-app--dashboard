<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            if (Auth::user()->privilege == 2) {
                # code... //dikasih where wilayah
                $query = Task::with(['user','user.division', 'detail', 'detail.category', 'detail.category.sow'])->where('id_wilayah', Auth::user()->id_wilayah);
            } elseif (Auth::user()->privilege == 3) {
                # code... //dikasih where wilayah
                $query = Task::with(['user','user.division', 'detail', 'detail.category', 'detail.category.sow'])->where('id_wilayah', Auth::user()->id_wilayah);
            } else {
                $query = Task::with(['user','user.division', 'detail', 'detail.category', 'detail.category.sow']);
            }

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
                    return '<span class="badge badge-warning">Butuh Approval</span>';
                } elseif ($item->flag == 2) {
                    return '<span class="badge badge-success">Disetujui</span>';
                } else {
                    return '<span class="badge badge-danger">Ditolak</span>';
                    # code...
                }
            })
            ->addColumn('action', function($item){

            if (Auth::user()->privilege == 2) {
                # code... //dikasih where wilayah

            } elseif (Auth::user()->privilege == 3) {
                return '<a href="#" class="btn btn-sm btn-info d-inline"
                        data-target="#modaldemo1-' . $item->id . '" data-toggle="modal">Approval Pekerjaan</a>
                        <div class="modal" id="modaldemo1-' . $item->id . '">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Approval Pekerjaan</h6><button
                                                aria-label="Close" class="close" data-dismiss="modal"
                                                type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                <div class="">
                                                    <h5>Data Pekerjaan Karyawan</h5>
                                                    <div class="form-group">
                                                        <label for="detail">Tanggal</label>
                                                        <input class="form-control" value="'.$item->reported_at.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Nama</label>
                                                        <input class="form-control" value="'.$item->user->nama.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Bagian</label>
                                                        <input class="form-control" value="'.$item->user->division->nama.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">SoW</label>
                                                        <input class="form-control" value="'.$item->detail->category->sow->nama.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Kategori SoW</label>
                                                        <input class="form-control" value="'.$item->detail->category->nama.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Detail SoW</label>
                                                        <input class="form-control" value="'.$item->detail->nama.'" type="text" disabled="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Foto Sebelum</label>
                                                        <img src"'. Storage::url($item->foto_before) .'"style="max-height:80px;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Foto Sesudah</label>
                                                        <img src"'. Storage::url($item->foto_after) .'"style="max-height:80px;"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="detail">Laporan Pekerjaan</label>
                                                        <input class="form-control" name="pnr" value="'.$item->laporan.'" type="text" disabled="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <form action="' . route('pekerjaan.approve', $item->id) . '" method="POST">
                                    ' . method_field('put') . csrf_field() . '
                                        <button type="submit" class="btn btn-sm btn-primary float-right">
                                            Approve
                                        </button>
                                    </form>
                                    <a href="/report/pekerjaan/' . $item->id . '/decline" class="btn btn-sm btn-secondary float-right">Reject</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
            } else {
                return '
                ';
            }
            })
            ->rawColumns(['foto_before','foto_after','approved_at','times_out','flag','action'])
            ->make();
        }

        return view('pages.monitoring_pekerjaan.index');
    }

    public function approve($id)
    {
        $item = Task::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->back()->with('success', 'Anda telah berhasil melakukan approval pekerjaan');
    }

    public function decline($id)
    {
        $item = Task::findOrFail($id);
        return view('pages.monitoring_pekerjaan.reject',compact('item'));
    }

    public function declinePost($id)
    {
        $item = Task::findOrFail($id);
        $item->update([
            'flag' => 3,
        ]);

        return redirect()->route('pekerjaan.index')->with('success', 'Anda telah berhasil melakukan reject pekerjaan');
    }
}
