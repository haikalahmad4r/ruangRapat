<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiAbsen extends Model
{
    protected $table = 'pegawai_absen';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'nama',
        'divisi_id',
        'jabatan',
    ];

    // Relasi dengan model Divisi
    public function divisiPegawai()
    {
        return $this->belongsTo('App\Models\Divisi', 'divisi_id')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }
    public function rekapAbsen()
    {
        return $this->hasMany('App\Models\Absen', 'nama')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }



    // ...
}
