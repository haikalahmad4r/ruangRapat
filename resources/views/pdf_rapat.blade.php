<style>
    /* Style untuk judul halaman */
    h1 {
        text-align: center;
        margin-top: 20px;
    }

    /* Style untuk alert */
    .alert {
        margin-bottom: 20px;
    }

    /* Style untuk tabel */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background-color: #ddd;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Style untuk tombol edit dan hapus */
</style>
<div>
    <p>
</div>
<center>
    <h2>
        REKAP
    </h2>
</center>
<table>
    <tbody>
        <tr>
            <td>
                Nama Rapat </b> </p>

            </td>
            <td>
                <b>{{$permohonan_rapat->nama_rapat}}
            </td>
        </tr>
        <tr>
            <td>
                Ruang Rapat
            </td>
            <td>
                {{$permohonan_rapat->ruangrapat->nama}}
            </td>
        </tr>
        <tr>
            <td>
                Waktu Rapat </td>
            <td>
                {{ date(' d-M-Y  H:i'   , strtotime($permohonan_rapat->waktu_masuk)) }} - {{ date(' d-M-Y  H:i', strtotime($permohonan_rapat->waktu_keluar)) }}
            </td>

        </tr>
        <tr>
            <td>
                Peserta </td>
            <td>
                {{$permohonan_rapat->jumlah_peserta}}
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>

<table id="datatable" class="table table-striped table-bordered">
    @if(Session::has('sukses'))
    <div class="alert alert-danger alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ Session::get('sukses') }}
    </div>
    @endif
    <thead>
        <tr>
            <th width="10%">NO</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Jabatan</th>
            <th>Waktu Absen</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        @endphp
        @foreach($rekapAbsen as $ra)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $ra->nama }}</td>
            <td>{{ $ra->jabatan }}</td>
            <td>{{ $ra->divisi }}</td>
            <td>{{ $ra->created_at->format('H:i   d-D-M-Y')}}</td>
        </tr>
        @endforeach
        <!--simpan id dari setiap id di database -->
    </tbody>
</table>