@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>
                    <h3 class="panel-title">Cari Jadwal </h3>
                </center>
            </div>
            <div class="panel-body">
                <center>
                    <form class="form-inline" method="get" action="{{route('agenda')}}" onkeydown="return event.key != 'Enter';">
                        <div class="form-group">
                            <label for="">Tgl Awal</label>
                            <input type="date" class="form-control" id="awal" name="awal">
                            <label class="" for="">Tgl Akhir</label>
                            <input type="date" class="form-control" id="akhir" name="akhir">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10">Cari</button>

                        </div>

                        <div>
                        </div>
                    </form>


                </center>
            </div>
        </div>
    </div>
    <div class="col-md-3">

    </div>

</div>
<div class="row">
    <div class="col-md-12">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center>
                            <h3 class="panel-title">
                                <?php

                                echo "Jadwal Rapat " . date(' d M Y ', strtotime($tglFilterAwal)) . " sampai dengan " . date(' d M Y ', strtotime($tglFilterAkhir));

                                ?>

                            </h3>

                        </center>


                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Ruang Rapat</th>
                                                        <th>Fasilitas</th>
                                                        <th>Kapasistas</th>
                                                        <th>Nama Rapat</th>
                                                        <th>Divisi</th>
                                                        <th>Jam</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($permohonan_rapat as $pr)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td> {{ $pr ->ruangRapat->nama}}</td>
                                                        <td>
                                                            {{ $pr ->ruangRapat->id_fasilitas_baru}}
                                                        </td>
                                                        <td>
                                                            {{ $pr ->ruangRapat->kapasitas}}
                                                        </td>

                                                        <td>{{ $pr->nama_rapat}}</td>
                                                        <td>{{ $pr->divisiPermohonan->nama}}</td>

                                                        <td><?php
                                                            echo date('D d M Y H:i', strtotime($pr->waktu_masuk));

                                                            ?></td>

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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center>
                            <h3 class="panel-title">
                                RUANG RAPAT YANG TERSEDIA
                            </h3>
                        </center>


                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Nama</th>
                                                        <th>Fasilitas</th>
                                                        <th>Kapasistas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($data1 as $pr)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td> {{ $pr ->nama}}</td>
                                                        <td>
                                                            {{ $pr ->id_fasilitas_baru}}
                                                        </td>
                                                        <td>
                                                            {{ $pr ->kapasitas}}
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection