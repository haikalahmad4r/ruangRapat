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
            <th>Nama Rapat</th>
            <th>Divisi</th>
            <th>Waktu Masuk</th>
            <th>Fasilitas Tambahan </th>
            <th>Jumlah Peserta </th>
            <th>Nama Ruangan</th>

        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        @endphp
        @foreach($permohonan_rapat2 as $pr)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $pr->nama_rapat }}</td>
            <td>{{ $pr->divisiPermohonan->nama }}</td>
            <td>
                <?php
                echo date('D d M Y H:i', strtotime($pr->waktu_masuk));
                ?>
            </td>
            <td>{{ $pr->id_fasilitas}}</td>
            <td>{{ $pr->jumlah_peserta}}</td>
            <td>{{ $pr->ruangrapat->nama}}</td>


        </tr>
        @endforeach
        <!--simpan id dari setiap id di database -->
    </tbody>
</table>
<br>
<br>