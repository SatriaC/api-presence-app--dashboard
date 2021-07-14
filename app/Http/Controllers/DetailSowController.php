<?php

namespace App\Http\Controllers;

use App\DetailSow;
use App\Http\Requests\DetailSowRequest;
use App\Sow;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DetailSowController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = DetailSow::with(['sow']);

            return DataTables::of($query)
            ->addColumn('action', function($item){
                return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('detail-sow.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('detail-sow.destroy',$item->id) .'" method="POST">
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
            ->rawColumns(['action'])
            ->make();
        }

        $sows = Sow::all();

        return view('pages.monitoring_detail.index', compact('sows'));
    }

    public function store(DetailSowRequest $request)
    {
        $data = $request->all();
        DetailSow::create($data);

        return redirect()->route('detail-sow.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = DetailSow::findOrFail($id);
        $sows = Sow::all();

        return view('pages.monitoring_detail.edit', compact('item', 'sows'));
    }

    public function update(DetailSowRequest $request, $id)
    {
        $data = $request->all();
        $item = DetailSow::findOrFail($id);

        $item->update($data);

        return redirect()->route('detail-sow.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = DetailSow::findOrFail($id);
        $item->delete();

        return redirect()->route('detail-sow.index');
    }
}
