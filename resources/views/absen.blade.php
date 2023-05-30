@extends('layouts.app')

@section('content')
<?php

use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan_Rapat;
use App\Models\PegawaiAbsen;



$divisiRapat = Auth::user()->divisiRapat;
$divisiPegawai = PegawaiAbsen::all();





?>

@if(Session::has('sukses'))


<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    {{ Session::get('sukses') }}
</div>
@endif
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">ABSEN PESERTA RAPAT</h3>
        </div>

        <div class="panel-body">
            <form method="post" action="{{ route('simpanAbsen')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf

                <div class="form-group">
                    <label>Nama Pegawai</label>
                    <select name="PegawaiAbsen" id="PegawaiAbsen" class="kondisi form-control" required>
                        <option value="">Pilih Pegawai</option>
                        @foreach($PegawaiAbsen as $pa)
                        @if($pa->divisi_id == $divisiRapat)
                        <option value="{{$pa->id}}">{{$pa->nama}}</option>
                        @endif
                        @endforeach
                    </select>
                    <label for="">Divisi</label>
                    <select name="divisi" id="divisi" class="form-control" disabled required>
                        <option value="">Pilih Divisi</option>
                        @foreach($divisi as $d)
                        <option value="{{ $d->id }}"> {{ $d->nama }}
                        </option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-control" required>
                            <option value="">Pilih Jenis</option>
                            <?php
                            $jabatanAbsen = array(); // Array untuk melacak jabatan yang sudah digunakan
                            ?>
                            @foreach($PegawaiAbsen as $pa)
                            <?php
                            if (!in_array($pa->jabatan, $jabatanAbsen)) {
                                // Jika jabatan belum digunakan sebelumnya, tampilkan dalam opsi
                                $jabatanAbsen[] = $pa->jabatan; // Tambahkan jabatan ke dalam array yang sudah digunakan
                            ?>
                                <option value="{{$pa->jabatan}}">{{$pa->jabatan}}</option>
                            <?php
                            }
                            ?>
                            @endforeach
                        </select>
                    </div>

                </div>
                <input type="hidden" value="{{$id_permohonanRapat}}" name="id_permohonanRapat">
                <button type="submit" class="btn btn-dark waves-effect waves-light">ABSEN</button>
            </form>
        </div>
    </div>
</div>
<!-- {{$id_permohonanRapat}} -->

<script>
    $(document).ready(function() {

        $('#PegawaiAbsen').on('change', function() {
            var idPegawai = $(this).val();
            console.log(idPegawai); // Tambahkan pernyataan console.log di sini

            $.ajax({
                url: "jsonAbsen?id=" + idPegawai,

                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('#divisi option[value="' + data.divisi_id + '"]').prop('selected', true).trigger('change');
                    $('#jabatan option[value="' + data.jabatan + '"]').prop('selected', true).trigger('change');


                }

            });
        });

    })
</script>
@endsection