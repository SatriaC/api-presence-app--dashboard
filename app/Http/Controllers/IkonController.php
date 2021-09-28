<?php

namespace App\Http\Controllers;

use App\Ikon;
use App\Division;
use App\Http\Requests\IkonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class IkonController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Ikon::query();

            return DataTables::of($query)
                ->editColumn('status', function($item){
                    if ($item->status == 1) {
                        return 'AKTIF';
                    } else {
                        return 'TIDAK AKTIF';
                        # code...
                    }
                })
                ->addColumn('action', function ($item) {
                    if (Auth::user()->privilege == 1) {
                        return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('ikon.edit', $item->id) . '">
                                Sunting
                            </a>
                            <form action="' . route('ikon.destroy', $item->id) . '" method="POST">
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
                ->editColumn('ikon', function ($item) {
                    return $item->ikon ? '<img src="' . Storage::url($item->ikon) . '" style="max-height: 40px;" />' : '';
                })
                ->rawColumns(['ikon','status', 'action'])
                ->make();
        }


        return view('pages.monitoring_ikon.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // $data['ikon'] = $request->file('ikon');

        $nama_file = date('Ymd') . "_" . $data['ikon']->getClientOriginalName();
        $path = Storage::putFileAs('public/assets/ikon-sow', $data['ikon'], $nama_file);
        $data['ikon'] = 'assets/ikon-sow/' . $nama_file;
        Ikon::create($data);

        return redirect()->route('ikon.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Ikon::findOrFail($id);

        return view('pages.monitoring_ikon.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $nama_file = date('Ymd') . "_" . $data['ikon']->getClientOriginalName();
        $path = Storage::putFileAs('public/assets/ikon-sow', $data['ikon'], $nama_file);
        $data['ikon'] = 'assets/ikon-sow/' . $nama_file;

        $item = Ikon::findOrFail($id);

        $item->update($data);

        return redirect()->route('ikon.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Ikon::findOrFail($id);
        $item->update([
            'status' => 2,
        ]);

        return redirect()->route('ikon.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
