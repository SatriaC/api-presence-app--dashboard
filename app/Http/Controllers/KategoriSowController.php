<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\KategoriSowRequest;
use App\Sow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KategoriSowController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::with(['sow'])->where('flag', 1);

            return DataTables::of($query)
            ->addColumn('action', function($item){
                if (Auth::user()->privilege == 1) {
                return '
                <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('kategori-sow.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('kategori-sow.destroy',$item->id) .'" method="POST">
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
            ->rawColumns(['action'])
            ->make();
        }

        $sows = Sow::all();

        return view('pages.monitoring_kategori.index', compact('sows'));
    }

    public function store(KategoriSowRequest $request)
    {
        $data = $request->all();
        Category::create($data);

        return redirect()->route('kategori-sow.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);
        $sows = Sow::all();

        return view('pages.monitoring_kategori.edit', compact('item', 'sows'));
    }

    public function update(KategoriSowRequest $request, $id)
    {
        $data = $request->all();
        $item = Category::findOrFail($id);

        $item->update($data);

        return redirect()->route('kategori-sow.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('kategori-sow.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
