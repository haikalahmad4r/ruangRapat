<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Permohonan_Rapat extends Model
{
    protected $table = "permohonan_rapat";

    protected $fillables = ["id", "nama_rapat", "waktu_masuk", "waktu_keluar", "deskripsi_rapat", "jumlah_peserta", "id_ruangrapat", "id_pegawai", "id_fasilitas", "notulen", "status", "catatan", "kode_absen",  "status_baca"];


    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'id_pegawai')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }
    public function pegawai_notulen()
    {
        return $this->belongsTo('App\Models\Pegawai', 'notulen')->withDefault([
            'nama' => '-',
        ]); //mengambil data dari kolom notulen yang berisikan dari id_pegawai
    }

    public function fasilitas()
    {
        return $this->belongsTo('App\Models\Fasilitas', 'id_fasilitas')->withDefault([
            'nama' => '-',
        ]);
    }
    public function ruangRapat()
    {
        return $this->belongsTo('App\Models\RuangRapat', 'id_ruangrapat')->withDefault([
            'nama' => '-',
        ]);;
    }

    public function absen()
    {
        return $this->belongsTo('App\Models\Absen', 'id_absen')->withDefault([
            'nama' => '-',
        ]);
    }
    public function divisiPermohonan()
    {
        return $this->belongsTo('App\Models\Divisi', 'divisi')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['waktu_masuk'])->translatedFormat('1, d F Y');
    }

    //tidak bisa sama dengan yang ada di table 
}
