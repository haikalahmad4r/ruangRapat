<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;
    protected $table = "rapat";

    protected $fillables = ["id", "idPermohonanRapat", "id_ruangrapat", "hariKe", "tanggal", "jamMulai", "jamSelesai", "status"];

    public function ruangRapat()
    {
        return $this->belongsTo('App\Models\RuangRapat', 'id_ruangrapat')->withDefault([
            'nama' => '-'
        ]);
    }

    public function permohonan_rapat()
    {
        return $this->belongsTo('App\Models\Permohonan_Rapat', 'idPermohonanRapat')->withDefault([
            'nama_rapat' => '-'
        ]);
    }
}
