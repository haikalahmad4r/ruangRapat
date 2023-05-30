<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $table = "divisi";

    protected $fillables = ["nama"];

    public function permohonan_rapat()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'divisi');
    }

    public function divisiAbsen()
    {
        return $this->hasMany('App\Models\Absen', 'divisi');
    }

    public function pegawai()
    {
        return $this->hasMany('App\Models\Pegawai', 'divisi');
    }

    public function pegawaiAbsen()
    {
        return $this->hasMany('App\Models\PegawaiAbsen', 'divisi_id');
    }
}
