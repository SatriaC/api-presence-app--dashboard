<?php

namespace App\Http\Controllers;

use App\Division;
use App\Sow;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pekerjaan = Task::all()->count();
        $karyawan = User::all()->count();
        $sow = Sow::all()->count();
        $CSOB = Task::where('id_bagian', 1)->count();
        $notCSOB = Task::where('id_bagian','!=', 1)->count();

        $bagian = Division::all();
        $data_done = [];
        $data_onProgress = [];
        $data_notYet = [];
        foreach ($bagian as $item) {
                $pembilangDone = Task::where([['flag', 3],['id_bagian', $item->id]])->count();
                $pembilangOnProgress = Task::where([['flag', 2],['id_bagian', $item->id]])->count();
                $pembilangNotYet = Task::where([['flag', 1],['id_bagian', $item->id]])->count();
            if ($item->nama == 'CSOB') {
                $data_done[] = ($pembilangDone/$CSOB)*100;
                $data_onProgress[] = ($pembilangOnProgress/$CSOB)*100;
                $data_notYet[] = ($pembilangNotYet/$CSOB)*100;
            } else {
                $data_done[] = ($pembilangDone/$pekerjaan)*100;
                $data_onProgress[] = ($pembilangOnProgress/$pekerjaan)*100;
                $data_notYet[] = ($pembilangNotYet/$pekerjaan)*100;
            }

        }
        // dd($data_notYet);


        return view('pages.dashboards', compact(['pekerjaan', 'karyawan', 'sow','data_done','data_onProgress','data_notYet']));
    }
}
