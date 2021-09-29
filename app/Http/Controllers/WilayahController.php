<?php

namespace App\Http\Controllers;

use App\Http\Requests\WilayahRequest;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WilayahController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Region::query();

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
                            <a class="dropdown-item" href="'.route('wilayah.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('wilayah.destroy',$item->id) .'" method="POST">
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


        return view('pages.monitoring_wilayah.index');
    }

    public function store(WilayahRequest $request)
    {
        $data = $request->all();
        Region::create($data);

        return redirect()->route('wilayah.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Region::findOrFail($id);

        return view('pages.monitoring_wilayah.edit', compact('item'));
    }

    public function update(WilayahRequest $request, $id)
    {
        $data = $request->all();
        // $data['flag'] = $request->flag;
        $item = Region::findOrFail($id);

        $item->update($data);

        return redirect()->route('wilayah.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Region::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
