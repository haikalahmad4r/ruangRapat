@extends('layouts.app')

@section('content')
<?php

use App\Models\Permohonan_Rapat;
use App\Models\Pegawai;
use App\Models\Fasilitas;
use App\Models\RuangRapat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Diff\Diff;

$roleadmin = Auth::user()->role;


use function PHPUnit\Framework\isNull;

$pegawai = Pegawai::count();
$fasilitas = Fasilitas::count();
$ruangrapat = RuangRapat::count();


//menggunakan method count untuk menghitung dari table ruangrapat.

$permohonan = Permohonan_Rapat::where('status', 2)->count();
$permohonan1 = Permohonan_Rapat::where('status', 1)->count();
$permohonan2 = Permohonan_Rapat::Where('status', 3);


$januari = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '01')->count();
// menghitung jumlah rapaat selesai dengan method where dan count
$februari = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '02')->count();
$maret = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '03')->count();
$april = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '04')->count();
$mei = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '05')->count();
$juni = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '06')->count();
$juli = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '07')->count();
$agustus = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '08')->count();
$september = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '09')->count();
$oktober = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '10')->count();
$november = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '11')->count();
$desember = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '12')->count();



// menghitung permohonan rapat yang di terima
$ruangTerpakai = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk', Carbon::now())->count();
//menghitung permohonan raapat yang di booking
$ruangTerpakai2 = Permohonan_Rapat::where(function ($query) {
    $query->where('status', 2)
        ->orWhere('status', 1);
})
    ->whereDate('waktu_masuk', Carbon::now())
    ->distinct('id_ruangrapat')
    ->count();
//distinct : untuk memastikan jika ada id yang sama maka hanya dihtiung sekali
$ruangDibooking = Permohonan_Rapat::where('status', 1)
    ->whereDate('waktu_masuk', Carbon::now())
    ->distinct('id_ruangrapat')
    ->count();

//menghitung ruang rapat yang tersedia
$ruangrapat_tersedia = $ruangrapat - $ruangTerpakai2;
// dd($ruangrapat_tersedia);



//grafik rapat
// $ruangexdirut = Permohonan_Rapat::where('id_ruangrapat', 1)->where('status', 4)->count();
// $ruangDirut = Permohonan_Rapat::where('id_ruangrapat', 2)->where('status', 4)->count();
// $ruangDirop = Permohonan_Rapat::where('id_ruangrapat', 3)->where('status', 4)->count();
// $ruangDirum = Permohonan_Rapat::where('id_ruangrapat', 4)->where('status', 4)->count();
// $ruangAula = Permohonan_Rapat::where('id_ruangrapat', 5)->where('status', 4)->count();



// dd($ruangAula);









?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">

            <h4 class="pull-left page-title">BOOKING RUANG RAPAT </h4>
            <?php



            ?>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">

    @if($roleadmin > 2 )
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Ruang Rapat Tersedia </h3>
            </div>
            <div class="panel-body btn ruangan_tersedia">
                <h3 class=""><b><?php
                                echo $ruangrapat_tersedia
                                ?></b></h3>


            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Ruang Rapat Di Booking </h3>
            </div>
            <div class="panel-body btn ruangan_dibooking">
                <h3 class=""><b><?php
                                echo $ruangDibooking
                                ?></b></h3>


            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title ">Ruangan Terpakai </h3>
            </div>
            <div class="panel-body btn ruangan_terpakai">
                <h3 class=""><b><?php
                                echo $ruangTerpakai
                                ?></b></h3>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Ruang Rapat </h3>
            </div>
            <div class="panel-body btn ruangrapat">
                <h3 class=""><b><?php
                                echo $ruangrapat
                                ?></b></h3>
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Rapat Diterima </h3>
            </div>
            <div class="panel-body">
                <h3 class=""><b><?php
                                echo $permohonan
                                ?></b></h3>


            </div>
        </div>
    </div>


    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Rapat Di Ajukan </h3>
            </div>
            <div class="panel-body">
                <h3 class=""><b><?php
                                echo $permohonan1
                                ?></b></h3>


            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Jumlah Admin </h3>
            </div>
            <div class="panel-body">
                <h3 class=""><b><?php
                                echo $pegawai
                                ?></b></h3>

            </div>
        </div>


    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h3 class="panel-title">Ruang Rapat </h3>
            </div>
            <div class="panel-body btn ruangrapat">
                <h3 class=""><b><?php
                                echo $ruangrapat
                                ?></b></h3>
            </div>
        </div>
    </div>


    @endif







    <div class="col-lg-12">
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Ruang Rapat digunakan</h3>
            </div>
            <div>
                <canvas id="chart" height="50"></canvas>
            </div>
        </div>
    </div>



    <div class="col-lg-12">
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Jumlah Rapat</h3>
            </div>
            <div>
                <canvas id="myChart" height="50"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Rapat per Divisi</h3>
            </div>
            <div>
                <canvas id="lineChart" height="50"></canvas>
            </div>
        </div>
    </div>

    <!-- modal Looping table Ruang Rapat -->
    <div class="modal fade" id="modal_loop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel-1">Ruang Rapat</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <table id="records_table" border="1" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Fasilitas</th>
                                    <th>Kapasitas</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Looping rapat dipakai -->
    <div class="modal fade" id="modal_loop2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel-1">Ruang Rapat</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <table id="records_table" border="1" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Fasilitas</th>
                                    <th>Kapasitas</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- memanggil chart js dengan cdn -->

