@extends('layouts.app')


@section('content')

<?php

use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan_Rapat;



$roleadmin = Auth::user()->role;
$ruangRapatUser = Auth::user()->adminRuangan;
$divisiRapat = Auth::user()->divisiRapat;
$permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
$jumlah_ditolak = Permohonan_Rapat::where('status', 3)->where('divisi', $divisiRapat)->count();
// $jumlah_ditolak = count($permohonan_rapat3); // Hitung jumlah permohonan_rapat3 yang ada
$jumlah_notif = Permohonan_Rapat::where('status_baca', 1)->where('status',  3)->where('divisi', $divisiRapat)->count();
// tambah kolom permohonan_rapat untuk status ditolak dibaca




?>
@if(Session::has('sukses'))
<div class="alert alert-info alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    {{ Session::get('sukses') }}
</div>
@endif

@if(Session::has('gagal'))
<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    {{ Session::get('gagal') }}
</div>
@endif


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                if ($roleadmin == 4) {
                ?><?php
                } else { ?>

                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#boostrapModal-2">Permohonan Tambah Rapat</button>
                </h4>
            </div>
        <?php
                }
        ?>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs navtab-bg">
            <li class="active">
                <a href="#permohonan" data-toggle="tab" aria-expanded="false">
                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                    <span class="hidden-xs">Di Proses </span>
                </a>
            </li>
            <?php

            ?>
            <li class="">

                <a href="#ditolak" data-toggle="tab" aria-expanded="true">
                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                    <span class="hidden-xs">Di Tolak</span> &nbsp;
                    @if($jumlah_notif > 0 )
                    <span id="balon-notif" class="badge badge-xs badge-danger"><?php echo $jumlah_notif; ?></span>
                    @endif
                </a>
            </li>
            <script>
                // $(document).ready(function() {
                //     $('body').on('click', '.edit_permohonan', function() {
                //         var id = $(this).attr('data-id');
                //         $.ajax({
                //             url: "{{ route ('editPermohonan')}}?id=" + id,
                //             type: "POST",
                //             dataType: "JSON",
                //             success: function(data) {

                //             }
                //         })
                //     })
                // })


                document.addEventListener('DOMContentLoaded', function() {

                    var tabDitolak = document.querySelector('a[href="#ditolak"]');
                    var balonNotif = document.getElementById('balon-notif');



                    // fungsi js agar ketika panel ditolak di  klik maka, span notif akan menghilang
                    tabDitolak.addEventListener('click', function() {
                        if (balonNotif) {
                            localStorage.setItem('balon_notif_shown', 'true');
                            balonNotif.remove();
                        }
                    });
                    tabDitolak.addEventListener('click', function() {
                        <?php $spanTolak = Permohonan_Rapat::where('status_baca', 1)->where('divisi', $divisiRapat)->pluck('id');
                        //mengambil id permohononan rapat dengan bebera kondisi tertentu (where), dengan menggunakan queryBuilder
                        // Fungsi pluck digunakan untuk mengambil nilai tunggal dari kolom yang ditentukan.

                        //ambil jumlah sttatus yang belum di baca dan hitung ada berapa dengan count
                        $count = Permohonan_Rapat::where('status_baca', 1)->Where('divisi', $divisiRapat)->count();

                        // dd($spanTolak);
                        ?>;

                        //menggunakana perulangan untuk mendapatkan setiap id dari yang di tolak 
                        <?php
                        for ($x = 0; $x < $count; $x++)
                        // kondisi x akan terus bertambah/loop sampai memiliki jumlah yg sama atau lebih besar dengan variabel count
                        { ?>
                            //fungsi javascript untuk mengubah nilai status baca dari 1 menjadi 0
                            var spanTolak = "<?php echo ($spanTolak[$x]); ?>";
                            // mendapatkan id dari permohonan rapat yang sudah di looping

                            $.ajax({
                                url: "{{ route ('editBaca')}}?id=" + spanTolak,
                                //pasing id pada routing

                                type: "GET",
                                dataType: "JSON",
                                success: function(data) {
                                    // console.log(data.id);
                                    $.ajax({

                                        //mengubah nilai di route
                                        url: "{{ route ('updateBaca')}}?id=" + data.id,
                                        type: "POST",
                                        data: {
                                            status_baca: 2,
                                            _token: '{!! csrf_token() !!}'
                                        },
                                    })
                                }
                            })

                        <?php }
                        ?>





                    });
                });
            </script>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="permohonan">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Rapat</th>
                                <th>Divisi</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Nama Ruangan</th>

                                <?php
                                if ($roleadmin < 3) { ?>
                                    <th>Opsi</th>
                                <?php } else {
                                }

                                ?>
                                <?php
                                if ($roleadmin < 3) { ?>
                                    <th>Persetujuan</th>
                                <?php } else {
                                }

                                ?>


                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($permohonan_rapat as $pr)


                            @if($ruangRapatUser == $pr->id_ruangrapat)

                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $pr->nama_rapat}}</td>
                                <td>{{ $pr->divisiPermohonan->nama}}</td>
                                <td>
                                    <?php
                                    echo date('D d M Y H:i', strtotime($pr->waktu_masuk));

                                    ?>
                                </td>
                                <td><?php
                                    echo date('D d M Y H:i', strtotime($pr->waktu_keluar));

                                    ?></td>

                                <td>
                                    {{ $pr ->ruangRapat->nama}}
                                </td>
                                <?php
                                if ($roleadmin < 3) { ?>
                                    <td>

                                        <a class="btn btn-sm btn-primary statusTerima" data-id="{{$pr->id}}"><i class="fas fa-check"></i> </a>
                                        <a class="btn btn-sm btn-danger  statusTolak" data-id="{{$pr->id}}" data-toggle="modal" data-target="#boostrapModal-3"><i class="fas fa-times"></i> </a>


                                    <?php } else {
                                }

                                    ?>


                                    </td>

                                    <?php
                                    if ($roleadmin < 3) { ?>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Opsi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class=" btn-sm  hapus_permohonan" data-id="{{$pr->id}}"><i class="fa fa-trash"></i></a>
                                                    </li>
                                                    <li><a class=" btn-sm  edit_permohonan" data-id="{{$pr->id}}">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </li>
                                                    <li> <a class=" btn-sm  detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}" data-divisi="{{$pr->divisiPermohonan->nama}}">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a> </li>
                                                </ul>
                                            </div>
                                        <?php } else {
                                    }
                                        ?>

                                        </td>
                            </tr>
                            @elseif($ruangRapatUser == 0)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $pr->nama_rapat}}</td>
                                <td>{{ $pr->divisiPermohonan->nama }}</td>
                                <td>
                                    <?php
                                    echo date('D d M Y H:i', strtotime($pr->waktu_masuk));

                                    ?>
                                </td>
                                <td><?php
                                    echo date('D d M Y H:i', strtotime($pr->waktu_keluar));

                                    ?></td>

                                <td>
                                    {{ $pr ->ruangRapat->nama}}
                                </td>
                                <?php
                                if ($roleadmin < 3) { ?>
                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opsi
                                            </button>
                                            <ul class="dropdown-menu">

                                                <li><a class="btn btn-sm  hapus_permohonan" data-id="{{$pr->id}}"><i class="fa fa-trash"></i></a>
                                                </li>
                                                <li><a class="btn btn-sm  edit_permohonan" data-id="{{$pr->id}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </li>
                                                <li> <a class="btn btn-sm  detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a> </li>
                                            </ul>
                                        </div>
                                    <?php } else {
                                }
                                    ?>

                                    </td>
                                    <?php
                                    if ($roleadmin < 3) { ?>
                                        <td>

                                            <a class="btn btn-sm btn-primary statusTerima" data-id="{{$pr->id}}"><i class="fas fa-check"></i> </a>
                                            <a class="btn btn-sm btn-danger  statusTolak" data-id="{{$pr->id}}" data-toggle="modal" data-target="#boostrapModal-3"><i class="fas fa-times"></i> </a>


                                        <?php } else {
                                    }

                                        ?>


                                        </td>


                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane" id="ditolak">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <table id="datatable2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Rapat</th>
                                    <th>Divisi</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Keluar</th>
                                    <th>Nama Ruangan</th>
                                    <th width="15%">Catatan</th>
                                    <?php
                                    if ($roleadmin < 3) { ?>
                                        <th>Opsi</th>
                                    <?php } else {
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach($permohonan_rapat3 as $pr)
                                @if($divisiRapat == $pr->divisi)

                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $pr->nama_rapat}}</td>
                                    <td>{{ $pr->divisiPermohonan->nama }}</td>

                                    <td>
                                        <?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_masuk));

                                        ?>
                                    </td>
                                    <td><?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_keluar));

                                        ?></td>

                                    <td>
                                        {{ $pr ->ruangRapat->nama}}
                                    </td>
                                    <td>

                                        {{ $pr ->catatan}}

                                    </td>

                                    <?php
                                    if ($roleadmin < 3) { ?>

                                        <td>


                                            <a class="btn btn-sm btn-danger hapus_permohonan" data-id="{{$pr->id}}"><i class="fa fa-trash"></i> </a>

                                            <a class="btn btn-sm btn-success detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                        </td>
                                    <?php
                                    } else {
                                    }
                                    ?>
                                </tr>
                                @elseif($divisiRapat == 0)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $pr->nama_rapat}}</td>
                                    <td>{{ $pr->divisiPermohonan->nama }}</td>

                                    <td>
                                        <?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_masuk));

                                        ?>
                                    </td>
                                    <td><?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_keluar));

                                        ?></td>

                                    <td>
                                        {{ $pr ->ruangRapat->nama}}
                                    </td>
                                    <td>

                                        {{ $pr ->catatan}}

                                    </td>

                                    <?php
                                    if ($roleadmin < 3) { ?>

                                        <td>
                                            <a class="btn btn-sm btn-danger hapus_permohonan" data-id="{{$pr->id}}"><i class="fa fa-trash"></i> </a>

                                            <a class="btn btn-sm btn-success detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                        </td>
                                    <?php
                                    } else {
                                    }
                                    ?>




                                    @endif
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="text-white">Rapat Di Setujui</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs navtab-bg">
            <li class="active">
                <a href="#setuju" data-toggle="tab" aria-expanded="false">
                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                    <span class="hidden-xs">Setujui</span>
                </a>
            </li>
            <li class="">
                <a href="#selesai" data-toggle="tab" aria-expanded="true">
                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                    <span class="hidden-xs">Selesai</span>
                </a>
            </li>


        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="setuju">
                <table id="datatable3" class="table table-striped table-bordered">
                    <thead>
                        <a href="export_excel" class="btn btn-success my-3" target="_blank">
                            <i class=" fa fa-file-excel-o"></i>
                        </a> &nbsp;
                        <a href="{{ url('/pdf_permohonan')}}" class="btn btn-danger my-3" target="_blank">
                            <i class=" fa fa-file-pdf-o"></i>
                        </a>

                        <tr>
                            <th>No</th>
                            <th>Nama Rapat</th>
                            <th>Divisi</th>
                            <th>Waktu Masuk</th>
                            <th>Tambahan</th>
                            <th>Jumlah Peserta</th>
                            <th>Nama Ruangan</th>

                            @if($roleadmin < 3) <th>Opsi</th>
                                @else
                                @endif

                                <th>Absensi</th>
                                <th>Notulensi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach($permohonan_rapat2 as $pr)


                        @if($ruangRapatUser == $pr->id_ruangrapat)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pr->nama_rapat}}</td>
                            <td>{{ $pr->divisiPermohonan->nama }}</td>

                            <td>
                                <?php
                                echo date('D d M Y H:i', strtotime($pr->waktu_masuk));
                                ?>
                            </td>
                            <td> {{$pr->id_fasilitas}}
                            </td>
                            <td>
                                {{$pr->jumlah_peserta}}

                            </td>
                            <td>
                                {{ $pr ->ruangRapat->nama}}
                            </td>
                            @if($roleadmin < 3) <td>
                                <a class="btn btn-sm btn-primary statusSelesai" data-id="{{$pr->id}}"><i class="fas fa-check"></i> Selesai </a>
                                <a class="btn btn-sm btn-success detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas2="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}"><i class="fa fa-info-circle"></i></a>
                                </td>
                                @else
                                @endif

                                <td>
                                    <a href="{{ url('/rekapAbsen' . $pr->id) }}" class="btn btn-sm btn-info"> <i class="fa fa-file-text-o"></i> Rekap</a>
                                    @if($roleadmin > 2)
                                    <a class="btn btn-sm btn-info kode_absen" data-id="{{$pr->id}}"><i class="fas fa-key"></i>Absen</a>
                                    @else
                                    @endif

                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info notulensi" data-id="{{$pr->id}}"></i>Notulensi</a>
                                </td>

                        </tr>
                        @elseif($ruangRapatUser == 0)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pr->nama_rapat}}</td>
                            <td>{{ $pr->divisiPermohonan->nama }}</td>

                            <td>
                                <?php
                                echo date('D d M Y H:i', strtotime($pr->waktu_masuk));
                                ?>
                            </td>
                            <td>
                                {{$pr->id_fasilitas}}
                            </td>
                            <td>
                                {{ $pr->jumlah_peserta}}
                            </td>
                            <td>
                                {{ $pr ->ruangRapat->nama}}
                            </td>
                            @if($roleadmin < 3) <td>
                                <a class="btn btn-sm btn-primary statusSelesai" data-id="{{$pr->id}}"><i class="fas fa-check"></i> Selesai </a>
                                <a class="btn btn-sm btn-success detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas2="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}"><i class="fa fa-info-circle"></i></a>
                                </td>
                                @else
                                @endif

                                <td>
                                    <a href="{{ url('/rekapAbsen' . $pr->id) }}" class="btn btn-sm btn-info"> <i class="fa fa-file-text-o"></i> Rekap</a>
                                    @if($roleadmin > 2)
                                    <a class="btn btn-sm btn-info kode_absen" data-id="{{$pr->id}}"><i class="fas fa-key"></i>Absen</a>
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-success notulensi" data-id="{{$pr->id}}"></i>Notulensi</a>

                                </td>
                        </tr>


                        @endif
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="tab-pane " id="selesai">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <a href="export_excel2" class="btn btn-success my-3" target="_blank">
                                    <i class=" fa fa-file-excel-o"></i>
                                </a> &nbsp;
                                <a href="{{ url('/pdf_permohonan2')}}" class="btn btn-danger my-3" target="_blank">
                                    <i class=" fa fa-file-pdf-o"></i>
                                </a>
                                <tr>
                                    <br>
                                    <th width="5%">No</th>
                                    <th>Nama Rapat</th>
                                    <th width="5%">Divisi</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Keluar</th>
                                    <th>Nama Ruangan</th>
                                    <th>Absensi</th>
                                    <th width="10%">Notulen</th>
                                    <?php
                                    if ($roleadmin < 3) { ?>
                                        <th width="10%">Opsi</th> <?php } else {
                                                                }
                                                                    ?>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach($permohonan_rapat4 as $pr)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $pr->nama_rapat}}</td>
                                    <td>{{ $pr->divisiPermohonan->nama }}</td>
                                    <td>
                                        <?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_masuk));
                                        ?>
                                    </td>
                                    <td><?php
                                        echo date('D d M Y H:i', strtotime($pr->waktu_keluar));
                                        ?></td>

                                    <td>
                                        {{ $pr ->ruangRapat->nama}}
                                    </td>
                                    <td>
                                        <a href="{{ url('/rekapAbsen' . $pr->id) }}" class="btn btn-sm btn-info"> <i class="fa fa-file-text-o"></i> Rekap</a>

                                        <a class="btn btn-sm btn-info kode_absen" data-id="{{$pr->id}}"><i class="fas fa-key"></i>Absen</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-default TampilNotulen" data-id="{{$pr->id}}"> Lampiran Notulen</a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($roleadmin < 3) { ?>
                                            <a class=" btn btn-sm btn-danger hapus_permohonan" data-id="{{$pr->id}}"><i class="fa fa-trash"></i>
                                            </a>
                                            <a class="btn btn-sm btn-success  detail_permohonan" data-id="{{$pr->id}}" data-pegawai="{{$pr->pegawai->nama}}" data-ruang="{{$pr->ruangRapat->nama}}" data-fasilitas="{{$pr->id_fasilitas}}" data-notulen="{{$pr->pegawai_notulen->nama}}" data-divisi="{{$pr->divisiPermohonan->nama}}">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                        <?php } else {
                                        }
                                        ?>
                                    </td>




                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Sudah Disetuju</h4>
            </div>
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Ambil data pegawai nama untuk di passing -->
<!-- Hapus Kendaraan -->
<!--simpan id dari setiap id di database -->

