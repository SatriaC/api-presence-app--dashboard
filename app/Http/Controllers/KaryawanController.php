<?php

namespace App\Http\Controllers;

use App\User;
use App\Division;
use App\Location;
use App\Region;
use App\Privilege;
use App\Http\Requests\KaryawanRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::with(['division', 'location', 'region', 'privil']);

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
                            <a class="dropdown-item" href="'.route('karyawan.edit', $item->id).'">
                                Sunting
                            </a>
                            <form action="'. route('karyawan.destroy',$item->id) .'" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Ubah Status
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

        $divisions = Division::all();
        $regions = Region::all();
        $locations = Location::all();
        $privileges = Privilege::all();

        return view('pages.monitoring_karyawan.index', compact('divisions', 'regions', 'locations', 'privileges'));
    }

    public function store(KaryawanRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt('12345678');
        $data['flag'] = 1;
        User::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Anda telah berhasil melakukan input data');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $divisions = Division::all();
        $regions = Region::all();
        $locations = Location::all();
        $privileges = Privilege::all();

        return view('pages.monitoring_karyawan.edit', compact('user','divisions', 'regions', 'locations', 'privileges'));
    }

    public function update(KaryawanRequest $request, $id)
    {
        $data = $request->all();
        $item = User::findOrFail($id);
        $item->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Anda telah berhasil melakukan edit data');
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->update([
            'flag' => 2,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Anda telah berhasil melakukan hapus data');
    }


}