<script>
    //Grafik Jumlah penggunaan ruang rapat
    // Chart Grafik Jumlah Rapat
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'desember'],
            //berisikan nilai dari sumbu x
            datasets: [{
                label: 'Jumlah Rapat',
                data: [<?php echo $januari . "," . $februari . "," . $maret . "," . $april . "," . $mei . "," . $juni . "," . $juli . "," . $agustus . "," . $september . "," . $oktober . "," . $november . "," . $desember ?>],
                // 
                borderWidth: 2,
                backgroundColor: [
                    'rgb(200, 210, 135)',


                ],
            }]
        },
        // konfigurasi chart
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    new Chart(document.getElementById("chart"), {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'desember'],
            datasets: [{


                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"ruangDirut" . $x} = Permohonan_Rapat::where('id_ruangrapat', 2)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                                echo ${"ruangDirut" . $x} . ",";
                                $test = Permohonan_Rapat::where('id_ruangrapat', 2)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                            }

                            //id ruangrapat tidak boleh berbeda
                            //ketika sudah masuk ke database lalu id di table ruangrapat berubah, maka di table permohonan rapat tidak berubah otomatis

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Ruang Dirut",
                    borderColor: "#F01212",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"ruangDirum" . $x} = Permohonan_Rapat::where('id_ruangrapat', 4)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                                echo ${"ruangDirum" . $x} . ",";
                            }

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Ruang Dirum",
                    borderColor: "#F0CB12",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"ruangAula" . $x} = Permohonan_Rapat::where('id_ruangrapat', 5)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                                echo ${"ruangAula" . $x} . ",";
                            }

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Ruang Aula",
                    borderColor: "#3cba9f",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"ruangDirop" . $x} = Permohonan_Rapat::where('id_ruangrapat', 3)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                                echo ${"ruangDirop" . $x} . ",";
                            }

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Ruang Dirop",
                    borderColor: "#12F046",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"ruangExdirut" . $x} = Permohonan_Rapat::where('id_ruangrapat', 1)->whereMonth('waktu_keluar', '0' . $x)->where('status', '4')->count();
                                echo ${"ruangExdirut" . $x} . ",";
                            }

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Ruang Ex Dirut",
                    borderColor: "#12F0D3",
                    fill: false
                },




            ]
        },
        options: {
            title: {
                display: true,
                text: 'Chart JS Multiple Lines Example'
            }
        }
    });
</script>




<!-- Chart Rapat Divisi -->