<!-- Modal  upload lampiran notulen -->
<div class="modal fade" id="modal_notulen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Upload Lampiran Notulensi</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('uploadNotulen')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <!-- <div class="form-group">
                        <label for="">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">- Pilih Status</option>
                            <option value="1">Diproses</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Di tolak</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="">Lampiran</label>
                        <input type="file" name="lampiranNotulen" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <input type="text" name="idpermohonan_rapat_lampiran" id="idpermohonan_rapat_lampiran" value="">
                        <!-- nama nya -->
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Upload</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal Nampil file notulen -->
<div class="modal fade" id="modal_TampilNotulen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="notulen"></h4>
            </div>
            <div class="modal-body">
                <div id="testing" class="form-group"></div>
                <!-- id testing dari yang ada di javascript -->
            </div>
        </div>
    </div>
</div>





<!-- Modal Isi Kode absen -->

<div class="modal fade" id="modal_kodeAbsen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="">Silahkan Isi Kode Rapat</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route  ('absen') }}" onkeydown="return event.key != 'Enter';">

                    <!--  tidak bisa mempassing js ke html -->
                    <!-- <form method="post" action="{{ route('absen')}}" onkeydown="return event.key != 'Enter';"> -->
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <div class="form-group">
                        <label for="">Kode rapat</label>
                        <input name="kode_absen_input" type="text" class="form-control" placeholder="Masukan Kode Rapat">
                        <!-- id tidak boleh bentrok -->
                    </div>



                    <div class="modal-footer">
                        <input type="hidden" name="kode_absen" id="kode_absen" value="">
                        <!-- <input type="text" name="kode_absen_url" id="kode_absen_url" value=""> -->

                        <!-- Menerima id_permohonan_rapat_kode -->
                        <input type="text" name="idpermohonan_rapat" id="id_permohonan_rapat_kode" value="">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>

                    </div>

                </form>
            </div>
        </div>
        <!-- id tidak boleh bentrok -->
    </div>
