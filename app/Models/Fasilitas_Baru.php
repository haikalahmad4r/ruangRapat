<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas_Baru extends Model
{
    protected $table = "fasilitas_baru";

    protected $fillables = ["id", "nama"];



    public function ruang_rapat()
    {
        return $this->hasMany('App\Models\RuangRapat', 'id_fasilitas_baru');
    }
}