<!-- Modal Looping table -->
<script>
    //cek erro js di console
    //looping buton
    $(document).ready(function() {
        $('body').on('click', '.ruangrapat', function() {
            $.ajax({
                url: "/tampilruang",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var trHTML = '';
                    $.each(data, function(i, item) {
                        var nomor = i + 1;
                        trHTML += '<tr><td>' + nomor + '</td><td>' + item.nama + '</td><td>' + item.id_fasilitas_baru + '</td><td>' + item.kapasitas + '</td></tr>';
                    });
                    //kode diatas method looping untuk table di javascript
                    $('#records_table tbody').html(trHTML);
                    $('#modal_loop').modal('show');
                }
            });
        });
    });

    //ruangan terpakai

    $(document).ready(function() {
        $('body').on('click', '.ruangan_terpakai', function() {
            $.ajax({
                url: "/ruangan_terpakai",
                type: "GET",
                dataType: "JSON",
                success: function(data1) {
                    var trHTML = '';
                    $.each(data1, function(i, item) {
                        //bikin var untuk nomor dengan looping
                        var nomor = i + 1;
                        trHTML += '<tr><td>' + nomor + '</td><td>' + item.ruangrapat.nama + '</td><td>' + item.ruangrapat.id_fasilitas_baru + '</td><td>' + item.ruangrapat.kapasitas + '</td></tr>';
                        //cara pemanggilan relasi table
                    });
                    $('#records_table tbody').html(trHTML);
                    $('#modal_loop').modal('show');
                }
            });
        });
    });

    // ruangan tersedia
    $(document).ready(function() {
        $('body').on('click', '.ruangan_tersedia', function() {
            $.ajax({
                url: "/ruangan_tersedia",
                type: "GET",
                dataType: "JSON",
                success: function(data1) {
                    var trHTML = '';
                    $.each(data1, function(i, item) {
                        var nomor = i + 1;
                        trHTML += '<tr><td>' + nomor + '</td><td>' + item.nama + '</td><td>' + item.id_fasilitas_baru + '</td><td>' + item.kapasitas + '</td></tr>';
                    });

                    $('#records_table tbody').html(trHTML);
                    $('#modal_loop').modal('show');
                }
            });
        });
    });

    // ruangan di booking
    $(document).ready(function() {
        $('body').on('click', '.ruangan_dibooking', function() {
            $.ajax({
                url: "/ruangan_dibooking",
                type: "GET",
                dataType: "JSON",
                success: function(data1) {
                    var trHTML = '';
                    var addedRooms = []; // Variabel penanda ruangan yang sudah ditambahkan

                    $.each(data1, function(i, item) {
                        var ruangRapat = item.ruangrapat;
                        var ruanganId = ruangRapat.id;

                        if (!addedRooms.includes(ruanganId)) { // Periksa apakah ruangan sudah ditambahkan
                            var nomor = i + 1;
                            trHTML += '<tr><td>' + nomor + '</td><td>' + ruangRapat.nama + '</td><td>' + ruangRapat.id_fasilitas_baru + '</td><td>' + ruangRapat.kapasitas + '</td></tr>';

                            addedRooms.push(ruanganId); // Tambahkan ruangan ke variabel penanda
                        }
                    });

                    $('#records_table tbody').html(trHTML);
                    $('#modal_loop').modal('show');
                }
            });
        });
    });





    //     $.ajax({
    //     url: '/echo/json/',
    //     type: 'POST',
    //     data: {
    //         json: jsonData
    //     },
    //     success: function (response) {
    //         var trHTML = '';
    //         $.each(response, function (i, item) {
    //             trHTML += '<tr><td>' + item.rank + '</td><td>' + item.content + '</td><td>' + item.UID + '</td></tr>';
    //         });
    //         $('#records_table').append(trHTML);
    //     }
    // });



    new Chart(document.getElementById("lineChart"), {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'desember'],
            datasets: [{
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++)
                            // melakukakan looping 
                            {
                                ${"keuangan" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '1')->count();
                                echo ${"keuangan" . $x} . ",";
                            }

                            //membuat variable keungan x (julah bulan) dengan cara menempatkan variable $ di depan {}
                            //variable di isi dengan query select where  
                            //setelah itu di echo untuk menampilkan isi dari variabklenya
                            ?>],
                    label: "Keuangan",
                    borderColor: "#3cba9f",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"pemasaran" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '2')->count();
                                echo ${"pemasaran" . $x} . ",";
                            }
                            ?>],
                    label: "Pemasaran",
                    borderColor: "#e43202",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"dekom" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '3')->count();
                                echo ${"dekom" . $x} . ",";
                            }
                            ?>],
                    label: "Dekom",
                    borderColor: "#a65b47",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"direksi" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '4')->count();
                                echo ${"direksi" . $x} . ",";
                            }
                            ?>],
                    label: "Direksi",
                    borderColor: "#a68d47",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"dirtek" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '5')->count();
                                echo ${"dirtek" . $x} . ",";
                            }
                            ?>],
                    label: " DirTek",
                    borderColor: "#49a647",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"logistik" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '6')->count();
                                echo ${"logistik" . $x} . ",";
                            }
                            ?>],
                    label: "Logistik",
                    borderColor: "#47a69b",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"pp" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '7')->count();
                                echo ${"pp" . $x} . ",";
                            }
                            ?>],
                    label: "P. Perusahaan ",
                    borderColor: "#4773a6",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"pt" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '8')->count();
                                echo ${"pt" . $x} . ",";
                            }
                            ?>],
                    label: "P. Teknik",
                    borderColor: "#a64767",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"pertek" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '9')->count();
                                echo ${"pertek" . $x} . ",";
                            }
                            ?>],
                    label: "pertek ",
                    borderColor: "#a147a6",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"produksi" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '10')->count();
                                echo ${"produksi" . $x} . ",";
                            }
                            ?>],
                    label: "produksi ",
                    borderColor: "#380a78",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"spi" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '11')->count();
                                echo ${"spi" . $x} . ",";
                            }
                            ?>],
                    label: "SPI",
                    borderColor: "#141211",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"sekper" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '12')->count();
                                echo ${"sekper" . $x} . ",";
                            }
                            ?>],
                    label: "Sekper",
                    borderColor: "#ff9500",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"staf" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '13')->count();
                                echo ${"staf" . $x} . ",";
                            }
                            ?>],
                    label: "Staf",
                    borderColor: "#b3d138",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"SDM" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '14')->count();
                                echo ${"SDM" . $x} . ",";
                            }
                            ?>],
                    label: "SDM",
                    borderColor: "#00ff51",
                    fill: false
                },
                {
                    data: [<?php
                            for ($x = 1; $x <= 12; $x++) {
                                ${"it" . $x} = Permohonan_Rapat::where('status', 4)->whereMonth('waktu_keluar', '0' . $x)->where('divisi', '15')->count();
                                echo ${"it" . $x} . ",";
                            }
                            ?>],
                    label: "IT",
                    borderColor: "#00f7ff",
                    fill: false
                },
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Chart JS Multiple Lines Example'
            }
        }
    });
</script>



<!-- <div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading">
                <h4 class="panel-title">Total Subscription</h4>
            </div>
            <div class="panel-body">
                <h3 class="" href><b>2568</b></h3>
                <p class="text-muted"><b>48%</b> From Last 24 Hours</p>
            </div>
        </div>
    </div> -->
@endsection