</div>








<!-- Modal  Detail -->
<!-- id tidak boleh bentrok -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Detail Permohonan Rapat</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="" class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5>Nama Pemohon</h5>
                                    </td>
                                    <td id="nama_pemohon_detail">

                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <h5>Deskripsi Rapat</h5>
                                    </td>
                                    <td id="deskripsi_rapat_detail">

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Jumlah Peserta</h5>
                                    </td>
                                    <td id="jumlah_peserta_detail"></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Ruang Rapat</h5>
                                    </td>
                                    <td id="ruang_detail"></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Fasilitas</h5>
                                    </td>
                                    <td id="fasilitas_detail"></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Notulen</h5>
                                    </td>
                                    <td id="notulen_detail"></td>

                                </tr>
                                <tr>
                                    <td>
                                        <h5>Kode Absen</h5>
                                    </td>
                                    <td id="kode_absen_detail"></td>

                                </tr>




                            </tbody>

                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Status Terima -->
<!-- id tidak boleh bentrok -->

<div class="modal fade" id="modal_editStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Terima Permohonan Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('statusTerima')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <label>Ruangan</label>
                    <select name="id_ruangrapat_status" id="id_ruangrapat_status" class="kondisi form-control">
                        <option value="">Pilih Ruangan</option>
                        @foreach($ruangRapat as $r)
                        <option value="{{$r->id}}">{{$r->nama}}</option>
                        @endforeach
                    </select>
                    <!-- <div class="form-group">
                        <label for="">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">- Pilih Status</option>
                            <option value="1">Diproses</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Di tolak</option>
                        </select>
                    </div> -->
                    <label>Catatan</label>
                    <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control" required></textarea>
                    <?php
                    $randomNumber = substr(uniqid(), 4, 5);
                    // dd($randomNumber);
                    ?>
                    <label for="">Kode Rapat</label>
                    <input type="text" name="kode_absen" id="kode_absen_detail" class="form-control" value="{{$randomNumber}}" readonly>

                    <div class="modal-footer">
                        <input type="hidden" name="idpermohonan_rapat" id="idpermohonan_rapat_terima" value="">
                        <input type="datetime" name="tglMasukTerima" id="tglMasukTerima" style="display:none;">
                        <input type="datetime" name="tglKeluarTerima" id="tglKeluarTerima" style="display:none;">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Terima</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Tambah Permohonan -->
