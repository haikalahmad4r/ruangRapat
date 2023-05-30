<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Permohonan_Rapat;
use Maatwebsite\Excel\Concerns\WithMapping;



class PermohonanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Permohonan_Rapat::with(['divisiPermohonan', 'ruangRapat'])
            ->select('nama_rapat', 'divisi', 'waktu_masuk', 'id_fasilitas', 'jumlah_peserta', 'id_ruangrapat')
            ->where('status', 2)
            ->get();
    }

    public function map($permohonan): array
    {
        return [
            $permohonan->nama_rapat,
            $permohonan->divisiPermohonan->nama,
            $permohonan->waktu_masuk,
            $permohonan->id_fasilitas,
            $permohonan->jumlah_peserta,
            $permohonan->ruangRapat->nama
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Rapat',
            'Divisi',
            'Waktu Masuk',
            'Fasilitas',
            'Jumlah Peserta',
            'Nama Ruangan'
        ];
    }
}
