<?php

namespace App\Http\Controllers;

use App\Division;
use App\Http\Requests\DivisionRequest;
use App\Sow;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DivisionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Division::query()->where('flag', 1);

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
                return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('bagian.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('bagian.destroy',$item->id) .'" method="POST">
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
            ->rawColumns(['flag','action'])
            ->make();
        }

        return view('pages.monitoring_bagian.index');
    }

    public function store(DivisionRequest $request)
    {
        $data = $request->all();
        $data['flag'] = 1;
        Division::create($data);

        return redirect()->route('bagian.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Division::findOrFail($id);

        return view('pages.monitoring_bagian.edit', compact('item'));
    }

    public function update(DivisionRequest $request, $id)
    {
        $data = $request->all();
        $item = Division::findOrFail($id);

        $item->update($data);

        return redirect()->route('bagian.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Division::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('bagian.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
