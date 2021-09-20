<?php

namespace App\Http\Controllers;

use App\Location;
use App\Region;
use App\Sow;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
{

    public function index(Request $request)
    {
        $query = Task::with(['user','user.division', 'detail', 'detail.category', 'detail.category.sow']);
        // dd($query);
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

            if (request()->id_wilayah != '') {
                $query->where('id_wilayah', $request->id_wilayah );
            }
            if (request()->id_sow != '') {
                $query->where('id_sow', $request->id_sow );
            }
            if (request()->id_lokasi != '') {
                $location = $request->id_lokasi;
                $query->whereHas('user', function($q) use ($location)
                {
                    $q->where('id_lokasi', '=', $location);

                });
            }

            return DataTables::of($query)
            ->editColumn('foto_before', function($item){
                return $item->foto_before ? '<img src="' . Storage::url("foto_pekerjaan/".$item->foto_before) . '" border="0" width="100" class="img-rounded" align="center" />' : '';
            })
            ->editColumn('foto_after', function($item){
                return $item->foto_after ? '<img src="' . Storage::url("foto_pekerjaan/".$item->foto_after) . '" border="0" width="100" class="img-rounded" align="center" />' : '';
            })
            ->editColumn('approved_at', function($item){
                return Carbon::parse($item->approved_at)->format('d-m-Y H:i');
            })
            ->editColumn('flag', function($item){
                if ($item->flag == 1) {
                    return '';
                } elseif ($item->flag == 2) {
                    return '<span class="badge badge-warning">Butuh Approval</span>';
                } elseif ($item->flag == 3) {
                    return '<span class="badge badge-success">Disetujui</span>';
                } else {
                    return '<span class="badge badge-danger">Ditolak</span>';
                    # code...
                }
            })
            ->addColumn('lokasi', function($item){
                return $item->user->location->nama;
            })
            ->addColumn('action', function($item){
                if ($item->flag == 2) {
                    if (Auth::user()->privilege == 3 || 1) {
                        return '<a href="#" class="btn btn-sm btn-warning d-inline"
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
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_before) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Foto Sesudah</label>
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_after) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Laporan Pekerjaan</label>
                                                                <textarea name="" class="form-control" cols="30" rows="5" readonly="">'.$item->laporan.'</textarea>
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
                        return '<a href="#" class="btn btn-sm btn-info d-inline"
                                data-target="#modaldemo1-' . $item->id . '" data-toggle="modal"><i class="ti-info"></i></a>
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
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_before) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Foto Sesudah</label>
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_after) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Laporan Pekerjaan</label>
                                                                <textarea name="" class="form-control" cols="30" rows="5" readonly="">'.$item->laporan.'</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }

                }  else {
                    return '<a href="#" class="btn btn-sm btn-info d-inline"
                                data-target="#modaldemo1-' . $item->id . '" data-toggle="modal"><i class="ti-info"></i></a>
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
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_before) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Foto Sesudah</label>
                                                                <img src"'. Storage::url("foto_pekerjaan/".$item->foto_after) .'"style="max-height:80px;"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="detail">Laporan Pekerjaan</label>
                                                                <textarea name="" class="form-control" cols="30" rows="5" readonly="">'.$item->laporan.'</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                }
            })
            ->rawColumns(['foto_before','foto_after','approved_at','times_out','flag','action'])
            ->make();
        }

        $sow = Sow::where('flag', 1)->get();
        $lokasi = Location::where('flag', 1)->get();
        $wilayah = Region::where('flag', 1)->get();
        // dd($sow);

        return view('pages.monitoring_pekerjaan.index', compact(['sow', 'lokasi','wilayah']));
    }

    public function approve($id)
    {
        $item = Task::findOrFail($id);
        $item->update([
            'flag' => 3,
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
            'flag' => 4,
        ]);

        return redirect()->route('pekerjaan.index')->with('success', 'Anda telah berhasil melakukan reject pekerjaan');
    }
}
