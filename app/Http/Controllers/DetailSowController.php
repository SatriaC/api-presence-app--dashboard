<?php

namespace App\Http\Controllers;

use App\DetailSow;
use App\Http\Requests\DetailSowRequest;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DetailSowController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = DetailSow::with(['category','category.sow','category.sow.division'])->orderby('created_at', 'desc');

            return DataTables::of($query)
                ->editColumn('flag', function($item){
                    if ($item->flag == 1) {
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
                            <a class="dropdown-item" href="' . route('detail-sow.edit', $item->id) . '">
                                Sunting
                            </a>
                            <form action="' . route('detail-sow.destroy', $item->id) . '" method="POST">
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

        $categories = Category::all();

        return view('pages.monitoring_detail.index', compact('categories'));
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
        $categories = Category::all();

        return view('pages.monitoring_detail.edit', compact('item', 'categories'));
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
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('detail-sow.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }
}
