<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PegawaiAbsen;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;






class DataPegawaiController extends Controller
{
    public function dataPegawai()
    {
        $pegawai = PegawaiAbsen::all();
        $divisi = Divisi::all();
        return view('dataPegawai', ['pegawai' => $pegawai, 'divisi' => $divisi]);
    }

    public function tambahPegawai(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:200',
            'divisi_id' => 'required',
            'jabatan' => 'required',
        ]);

        $data = array(
            'nama' => $validatedData['nama'],
            'divisi_id' => $validatedData['divisi_id'],
            'jabatan' => $validatedData['jabatan'],
        );
        $simpan = DB::table('pegawai_absen')->insert($data);
        return redirect('dataPegawai')->with("sukses", "Pegawai berhasil  di tambah");
    }

    public function hapusDataPegawai($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('pegawai_absen')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/dataPegawai')->with("Berhasil di hapus");
    }

    public function editDataPegawai(Request $request)
    {
        $id = $request->input('id');
        //Baris kedua mengambil nilai "id" yang dikirim dari metode HTTP Request menggunakan method "input" dari objek $request, lalu nilai tersebut disimpan dalam variabel $id.

        $pegawai = PegawaiAbsen::find($id);
        //Baris ketiga melakukan pencarian data pegawai berdasarkan nilai $id menggunakan metode "find()" dari model Pegawai. Data pegawai yang ditemukan akan disimpan dalam variabel $pegawai.

        return response()->json($pegawai);
    }
    public function updateDataPegawai(Request $request)
    {
        $validatedData = $request->validate([
            // 'id_induk' => 'required',
            // 'nama' => 'required|max:200',
            // 'divisi' => 'required',
            // 'jabatan' => 'required',
            // 'lampiran' => 'required|10x10'
        ]);

        $data = array(
            'nama' => $request['nama'],
            'divisi_id' => $request['divisi_id'],
            'jabatan' => $request['jabatan'],


        );

        $simpan = DB::table('pegawai_absen')->where('id', "=", $request->post('idPegawaiedit'))->update($data);
        return redirect('dataPegawai')->with("sukses", "Data Pegawai Berhasil  di ubah");
    }
}
