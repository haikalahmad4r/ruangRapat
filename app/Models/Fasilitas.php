<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = "fasilitas";

    protected $fillables = ["id", "nama", "kondisi"];

    public function permohonan_rapat()
    {
        return $this->hasMany('App\Models\Permohonan_Rapat', 'id_fasilitas');
    }
}
