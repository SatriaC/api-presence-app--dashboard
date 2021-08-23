<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Division;
use App\Region;
use App\Sow;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $pekerjaan = Task::all();
        $karyawan = User::all();
        $sow = Sow::where('flag', 1);

        if (request()->id_wilayah == 0) {
            # code...
            $pekerjaan = Task::all();
            $karyawan = User::all();
        }
        elseif (request()->id_wilayah != '') {
            $pekerjaan = $pekerjaan->where('id_wilayah', $request->id_wilayah);
            $karyawan = $karyawan->where('id_wilayah', $request->id_wilayah);
            // $sow = $sow;
        }

        $bagian = Division::where('flag', 1)->get();
        $data = [];
        $data_done = [];
        $data_onProgress = [];
        $data_notYet = [];
        foreach ($bagian as $item) {
            if (request()->id_wilayah == 0) {
                # code...
                $data[] = Task::where('id_bagian', $item->id)->count();
            }
            elseif (request()->id_wilayah != '') {
                $data[] = Task::where('id_bagian', $item->id)->where('id_wilayah', $request->id_wilayah)->count();
            } else {
                $data[] = Task::where('id_bagian', $item->id)->count();

            }

        }
        // dd($data);
        $data_onProgress = Task::where('flag', 2);
        $data_notYet = Task::where('flag', 1);
        $data_done = Task::where('flag', 3);

        if (request()->id_wilayah != '') {

        }

        // dd($data_notYet);
        $pekerjaan = $pekerjaan->count();
        $karyawan = $karyawan->count();
        $sow = $sow->count();
        $data_done = $data_done->count();
        $data_onProgress = $data_onProgress->count();
        $data_notYet = $data_notYet->count();

        $data_name = ['Done', 'On Progress'];
        $data_progress = [];




        foreach ($data_name as $item) {
            $pembilangDone = Task::where('flag', 3);
            $pembilangOnProgress = Task::where('flag', 2);
            if (request()->id_wilayah == 0) {
                # code...
            }
            elseif (request()->id_wilayah != '') {
                $pembilangDone = $pembilangDone->where('id_wilayah', $request->id_wilayah);
                $pembilangOnProgress = $pembilangOnProgress->where('id_wilayah', $request->id_wilayah);
            }

            $pembilangDone = $pembilangDone->count();
            $pembilangOnProgress = $pembilangOnProgress->count();

            if ($item == 'Done') {
                $data_progress[] = ($pembilangDone/$pekerjaan)*100;
            } else {
                $data_progress[] = ($pembilangOnProgress/$pekerjaan)*100;
            }
        }

        // dd($data_progress);

        $wilayah = Region::where('flag', 1)->get();

        return view('pages.dashboards', compact(['pekerjaan', 'karyawan', 'sow','data','data_done','data_onProgress','data_notYet','data_name','data_progress','wilayah']));
    }
}
