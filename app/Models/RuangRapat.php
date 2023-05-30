<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangRapat extends Model
{
    protected $table = "ruangrapat";

    protected $fillables = ["id", "nama", "kapasistas", "pegawai_id", "id_fasilitas_baru", "lokasi", "status"];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'id_pegawai')->withDefault([
            'nama' => '-'
        ]);
    }

    public function permohonan_rapat()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'id_ruangrapat');
    }

    //nama fungsi yang akan di panggil atau digunakan ketika melakukan relasi   
    public function fasilitas_baru()
    {
        return $this->belongsTo('App\Models\Fasilitas_baru', 'id_fasilitas_baru')->withDefault([
            'nama' => '-'
        ]);
    }

    // public function rapat()
    // {
    //     return $this->hasMany('App\Models\Rapat', 'id_rapat');
    // }
}
