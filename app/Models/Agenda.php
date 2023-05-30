<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = "jadwal";

    protected $fillables = ["id", "nama_ruangan", "nama_rapat", "waktu_masuk"];

    public function permohonan_rapat()
    {
        return $this->belongsTo('App\Models\Permohonan_Rapat', 'nama_rapat', 'waktu_masuk');
    }
}