<!-- id tidak boleh bentrok -->
<div class="modal fade" id="boostrapModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Tambah Permohonan Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route ('simpanPermohonan')}}" onkeydown="return event.key != 'Enter';">

                    @csrf

                    <div class="form-group">
                        <label>Nama Pemohon</label>
                        <input type="text" name="nama_pemohon" class="form-control" required>

                        <label for="">Divisi</label>
                        <?php
                        if ($divisiRapat > 0) {
                        ?>



                            <select name="divisi" id="" class=" form-control" disabled required>

                                <option>Select Item</option>

                                @foreach ($divisi as $d)
                                <!-- Memanggil nilai value divisi rapat agar sesuai dengan id dari divisi -->
                                <option value="{{ $d->id }}" {{ ( $d->id == $divisiRapat) ? 'selected' : '' }}> {{ $d->nama }}
                                    <!-- Default value select sesuai dengan id id divisi -->
                                    <!-- selected, fungsi dari php -->
                                    <!-- menyocokok id divisi dengan nilai di divisiRapat -->
                                    <!-- tanda ? berfungsi sebagai operator tennary -->

                                </option>
                                @endforeach
                            </select>



                        <?php
                        } else { ?>
                            <select name="divisi" id="" class=" form-control">
                                <option value="">Pilih Divisi</option>
                                @foreach($divisi as $d)
                                <option value="{{$d->id}}">{{$d->nama}}</option>
                                @endforeach
                            </select>

                        <?php
                        }
                        ?>
                        <label>Nama Rapat</label>
                        <input type="text" name="nama_rapat" class="form-control" required>
                        <!-- <!-ganti name menjadi sesuai degnan yang ada di database -->
                        <label>Waktu Masuk</label>
                        <input type="datetime-local" id="waktu_masukTambah" name="waktu_masuk" class="form-control" format="YYYY-MM-DDTHH:mm">
                        <label>Waktu Keluar</label>
                        <input type="datetime-local" id="waktu_keluarTambah" name="waktu_keluar" class="form-control" format="YYYY-MM-DDTHH:mm" required>
                        <label>Deskripsi</label>
                        <textarea name="deskripsi_rapat" id="" cols="30" rows="10" class="form-control" required></textarea>
                        <label>Jumlah Peserta</label>
                        <input type="number" name="jumlah_peserta" class="form-control" required>
                        <label>Ruangan</label>
                        <select name="id_ruangrapat" id="" class="kondisi form-control" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangRapat as $r)
                            <option value="{{$r->id}}">{{$r->nama}}</option>

                            @endforeach
                        </select>


                        <label for="">Fasilitas</label>
                        <br>
                        <select class="js-tambah-basic-multiple" name="namafasilitas[]" multiple="multiple" style="width: 100%;">
                            <option value="">Pilih Fasilitas</option>
                            @foreach($fasilitas as $f)
                            <option value="{{$f->nama}}">{{$f->nama}}</option>
                            @endforeach
                        </select>


                        <div>
                            <label>Notulen</label>
                            <input type="text" name="notulen" class="form-control" required>


                            <!-- <select name="notulen" class="kondisi form-control" required>
                                <option value="">Pilih notulen</option>
                                @foreach($pegawai as $p)
                                <option value="{{$p->id}}">{{$p->nama}}</option>
                                @endforeach
                            </select> -->
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Tambah</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tolak -->
<!-- id tidak boleh bentrok -->

