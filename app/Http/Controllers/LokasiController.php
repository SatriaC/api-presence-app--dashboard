<?php

namespace App\Http\Controllers;

use App\Http\Requests\LokasiRequest;
use App\Location;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Location::with(['region']);

            return DataTables::of($query)
            ->editColumn('flag', function($item){
                if ($item->flag == 1) {
                    return 'AKTIF';
                } else {
                    return 'TIDAK AKTIF';
                    # code...
                }
            })
            ->addColumn('action', function($item){
                if (Auth::user()->privilege == 1) {
                return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('lokasi.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('lokasi.destroy',$item->id) .'" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                ';
            } else {
                return '';
            }
            })
            ->rawColumns(['action','flag'])
            ->make();
        }

        $wilayah = Region::where('flag',1)->get();

        return view('pages.monitoring_lokasi.index', compact('wilayah'));
    }

    public function store(LokasiRequest $request)
    {
        $data = $request->all();
        Location::create($data);

        return redirect()->route('lokasi.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Location::findOrFail($id);
        $wilayah = Region::where('flag',1)->get();

        return view('pages.monitoring_lokasi.edit', compact('item', 'wilayah'));
    }

    public function update(LokasiRequest $request, $id)
    {
        $data = $request->all();
        // $data['flag'] = $request->flag;
        $item = Location::findOrFail($id);

        $item->update($data);

        return redirect()->route('lokasi.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Location::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('lokasi.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
