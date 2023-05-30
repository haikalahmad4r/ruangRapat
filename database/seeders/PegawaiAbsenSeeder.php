<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PegawaiAbsen;

class PegawaiAbsenSeeder extends Seeder
{
    public function run()
    {
        $divisi = ['Divisi A', 'Divisi B', 'Divisi C'];
        $jabatan = ['Manajer', 'Supervisor', 'Staf'];

        for ($i = 1; $i <= 10; $i++) {
            PegawaiAbsen::create([
                'nama' => 'Pegawai ' . $i,
                'id_divisi' => rand(1, 3),
                'jabatan' => $jabatan[rand(0, 2)]
            ]);
        }
    }
}