<div class="modal fade" id="modal_statusTolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Tolak Permohonan Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('statusTolak')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <!-- <div class="form-group">
                        <label for="">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">- Pilih Status</option>
                            <option value="1">Diproses</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Di tolak</option>
                        </select>
                    </div> -->
                    <label>Catatan</label>
                    <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control" required></textarea>
                    <div class="modal-footer">
                        <input type="hidden" name="idpermohonan_rapat_tolak" id="idpermohonan_rapat_tolak" value="">
                        <!-- nama nya -->

                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Tolak</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Selesai -->
<!-- id tidak boleh bentrok -->

<div class="modal fade" id="modal_statusSelesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Ubah Status Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('statusSelesai')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <!-- <div class="form-group">
                        <label for="">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">- Pilih Status</option>
                            <option value="1">Diproses</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Di tolak</option>
                        </select>
                    </div> -->
                    <label>Catatan</label>
                    <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control" required></textarea>



                    <div class="modal-footer">
                        <input type="hidden" name="idpermohonan_rapat_selesai" id="idpermohonan_rapat_selesai" value="">
                        <!-- nama nya -->
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!--Modal Edit Permohonan -->
<!-- id tidak boleh bentrok -->
<div class="modal fade" id="modal_editpermohonan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Edit Permohonan Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('updatePermohonan')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <div class="form-group">
                        <label for="">Nama Pemohon</label>
                        <input id="nama_pemohon" name="nama_pemohon" type="text" class="form-control">
                        <!-- id tidak boleh bentrok -->
                    </div>
                    <label>Divisi</label>
                    <select name="divisi_edit" id="divisi_edit" class="kondisi form-control">
                        <!-- id tidak boleh bentrok -->
                        <option value="">Pilih Divisi</option>
                        @foreach($divisi as $d)
                        <option value="{{$d->id}}">{{$d->nama}}</option>
                        @endforeach
                    </select>


                    <div class="form-group">
                        <label for="">Nama Rapat</label>
                        <input id="nama_rapat" name="nama_rapat" type="text" class="form-control">
                        <!-- id tidak boleh bentrok -->

                    </div>
                    <div class="form-group">
                        <label for="">waktu masuk</label>
                        <input id="waktu_masuk" name="waktu_masuk" type="datetime-local" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="">waktu Keluar</label>
                        <input id="waktu_keluar" name="waktu_keluar" type="datetime-local" class="form-control">

                    </div>


                    <div class="form-group">
                        <label for="">Deskripsi Rapat</label>
                        <textarea name="deskripsi_rapat" id="deskripsi_rapat" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <label>jumlah peserta</label>
                    <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control">
                    <!-- id tidak boleh bentrok -->
                    <label>Ruangan</label>
                    <select name="id_ruangrapat" id="id_ruangrapat" class="kondisi form-control">
                        <!-- id tidak boleh bentrok -->
                        <option value="">Pilih Ruangan</option>
                        @foreach($ruangRapat as $r)
                        <option value="{{$r->id}}">{{$r->nama}}</option>
                        @endforeach
                    </select>

                    <label for="">Fasilitas</label>
                    <br>
                    <select class="js-edit-basic-multiple" name="fasilitas[]" id="edit-fasilitas" multiple="multiple" style="width:100%">
                        <option value="">Edit fasilitas</option>
                        @foreach($fasilitas as $f)
                        <option value="{{$f->nama}}">{{$f->nama}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label>Notulen</label>
                    <input type="text" name="notulen" id="notulensi" class="form-control">
                    <div class="modal-footer">
                        <input type="hidden" name="idpermohonan_rapat" id="idpermohonan_rapat" value="">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>

                    </div>

                </form>
            </div>
        </div>
        <!-- id tidak boleh bentrok -->
    </div>
</div>

<script>
    let select = "Cookie nih";
    document.cookie = "name=" + select;
</script>

<script>
    $(document).ready(function() {

        //Select2
        $('.js-tambah-basic-multiple').select2();
        $('#edit-fasilitas').select2();


        // let tgl_awal = $('#waktu_masukTambah').val();
        // let tgl_akhir = $('#waktu_keluarTambah').val();
        // if (new Date(tgl_akhir) < new Date(tgl_awal)) {
        //     alert('input 2 melebihi tanggal 1!');
        // } else {
        //     alert('berhasil');
        // }



        // Edit Permohonan //
        $('body').on('click', '.edit_permohonan', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editPermohonan')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat').val(data.id);
                    $('#nama_pemohon').val(data.nama_pemohon);
                    $('#divisi_edit option[value="' + data.divisi + '"]').prop(
                        'selected', true
                    );
                    $('#nama_rapat').val(data.nama_rapat);
                    $('#waktu_masuk').val(data.waktu_masuk);
                    $('#waktu_keluar').val(data.waktu_keluar);
                    $('#deskripsi_rapat').val(data.deskripsi_rapat);
                    $('#jumlah_peserta').val(data.jumlah_peserta);
                    $('#id_ruangrapat option[value="' + data.id_ruangrapat + '"]').prop(
                        'selected', true
                    );
                    $('#status').val(data.status.toString());
                    $('#id_pegawai option[value="' + data.id_pegawai + '"]').prop(
                        'selected', true);
                    if (data.id_fasilitas == null) {
                        $('#edit-fasilitas').val(data.id_fasilitas);
                    } else {
                        $('#edit-fasilitas').val(data.id_fasilitas.split(',')).trigger("change");
                        //.trigger("change") untuk memicu event change pada elemen select yang telah diubah nilainya oleh Select2. I
                    }
                    $('#notulen').val(data.notulen);
                    $('#modal_editpermohonan').modal('show');
                }
            });
        })

        //modal upload lampiran
        $('body').on('click', '.notulensi', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editSelesai')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat_lampiran').val(data.id);
                    $('#lampiran').val()
                    $('#modal_notulen').modal('show');
                }
            });
        })

        // modal tampil lampiran notulen
        $('body').on('click', '.TampilNotulen', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editSelesai')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    // Parameter data dalam fungsi success ini akan memuat data yang diterima dari server, yang dalam kasus ini berisi objek yang berisi data permohonan rapat yang dipilih beserta data lampiran-nya.
                    $('#idpermohonanrapat').val(data.id);

                    // Membuat tag object untuk menampilkan file notulen
                    var filename = data.lampiran;
                    var object = "<object data=\"notulen/{FileName}\"  width=\"100%\" height=\"500px\">";
                    object += "</object>";
                    object = object.replace(/{FileName}/g, filename);
                    $('#testing').html(object);

                    // Menampilkan nama file notulen
                    $('#notulen').html(data.lampiran);

                    // Menampilkan modal
                    $('#modal_TampilNotulen').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });




        //Modal Kode Absen
        $('body').on('click', '.kode_absen', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editPermohonan')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_permohonan_rapat_kode').val(data.id);
                    // mendapatkan id_permohononanrapat lalu di passing di formm modal yang memiliki id = "id_permohonan_rapat_kode
                    $('#kode_absen').val(data.kode_absen);
                    $('#kode_absen_url').val(data.kode_absen);
                    $('#modal_kodeAbsen').modal('show');


                }
            });
        })





        // Modal Terima
        $('body').on('click', '.statusTerima', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editTolak')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat_terima').val(data.id);
                    $('#id_ruangrapat_status option[value="' + data.id_ruangrapat + '"]').prop(
                        'selected', true
                    );

                    $('#tglMasukTerima').val(data.waktu_masuk);
                    $('#tglKeluarTerima').val(data.waktu_keluar);
                    $('#status').val(data.status.toString());
                    $('#catatan').val()
                    $('#modal_editStatus').modal('show');
                }
            });
        })

        //status Tolak
        $('body').on('click', '.statusTolak', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editTolak')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat_tolak').val(data.id);
                    $('#id_ruangrapat_status option[value="' + data.id_ruangrapat + '"]').prop(
                        'selected', true
                    );
                    $('#status').val(data.status.toString());
                    $('#catatan').val()
                    $('#modal_statusTolak').modal('show');
                }
            });
        })


        //status Selesai
        $('body').on('click', '.statusSelesai', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editSelesai')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat_selesai').val(data.id);
                    $('#id_ruangrapat_status option[value="' + data.id_ruangrapat + '"]').prop(
                        'selected', true
                    );
                    $('#status').val(data.status.toString());
                    $('#catatan').val()
                    $('#modal_statusSelesai').modal('show');
                }
            });
        })



        //Modal Detail
        $('body').on('click', '.detail_permohonan', function() {
            var id = $(this).attr('data-id');
            let dataPegawai = $(this).attr('data-pegawai');
            //buat variable  untuk menyimpan nama pegawai dari tombol detail
            let dataRuang = $(this).attr('data-ruang');
            let dataDivisi = $(this).attr('data-divisi');
            let dataFasilitas = $(this).attr('data-fasilitas');
            let dataNotulen = $(this).attr('data-notulen');

            $.ajax({
                url: "{{ route ('editPermohonan')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idpermohonan_rapat_detail').val(data.id);
                    $('#nama_pemohon_detail').text(data.nama_pemohon);
                    $('#divisi').val(data.divisi);
                    $('#divisi_detail').text(dataDivisi);
                    $('#deskripsi_rapat_detail').text(data.deskripsi_rapat);
                    $('#jumlah_peserta_detail').text(data.jumlah_peserta);
                    $('#ruang_detail').text(dataRuang);
                    //id di form/code           //nama kolom di database
                    $('#peserta_detail').text(dataPegawai);
                    //ambil data variable datapegawai untuk di tampilkan di modal
                    $('#fasilitas_detail').text(data.id_fasilitas);
                    $('#notulen_detail').text(data.notulen);
                    $('#kode_absen_detail').text(data.kode_absen);
                    $('#modal_detail').modal('show');

                    $.each(data, function(key, val) {
                        console.log(val.pegawai.nama)
                    });

                }
            });
        })





        //<!-- Hapus Permohonan -->
        $('body').on('click', '.hapus_permohonan', function() {
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                location.href = '<?php echo "hapusPermohonan" ?>' + id
                swal("Deleted!", "Your data file has been deleted.", "success");
            });
        });
    });
</script>

@endsection

<!-- Edit fasilitas -->

<!-- <div class="modal fade" id="modal_editFasilitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Edit Fasilitas</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('updateFasilitas')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input id="nama" name="nama" type="text" class="form-control">

                    </div>

                    <div class="form-group">
                        <label>Kondisi</label>
                        <select name="kondisi" id="kondisi" class="kondisi form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Baru">Baru</option>
                            <option value="Lama">Lama</option>
                            <option value="Bekas">Bekas</option>
                            <option value="Rusak">Rusak</option>


                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="idFasilitas" id="idFasilitas" value="">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default btn-sm waves-effect waves-light" value="simpanTolak">Simpan</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div> -->



<!-- <script>
    $(document).ready(function() {
        $('body').on('click', '.editFasilitas', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editFasilitas')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idFasilitas').val(data.id);
                    $('#nama').val(data.nama);
                    $('#kondisi option[value="' + data.kondisi + '"]').prop(
                        'selected', true
                    );


                    $('#modal_editFasilitas').modal('show');



                }
            })
        })

        $('body').on('click', '.hapusFasilitas', function() {
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                <!- location.href = '
                <!- 
               
            -->
<!-- ' + id -->

<!-- swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });

    }) -->
<!-- </script> -->