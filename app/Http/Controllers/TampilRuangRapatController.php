<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas_Baru;
use App\Models\Permohonan_Rapat;
use App\Models\RuangRapat;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class TampilRuangRapatController extends Controller
{
    //
    public function TampilRuang(Request $request)
    {
        $id = ('id');
        $data = RuangRapat::with('fasilitas_baru')->get();
        return response()->json($data);
        // dd($data);
    }

    public function ruangan_terpakai(Request $request)
    {

        RuangRapat::all();
        $data1 = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk', Carbon::now())->with('ruangrapat')->get();
        return response()->json($data1);
        // dd($data1);

    }
    public function ruangan_dibooking(Request $request)
    {

        RuangRapat::all();
        $data1 = Permohonan_Rapat::where('status', 1)->whereDate('waktu_masuk', Carbon::now())->with('ruangrapat')->get();
        return response()->json($data1);
        // dd($data1);

    }

    public function ruangan_tersedia(Request $request)
    {
        $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
            $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
        })->get();

        return response()->json($data1);
        dd($data1);
    }
}
        // $data2 = Fasilitas_Baru::get('nama');
