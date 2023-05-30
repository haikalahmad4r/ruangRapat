<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RuangRapat;
use App\Models\Fasilitas;
use App\Models\Absen;
use App\Models\Permohonan_Rapat;
use App\Models\Divisi;
use App\Models\Fasilitas_Baru;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use PDF;
use DateInterval;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRapat;
use App\Models\PegawaiAbsen;

use App\Exports\PermohonanExport;
use App\Exports\PermohonanSelesaiExport;
use Maatwebsite\Excel\Facades\Excel;

use function GuzzleHttp\Promise\all;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function status()
    {
        $countAvailableRooms = DB::table('ruang_rapat')->where('status', 'available')->count();

        return view('home', compact('countAvailableRooms'));
    }


    //Ruang Rapat

    public function ruangRapat()
    {
        //Relasi menggunakan Eloquent
        $encryptedUrl = encrypt(route('ruangRapat'));
        $ruangRapat = RuangRapat::all();
        $pegawai = Pegawai::all();
        $fasilitas_baru = Fasilitas_Baru::all();

        return view('ruangRapat', ['ruangRapat' => $ruangRapat, 'pegawai' => $pegawai, 'fasilitas_baru' => $fasilitas_baru]);
    }

    //Tambah ruangan
    public function simpanRuangan(Request $request)
    // $request adalah sebuah parameter yang bertipe Request yang berfungsi sebagai objek yang menangkap request dari form.
    {
        $fasilitas_baru = $request->post('fasilitas_baru');
        if (is_null($fasilitas_baru)) {
            $implode =
                $request->post('fasilitas_baru');
        } else {
            $implode = implode(",", $fasilitas_baru);
        }
        $simpan = new RuangRapat;
        // $simpan = new RuangRapat; adalah baris kode yang digunakan untuk membuat objek baru dari model RuangRapat. Model adalah sebuah file yang berfungsi sebagai representation dari sebuah tabel pada database.
        $simpan->nama = $request->post('nama');
        $simpan->kapasitas = $request->post('kapasitas');
        $simpan->id_pegawai = $request->post('id_pegawai');
        $simpan->id_fasilitas_baru = $implode;
        $simpan->lokasi = $request->post('lokasi');
        $simpan->status = 1;
        // dd($implode);
        // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
        $simpan->save();

        return redirect('ruangRapat')->with("sukses", "Ruangan Berhasil  Ditambah");
    }
    //Penolakan



    //edit Ruangan
    public function editRuangan(Request $request)
    {
        $id = $request->input('id');
        $data = RuangRapat::find($id);
        return response()->json($data);
    }

    public function updateRuangan(Request $request)
    {

        $fasilitas_edit_baru = $request->post('fasilitas_edit_baru');
        if (is_null($fasilitas_edit_baru)) {
            $implode = $request->post('id_fasilitas_baru');
        } else {
            $implode2 = implode(",", $fasilitas_edit_baru);
        }
        $data = array(
            'nama' => $request->post('nama'),
            //nama di database                 //nama di form
            'kapasitas' => $request->post('kapasitas'),
            'id_pegawai' => $request->post('id_pegawai'),
            'id_fasilitas_baru' => $implode2,
            'lokasi' => $request->post('lokasi'),


        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('ruangrapat')->where('id', "=", $request->post('idruangRapat'))->update($data);
        return redirect('ruangRapat')->with("sukses", "Ruangan berhasil di ubah");
    }
    //Hapus Ruangan
    public function hapusRuangan($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('ruangrapat')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/ruangRapat')->with("Berhasil di hapus");
    }

    // Pegawai
    public function pegawai()
    {
        $pegawai = Pegawai::all();
        $divisi = Divisi::all();
        return view('pegawai', ['pegawai' => $pegawai, 'divisi' => $divisi]);
    }

    // Tambah Pegawai
    public function simpanPegawai(Request $request)
    {
        if ($request->hasFile('lampiran'))
        //cek apakah form dengan nama lampiran mengirim file
        {

            $fileLampiran = $request->file('lampiran');
            //menyimpan data dari file ke variable $fileLampiran

            //dari form ambil nama 
            //controller ambil dari nama

            //ubah nama file tersebut menggabungkan string dan waktu dan nama asli file dengan method getclientoriginalname
            $namafileLampiran = 'lampiran -' . time() . '-' . $fileLampiran->getClientOriginalName();
            //hasil nya akan di simpan di variable $namafilelampiran

            //menentukan direktori penyimpanan file 
            $tujuanUpload = 'lampiran';
            //variable $tujuanUpload menyimpan lokasi penyimpanan file


            $fileLampiran->move($tujuanUpload, $namafileLampiran);
            //method diatas berfungsi untuk memindahkan file yg diunggah ke direktori yang sudah ditentukan dengan variable $tujuan upload


            $validatedData = $request->validate([
                // digunakan untuk melakukan validasi pada data yang dikirimkan dengan aturan yang sudah ditentukan pada parameter $request  
                'no_induk' => 'required|unique:pegawai,no_induk',
                'nama' => 'required|max:200',
                'divisi' => 'required',
                'jabatan' => 'required',
            ]);

            $data = array(
                'no_induk' => $validatedData['no_induk'],
                'nama' => $validatedData['nama'],
                'divisi' => $validatedData['divisi'],
                'jabatan' => $validatedData['jabatan'],
                'updated_at' => Carbon::now(),
                'lampiran' => $namafileLampiran,
            );

            //jika user tidak melakukan input file lampiran, maka akan menggunakan syntax menyimpan data menggunakan kode yang ada di bawah ini
        } else {
            $validatedData = $request->validate([
                'no_induk' => 'required|unique:pegawai,no_induk',
                'nama' => 'required|max:200',
                'divisi' => 'required',
                'jabatan' => 'required',
                'lampiran' => '|10x10'
            ]);

            $data = array(
                'no_induk' => $validatedData['no_induk'],
                'nama' => $validatedData['nama'],
                'divisi' => $validatedData['divisi'],
                'jabatan' => $validatedData['jabatan'],
                'updated_at' => Carbon::now(),
            );
        }


        $simpan = DB::table('pegawai')->insert($data);
        return redirect('pegawai')->with("sukses", "Pegawai berhasil  di tambah");
    }

    //Modal lampiran Pegawai
    public function lampiranPegawai(Request $request)
    {
        $id = $request->input('id'); //ID dari button
        $data = Pegawai::find($id);
        //ambil data dari table pegawai- dan menemukan id yang sama yang sudah di pasing dari id di button
        return response()->json($data);
        // data di kembalikan dalam format json. yang berada dalam javascript
    }

    //Edit Pegawai
    public function editPegawai(Request $request)  //objek request sebagai parameter
    //request digunakan untuk mengambil data dari permintaan yang dikirm oleh aplikasi
    {
        $id = $request->input('id');
        //Baris kedua mengambil nilai "id" yang dikirim dari metode HTTP Request menggunakan method "input" dari objek $request, lalu nilai tersebut disimpan dalam variabel $id.

        $pegawai = Pegawai::find($id);
        //Baris ketiga melakukan pencarian data pegawai berdasarkan nilai $id menggunakan metode "find()" dari model Pegawai. Data pegawai yang ditemukan akan disimpan dalam variabel $pegawai.



        return response()->json($pegawai);
        //Baris terakhir mengembalikan data pegawai dalam format JSON sebagai respon dari HTTP Request menggunakan method "json()" dari objek "response()". Data pegawai akan dikirim ke pengguna melalui HTTP Response.

    }

    public function updatePegawai(Request $request)
    {
        // dd($request->post('nama'));
        // dd($request->post('idPegawaiedit'));
        if ($request->hasFile('new_lampiran')) {
            $fileLampiran = $request->file('new_lampiran');
            $namafileLampiran = 'lampiran -' . time() . '-' . $fileLampiran->getClientOriginalName();
            $tujuanUpload = 'lampiran';
            $fileLampiran->move($tujuanUpload, $namafileLampiran);



            $data = array(
                'no_induk' => $request['no_induk'],
                'nama' => $request['nama'],
                'divisi' => $request['divisi_edit'],
                'jabatan' => $request['jabatan'],
                'updated_at' => Carbon::now(),
                'lampiran' => $namafileLampiran,
            );
        } else {
            $validatedData = $request->validate([
                // 'id_induk' => 'required',
                // 'nama' => 'required|max:200',
                // 'divisi' => 'required',
                // 'jabatan' => 'required',
                // 'lampiran' => 'required|10x10'
            ]);

            $data = array(
                'no_induk' => $request['no_induk'],
                'nama' => $request['nama'],
                'divisi' => $request['divisi_edit'],
                'jabatan' => $request['jabatan'],
                'lampiran' => $request['lampiran'],
                'updated_at' => Carbon::now(),
            );
        }

        // $data = array(
        //     'no_induk' => $request->post('id_induk'),
        //     //nama di database                 //nama di form
        //     'nama' => $request->post('nama'),
        //     'jabatan' => $request->post('jabatan'),
        //     'divisi' => $request->post('divisi'),

        // );
        // dd($request->post('idPegawai'));
        $simpan = DB::table('pegawai')->where('id', "=", $request->post('idPegawaiedit'))->update($data);
        return redirect('pegawai')->with("sukses", "Data Pegawai Berhasil  di ubah");
    }


    //Hapus Pegawai
    public function hapusPegawai($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('pegawai')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/pegawai')->with("Berhasil di hapus");
    }





    //Fasilitas

    //show table
    public function fasilitas()
    {
        # code
        $fasilitas = DB::table('fasilitas')->get();
        return view('fasilitas', ['fasilitas' => $fasilitas]);
    }

    //tambah fasilitas
    public function simpanFasilitas(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:fasilitas,nama',
        ]);

        $simpan = DB::table('fasilitas')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('fasilitas')->with("sukses", "Fasilitas berhasil di tambah");
    }

    //edit Fasilitas


    public function editFasilitas(Request $request)
    {
        $id = $request->input('id');
        $fasilitas = Fasilitas::find($id);
        return response()->json($fasilitas);
    }

    public function updateFasilitas(Request $request)
    {
        $data = array(
            'nama' => $request->post('nama'),
            //nama di database                 //nama di form
            'kondisi' => $request->post('kondisi'),

        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('fasilitas')->where('id', "=", $request->post('idFasilitas'))->update($data);
        return redirect('fasilitas')->with("sukses", "Data Fasilitas berhasil di ubah");
    }


    //hapus Fasilitas

    public function hapusFasilitas($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('fasilitas')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('fasilitas')->with("Berhasil di hapus");
    }



    //Permohonan Rapat

    public function permohonan_rapat(Request $request)

    {
        $permohonan_rapat = Permohonan_Rapat::where('status', 1)->orderBy('id', 'desc')->get(); //status
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
        $permohonan_rapat4 = Permohonan_Rapat::where('status', 4)->get(); //status

        $jumlah_ditolak = count($permohonan_rapat3); // Hitung jumlah permohonan_rapat3 yang ada



        $divisi = Divisi::all();
        $pegawai = Pegawai::all();
        $fasilitas = Fasilitas::all();
        $ruangRapat = RuangRapat::all();
        $id_permohonan_rapat = Absen::all();

        // $rekapAbsen = Absen::where('id_permohonan_rapat', $id_permohonan_rapat)->get();
        //filter untuk menampilkan ruangrapat yang memiliki status  

        // $testing = Permohonan_Rapat::get()->load('pegawai')


        return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'divisi' => $divisi, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4,]);

        // return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'divisi' => $divisi, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4, 'rekapAbsen' => $rekapAbsen]);
    }



    //tambah Permohonan
    public function simpanPermohonan(Request $request)
    // $request adalah sebuah parameter yang bertipe Request yang berfungsi sebagai objek yang menangkap request dari form.
    { //cara penggunaaa
        $divisiRapat = Auth::user()->divisiRapat;
        $simpan = new Permohonan_Rapat();
        $ruangRapat = RuangRapat::all();
        $fasilitas = Fasilitas::where('kondisi', 'ok');
        $fasilitas = $request->post('namafasilitas');
        if (is_null($fasilitas)) {
            $implode =
                $request->post('namafasilitas');
        } else {
            $implode = implode(",", $fasilitas);
        }

        //Validasi Jumlah peserta dengan kapasitas ruang rapat
        $jumlah_peserta = $request->post('jumlah_peserta');
        // ambil nilai dari jumlah peserta dari form
        $id_ruangrapat = $request->post('id_ruangrapat');
        //mengambil id ruang rapat
        $ruangRapat = RuangRapat::where('id', $request->post('id_ruangrapat'))->first();
        // $ruangRapat = RuangRapat::where('kapasitas', 30)->first();
        // dd($ruangRapat);
        //mencari id ruang rapat di table ruang rapat
        $kapasitas = $ruangRapat->kapasitas;

        //ambil nilai dari kolom kapasitas dari ruang rapt, untuk di masukan ke dala var kapasitas
        // dd($kapasitas);

        //Cara agar waktu keluar tidak bisa sebelum waktu masuk
        $waktuMasuk  = $request->post('waktu_masuk');
        $waktuKeluar = $request->post('waktu_keluar');

        $nd1 = new DateTime($waktuMasuk);
        $nd2 = new DateTime($waktuKeluar);
        //DateTime merubah format tanggal menjadi angka
        //variable $nd1 beriksan nilai dari waktu masuk namun diubah formatnya menjadi angka dengan DateTime.
        //dirubah menjadi angka agar dapat dikurangi
        $interval = $nd1->diff($nd2);
        $tgl = $interval->format('%r%d');

        //
        if ($jumlah_peserta > $kapasitas) {
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! Jumlah Peserta melebihi kapasitas ");
        } elseif ($tgl < 0) {
            // kode untuk kondisi ini
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! " . date('d F Y', strtotime($waktuKeluar)) . " lebih awal dari " . date('d F Y', strtotime($waktuMasuk)) . " Silahkan Pilih yang benar ");



            // Kondisi Jika user yang login
        } elseif ($divisiRapat > 0) {
            $simpan->nama_rapat = $request->post('nama_rapat');
            $simpan->nama_pemohon = $request->post('nama_pemohon');
            $simpan->divisi = $divisiRapat;
            $simpan->waktu_masuk = $request->post('waktu_masuk');
            $simpan->waktu_keluar = $request->post('waktu_keluar');
            $simpan->deskripsi_rapat = $request->post('deskripsi_rapat');
            $simpan->jumlah_peserta = $request->post('jumlah_peserta');
            $simpan->id_ruangrapat = $request->post('id_ruangrapat');
            $simpan->id_pegawai = $request->post('id_pegawai');
            $simpan->id_fasilitas = $implode;
            $simpan->notulen = $request->post('notulen');
            $simpan->status = 1;

            // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
            $simpan->save();

            $emailruang = $request->post('id_ruangrapat');
            //menyimpan nilai id ruangrapat di var emailruang

            $email = User::where('adminRuangan', '=', $emailruang)->value('emailbaru');
            //mencari alamat email yang terkait dengan pengguna yanng memiliki nilai adminruangan sama sdengan nilai yang ada di variable emailruang
            //mengirim email sesuai berdasarkan id ruang rapat dengan nilai di admin ruangan
            // dd($email);
            $details = [
                'title' => 'Mail from websitepercobaan.com',
                'body' => 'This is for testing email using smtp'
            ];
            Mail::to($email)->send(new \App\Mail\EmailRapat($details));
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil Di tambahkan");

            // Kondisi Jika admin yang login
        } else {
            // kode untuk kondisi lainnya
            $simpan->nama_rapat = $request->post('nama_rapat');
            $simpan->nama_pemohon = $request->post('nama_pemohon');
            $simpan->divisi = $request->post('divisi');
            $simpan->waktu_masuk = $request->post('waktu_masuk');
            $simpan->waktu_keluar = $request->post('waktu_keluar');
            $simpan->deskripsi_rapat = $request->post('deskripsi_rapat');
            $simpan->jumlah_peserta = $request->post('jumlah_peserta');
            $simpan->id_ruangrapat = $request->post('id_ruangrapat');
            $simpan->id_pegawai = $request->post('id_pegawai');
            $simpan->id_fasilitas = $implode;
            $simpan->notulen = $request->post('notulen');
            $simpan->status = 1;

            // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
            $simpan->save();

            $emailruang = $request->post('id_ruangrapat');
            //menyimpan nilai id ruangrapat di var emailruang

            $email = User::where('adminRuangan', '=', $emailruang)->value('emailbaru');
            //mencari alamat email yang terkait dengan pengguna yanng memiliki nilai adminruangan sama sdengan nilai yang ada di variable emailruang
            //mengirim email sesuai berdasarkan id ruang rapat dengan nilai di admin ruangan
            // dd($email);
            $details = [
                'title' => 'Mail from websitepercobaan.com',
                'body' => 'This is for testing email using smtp'
            ];
            Mail::to($email)->send(new \App\Mail\EmailRapat($details));
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil Di tambahkan");
        }


        // if ($jumlah_peserta > $kapasitas) {

        //     return redirect('permohonan_rapat')->with("gagal", "Gagal input!! " . date('d F Y', strtotime($waktuKeluar)) .  " lebih awal dari " . date('d F Y', strtotime($waktuMasuk)));
        // }elseif(){


        // ;} else {
        // $simpan = new RuangRapat; adalah baris kode yang digunakan untuk membuat objek baru dari model RuangRapat. Model adalah sebuah file yang berfungsi sebagai representation dari sebuah tabel pada database.
        //     $simpan->nama_rapat = $request->post('nama_rapat');
        //     $simpan->waktu_masuk = $request->post('waktu_masuk');
        //     $simpan->waktu_keluar = $request->post('waktu_keluar');
        //     $simpan->deskripsi_rapat = $request->post('deskripsi_rapat');
        //     $simpan->jumlah_peserta = $request->post('jumlah_peserta');
        //     $simpan->id_ruangrapat = $request->post('id_ruangrapat');
        //     $simpan->id_pegawai = $request->post('id_pegawai');
        //     $simpan->id_fasilitas = $implode;
        //     $simpan->notulen = $request->post('notulen');
        //     $simpan->status = 1;
        //     // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
        //     $simpan->save();

        //     return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil Di tambahkan");
        // }
    }


    //hapus permohonan
    public function hapusPermohonan($id)
    {
        //Ambil data yang memilliki nilai permohonan rapat
        $permohonan = DB::table('permohonan_rapat')->where('id', $id)->first();
        $id_ruangrapat = $permohonan->id_ruangrapat;


        // cara mengubah status rapat menjadi 1
        DB::table('ruangrapat')->where('id', $id_ruangrapat)->update(['status' => 1]);

        // menghapus data permohonan rapat berdasarkan id yang dipilih
        DB::table('permohonan_rapat')->where('id', $id)->delete();

        return redirect('permohonan_rapat')->with("Permohonan Berhasil dihapus");
    }

    //Edit Permohonan //
    public function editPermohonan(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }

    // edit_status_baca 
    public function editBaca(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }

    //update status baca

    public function updateBaca(Request $request)
    {
        $id = $request->input('id');
        $data = array(
            'status_baca' => 2,
        );
        $simpan = DB::table('permohonan_rapat')->where('id', '=', $id)->update($data);
    }

    public function updatePermohonan(Request $request)
    {
        $fasilitas = $request->post('fasilitas');
        if (is_null($fasilitas)) {
            $implode =
                $request->post('fasilitas');
        } else {
            $implode = implode(",", $fasilitas);
        }

        $waktuMasuk  = $request->post('waktu_masuk');
        $waktuKeluar = $request->post('waktu_keluar');

        $nd1 = new DateTime($waktuMasuk);
        $nd2 = new DateTime($waktuKeluar);
        //DateTime merubah format tanggal menjadi angka
        //variable $nd1 beriksan nilai dari waktu masuk namun diubah formatnya menjadi angka dengan DateTime.
        //dirubah menjadi angka agar dapat dikurangi
        $interval = $nd1->diff($nd2);
        $tgl = $interval->format('%r%d');

        $data = array(
            'nama_rapat' => $request->post('nama_rapat'),
            'nama_pemohon' => $request->post('nama_pemohon'),
            'divisi' => $request->post('divisi_edit'),
            //nama di database                 //nama di form
            'waktu_masuk' => $request->post('waktu_masuk'),
            'waktu_keluar' => $request->post('waktu_keluar'),
            'deskripsi_rapat' => $request->post('deskripsi_rapat'),
            'jumlah_peserta' => $request->post('jumlah_peserta'),
            'id_ruangrapat' => $request->post('id_ruangrapat'),
            'id_pegawai' => $request->post('id_pegawai'),
            'id_fasilitas' => $implode,
        );

        if ($tgl < 0) {
            // kode untuk kondisi ini
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! " . date('d F Y', strtotime($waktuKeluar)) . " lebih awal dari " . date('d F Y', strtotime($waktuMasuk)) . " Silahkan Pilih yang benar ");
        } else {
            $simpan = DB::table('permohonan_rapat')->where('id', "=", $request->post('idpermohonan_rapat'))->update($data);
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil di edit");
        }

        // dd($request->post('idKendaraan'));

    }
    //Edit Status
    public function editStatus(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }


    public function statusTerima(Request $request)
    {
        $data = array(
            'id_ruangrapat' => $request->post('id_ruangrapat_status'),
            // 'status' => $request->post('status'),
            'status' => 2,
            'catatan' => $request->post('catatan'),
            'kode_absen' => $request->post('kode_absen')
        );
        $roleadmin = Auth::user()->role;

        $ruangRapat = RuangRapat::find('id');

        $idRapat =  $request->post('id_ruangrapat_status');
        //mengambil nilai dari form lalu disimpan ke variable $idrapat
        // dd($idRapat);

        $check = DB::table('permohonan_rapat')->where('id_ruangrapat', $idRapat)->where('status', 2)->value('waktu_masuk');

        //jika tanggal kosong/tidak ada status terima maka :
        if ($check === NULL) {
            $simpan = DB::table('permohonan_rapat')->where('id', "=", $request->post('idpermohonan_rapat'))->update($data);
            return redirect('permohonan_rapat')->with("sukses", "Permohonan Berhasil Diterima");
        }
        //jika sudah terdapat tanggal di table rapat diterima gunakan fungsi dibawa
        else {
            $valWaktuMasuk = DB::table('permohonan_rapat')->where('id_ruangrapat', $idRapat)->where('status', 2)->value('waktu_masuk');

            //validasi nilai waktu masuk yang ada di form dengan kondisi ruangan yang memiliki status 2
            $valWaktuKeluar = DB::table('permohonan_rapat')->where('id_ruangrapat', $idRapat)->where('status', 2)->value('waktu_keluar');

            // dd($valWaktuMasuk);

            $lastDate = new DateTime($valWaktuKeluar);
            //kalau tidak ada tanggal maka akan automatis mengambil hari-h !!.
            $tes = new DateTime();
            $period = new DatePeriod(
                new DateTime($valWaktuMasuk),
                new DateInterval('P1D'),
                $lastDate->modify('+1 day')
            );


            $tglMasuk = $request->post('tglMasukTerima');
            $tglKeluar = $request->post('tglKeluarTerima');

            $tglkeluarfix = new DateTime($tglKeluar);
            $jadwal = new DatePeriod(
                new DateTime($tglMasuk),
                new DateInterval('P1D'),
                $tglkeluarfix->modify('+1 day')
            );

            $tglMasukKeluar = [];
            foreach ($jadwal as $j) {
                $tglMasukKeluar[] = $j->format('Y-m-d');
            }

            $monthlyDates = [];
            foreach ($period as $p) {
                $monthlyDates[] = $p->format('Y-m-d');
            }

            $diffJadwal = array_diff($tglMasukKeluar, $monthlyDates);

            $result2 = array_intersect($monthlyDates, $tglMasukKeluar);

            $status2 = count($result2);
            // dd($status2);


            if ($status2 == 0) {
                $simpan = DB::table('permohonan_rapat')->where('id', "=", $request->post('idpermohonan_rapat'))->update($data);
                return redirect('permohonan_rapat')->with("sukses", "Permohonan Berhasil Diterima");
            } else {
                return redirect('permohonan_rapat')->with('gagal', "silahkan pilih waktu yang lain");
            }
        }
    }


    //Tolak permohonan




    public function update_status_baca(Request $request)
    {
        $data = array(
            'status_baca' => 2,
        );

        $simpan = DB::table('permohonan_rapat')->where('status_baca', 1)->update($data);

        return redirect('permohonan_rapat');
    }



    public function editTolak(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }
    public function statusTolak(Request $request)
    {
        $data = array(
            'status' => 3,
            'status_baca' => 1,
            'catatan' => $request->post('catatan')

        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_tolak'))->update($data);

        return redirect('permohonan_rapat')->with("gagal", "Permohonan Di tolak");
    }

    public function simpanTolak(Request $request)
    {
        $tolak = new RuangRapat;

        $tolak->catatan = $request->post('catatan');

        return redirect(('permohonan_rapat'));
    }
    // Upload Notulen

    public function Uploadnotulen(Request $request)
    {
        $fileNotulen = $request->file('lampiranNotulen');
        $tujuanNotulen = 'notulen';

        $namaFile = 'Notulensi-' . time() . '-' . $fileNotulen->getClientOriginalName();
        $fileNotulen->move($tujuanNotulen, $namaFile);

        $data = array(
            'lampiran' => $namaFile,
            'updated_at' => Carbon::now(),
        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_lampiran'))->update($data);

        return redirect('permohonan_rapat')->with("sukses", "Notulensi Berhasil Di Upload");
    }



    //Status Selesai
    public function TampilNotulen(Request $request)
    {
        $id = $request->input('id'); //ID dari button
        $data = Permohonan_Rapat::find($id);
        //ambil data dari table pegawai- dan menemukan id yang sama yang sudah di pasing dari id di button
        return response()->json($data);
        // data di kembalikan dalam format json. yang berada dalam javascript
    }
    public function editSelesai(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }
    public function statusSelesai(Request $request)
    {
        $data = array(
            'status' => 4,
            'catatan' => $request->post('catatan'),

        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_selesai'))->update($data);

        return redirect('permohonan_rapat')->with("sukses", "Rapat Selesai");
    }

    public function simpanSelesai(Request $request)
    {
        $tolak = new RuangRapat;

        $tolak->catatan = $request->post('catatan');

        return redirect(('permohonan_rapat'));
    }

    //jadwal
    public function agenda(Request $request)
    {
        $ruangRapat = RuangRapat::all();

        // buat filter tanggal  
        $awal  = $request->awal;
        //ambil dari id di form
        //ambil nilai inputan
        $akhir = $request->akhir;

        // dd($request->awal);
        $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
            $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
        })->get();

        // return response()->json($data1);

        if (is_Null($awal)) {
            $dt = Carbon::now();
            //untuk mendapatkan tanggal hari ini
            $permohonan_rapat = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk',   $dt->toDateString())->orderBy("id_ruangrapat", "desc")->get(); //status 
            $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
                $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
            })->get();
            return view('agenda', ['permohonan_rapat' => $permohonan_rapat, 'tglFilterAwal' => $dt, 'tglFilterAkhir' => $dt, 'data1' => $data1]);
        } else {
            //fungsi untuk filter jadwal di tanggal yang di pilih
            $permohonan_rapat = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk', '>=', $awal)->whereDate('waktu_masuk', '<=', $akhir)->orderBy('id_ruangrapat', 'desc')->get();
            $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
                $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
            })->get();
            return view('agenda', ['permohonan_rapat' => $permohonan_rapat, 'awal' => $awal, 'akhir' => $akhir, 'tglFilterAwal' => $request->awal, 'tglFilterAkhir' => $request->akhir, 'data1' => $data1]);
        }
    }

    //absen

    public function simpanAbsen(Request $request)
    {
        $timezone = 'Asia/Jakarta';
        $carbon = Carbon::now($timezone);
        $id = $request->post('id_permohonanRapat');
        $permohonanRapat = Permohonan_Rapat::find($id);
        $waktuMasuk = $permohonanRapat->waktu_masuk;
        $waktuKeluar = $permohonanRapat->waktu_keluar;

        // $tglkeluarDateTime = new DateTime($waktuKeluar);
        // $jadwal = new DatePeriod(
        //     new DateTime($waktuMasuk),
        //     new DateInterval('P1D'),
        //     $tglkeluarDateTime
        // );

        $selisihHari = Carbon::parse($waktuMasuk)->diffInDays($carbon);


        // $tglMasukKeluar = [];
        // foreach ($jadwal as $j => $ji) {
        //     $val1 = $ji->format('Y-m-d');
        //     $selisih = $carbon->diffInDays(Carbon::parse($val1));
        //     if ($val1 == $carbon->format('Y-m-d')) {
        //         $insert = +1;
        //     } elseif ($carbon > $val1) {
        //         $insert = $selisihHari;
        //     } else {
        //         $insert = "kosong";
        //     }
        //     $tglMasukKeluar[] = $val1;
        // }


        // dd($waktuMasuk);


        // dd($carbon);




        $simpan = new Absen;
        // $simpan = new RuangRapat; adalah baris kode yang digunakan untuk membuat objek baru dari model RuangRapat. Model adalah sebuah file yang berfungsi sebagai representation dari sebuah tabel pada database.

        $simpan->nama = $request->post('PegawaiAbsen');
        $simpan->id_permohonan_rapat = $request->post('id_permohonanRapat');
        $simpan->divisi = $request->post('divisi');
        $simpan->jabatan = $request->post('jabatan');
        // $simpan->hari = $insert;
        // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
        $simpan->save();

        return redirect('permohonan_rapat')->with("sukses", "Absen Berhasil ");
    }

    //Kode Absen
    public function absen(Request $request)
    {
        $kode_absen_input = $request->input('kode_absen_input');
        $kode_absen = $request->input('kode_absen');
        // $kode_absen_url = $request->input('kode_absen');
        $id_permohonanRapat = $request->input('idpermohonan_rapat');
        //ambil inputan idpermohonan_rapat dari form lalu di pasing ke variable id_permohonanRapat
        $PegawaiAbsen = PegawaiAbsen::all();

        $permohonan_rapat = Permohonan_Rapat::where('status', 1)->get(); //status
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
        $permohonan_rapat4 = Permohonan_Rapat::where('status', 4)->get(); //status
        $pegawai = Pegawai::all();
        $fasilitas = Fasilitas::all();
        $ruangRapat = RuangRapat::all();
        $divisi = Divisi::all();
        $namaPegawai = PegawaiAbsen::all();
        // $kode_absen_url = Permohonan_Rapat::find($kode_absen);

        // dd($id_permohonanRapat);




        //filter untuk menampilkan ruangrapat yang memiliki status  

        // $testing = Permohonan_Rapat::get()->load('pegawai')

        // dd($kode_absen);
        if ($kode_absen == $kode_absen_input) {
            return view('absen', ['id_permohonanRapat' => $id_permohonanRapat, 'divisi' => $divisi, 'PegawaiAbsen' => $PegawaiAbsen],)->with("sukses", "Silahkan isi Absen");
        } else {
            session()->flash('gagal', 'kode Rapat untuk absen salah, silahkan minta ketua rapat untuk kode yang benar');
            return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4, 'divisi' => $divisi], ['sukses' => 'kode']);
        }
    }

    public function rekapAbsen($id)
    {

        $id_permohonan_rapat = $id;
        $rekapAbsen = Absen::where('id_permohonan_rapat', $id_permohonan_rapat)->orderBy("hari", "asc")->get();
        $rekapAbsen2 = Absen::where([
            ['id_permohonan_rapat', $id_permohonan_rapat],
            ['hari', 2]
        ])->get();
        return view('rekapAbsen', ['rekapAbsen' => $rekapAbsen, 'id' => $id, 'rekapAbsen2' => $rekapAbsen2]);
    }

    //pdf
    public function pdf_rapat($id)
    {
        $permohonan_rapat = Permohonan_Rapat::find($id);
        $rekapAbsen = Absen::where('id_permohonan_rapat', $id)->orderBy("hari", "asc")->get();
        $pdf = PDF::loadview('pdf_rapat', ['rekapAbsen' => $rekapAbsen, 'permohonan_rapat' => $permohonan_rapat])->setpaper('a4', 'landscape');
        return $pdf->stream();
        // dd($id)
    }

    //pdf permohonan rapat
    public function pdf_permohonan()
    {
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $pdf = PDF::loadview('pdf_permohonan', ['permohonan_rapat2' => $permohonan_rapat2])->setpaper('a4', 'landscape');
        // dd($permohonan_rapat2);
        return $pdf->stream();
    }

    public function pdf_permohonan2()
    {
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 4)->get(); //status
        $pdf = PDF::loadview('pdf_permohonan_selesai', ['permohonan_rapat3' => $permohonan_rapat3])->setpaper('a4', 'landscape');
        return $pdf->stream();
    }



    // exel
    public function export_excel()
    {
        return Excel::download(new PermohonanExport, 'permohonan_rapat.xlsx');
        //download, fungsi dari php
    }

    public function export_excel2()
    {
        return Excel::download(new PermohonanSelesaiExport, 'permohonan_rapat.xlsx');
    }

    //divisi
    public function divisi()
    {
        $divisi = DB::table('divisi')->get();
        return view('divisi', ['divisi' => $divisi]);
    }

    //Tambah Divisi
    public function simpanDivisi(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|unique:divisi,nama',
        ]);

        $simpan = DB::table('divisi')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('divisi')->with("sukses", "Divisi berhasil di tambah");
    }

    // Edit Divisi


    public function editDivisi(Request $request)
    {
        $id = $request->input('id');
        $divisi = Divisi::find($id);
        return response()->json($divisi);
    }

    public function updateDivisi(Request $request)
    {
        $data = array(
            'nama' => $request->post('nama_divisi'),
            //nama di database                 //nama di form

        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('divisi')->where('id', "=", $request->post('iddivisi'))->update($data);
        return redirect('divisi')->with("sukses", "Data Divisi berhasil di ubah");
        // dd($simpan);
    }
    //hapus DIvisi
    public function hapusDivisi($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('divisi')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('divisi')->with("Berhasil di hapus");
    }

    //json
    public function jsonAbsen(Request $request)
    {
        $data = PegawaiAbsen::findOrFail($request->get('id'));
        echo json_encode($data);
    }
}
