<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas_Baru;
use Illuminate\Support\Facades\DB;


class FasilitasController extends Controller
{
    public function index()
    {
        # code
        $fasilitas_baru = DB::table('fasilitas_baru')->get();
        return view('fasilitas_baru', ['fasilitas_baru' => $fasilitas_baru]);
    }

    public function simpanFasilitas_baru(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:fasilitas,nama',
        ]);

        $simpan = DB::table('fasilitas_baru')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('fasilitas_baru')->with("sukses", "Fasilitas berhasil di tambah");
    }
}
