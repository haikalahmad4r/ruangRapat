<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";

    protected $fillables = ["no_induk", "nama", "divisi", "jabatan", "lampiran"];

    public function ruangRapat()
    {
        return $this->hasMany('App\Models\RuangRapat', 'id_pegawai');
    }
    public function permohonan_rapat()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'id_pegawai');
    }

    public function permohonan_rapat_notulen()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'notulen');
    }

    public function divisiModel()
    {
        return $this->belongsTo('App\Models\Divisi', 'divisi')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }
}
