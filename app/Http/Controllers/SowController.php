<?php

namespace App\Http\Controllers;

use App\Sow;
use App\Division;
use App\Http\Requests\SowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SowController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Sow::with(['division'])->where('flag', 1)->orderby('created_at', 'desc');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->privilege == 1) {
                        return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('sow.edit', $item->id) . '">
                                Sunting
                            </a>
                            <form action="' . route('sow.destroy', $item->id) . '" method="POST">
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
                ->rawColumns(['ikon', 'action'])
                ->make();
        }

        $divisions = Division::where('flag', 1)->get();

        return view('pages.monitoring_sow.index', compact('divisions'));
    }

    public function store(SowRequest $request)
    {
        $data = $request->all();
        // $data['ikon'] = $request->file('ikon');

        $nama_file = date('Ymd') . "_" . $data['ikon']->getClientOriginalName();
        $path = Storage::putFileAs('public/assets/ikon-sow', $data['ikon'], $nama_file);
        $data['ikon'] = 'assets/ikon-sow/' . $nama_file;
        Sow::create($data);

        return redirect()->route('sow.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Sow::findOrFail($id);
        $divisions = Division::all();

        return view('pages.monitoring_sow.edit', compact('item', 'divisions'));
    }

    public function update(SowRequest $request, $id)
    {
        $data = $request->all();
        $nama_file = date('Ymd') . "_" . $data['ikon']->getClientOriginalName();
        $path = Storage::putFileAs('public/assets/ikon-sow', $data['ikon'], $nama_file);
        $data['ikon'] = 'assets/ikon-sow/' . $nama_file;

        $item = Sow::findOrFail($id);

        $item->update($data);

        return redirect()->route('sow.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Sow::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('sow.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
