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
    public function index()
    {
        $pekerjaan = Task::all()->count();

        

        $karyawan = User::all()->count();
        $sow = Sow::all()->count();

        $bagian = Division::all();
        $data_done = [];
        $data_onProgress = [];
        $data_notYet = [];
        foreach ($bagian as $item) {
            $data[] = Task::where('id_bagian', $item->id)->count();

        }
        $data_onProgress = Task::where('flag', 2)->count();
        $data_notYet = Task::where('flag', 1)->count();
        $data_done = Task::where('flag', 3)->count();
        $data_name = ['Done', 'On Progress'];
        $data_progress = [];

        foreach ($data_name as $item) {
            $pembilangDone = Task::where('flag', 3)->count();
            $pembilangOnProgress = Task::where('flag', 2)->count();
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
