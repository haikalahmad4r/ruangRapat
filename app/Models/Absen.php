<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = "absen";
    protected $primaryKey = 'id_permohonan_rapat';


    protected $fillables = ["id", "id_permohonan_rapat", "nama", "divisi", "jabatan", "hari"];

    public function permohonan_rapat()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'id_permohonan_rapat');
    }

    public function divisiAbsen()
    {
        return $this->belongsTo('App\Models\Divisi', 'divisi')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }
    public function rekapAbsen()
    {
        return $this->belongsTo('App\Models\PegawaiAbsen', 'nama');
    }
}
