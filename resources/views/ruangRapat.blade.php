@extends('layouts.app')

@section('content')
<div>
    <div class="col-md-12">

    </div>

    <div>
        @if(Session::has('sukses'))
        <div class="alert alert-success">
            {{ Session::get('sukses') }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#boostrapModal-2">Tambah Ruangan</button>
                            </h4>
                        </div>
                    </div>




                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered">


                                    <thead>
                                        <tr>
                                            <th width="4%">NO</th>
                                            <th>Nama</th>
                                            <th>Kapasistas</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Fasilitas</th>
                                            <th>Lokasi</th>
                                            <th width="10%">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($ruangRapat as $r)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $r->nama }}</td>
                                            <td>{{ $r->kapasitas }}</td>
                                            <td>{{ $r->pegawai->nama }} </td>
                                            <td>{{ $r->id_fasilitas_baru}}</td>
                                            <td>{{ $r->lokasi }}</td>
                                            <td>
                                                <center>
                                                    <a class="btn btn-sm btn-warning editRuangan" data-id="{{$r->id}}">Edit</a>
                                                    <a class="btn btn-sm btn-danger hapusRuangan " data-id="{{$r->id}}">Hapus</a>
                                                </center>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- ROW -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Ruang Rapat -->
<div class="modal fade" id="modal_editruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Edit Ruangan</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('updateRuangan')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input id="nama" name="nama" type="text" class="form-control" required>

                    </div>
                    <div class="form-group">
                        <label for="">Kapasitas</label>
                        <input id="kapasitas" name="kapasitas" type="number" class="form-control" required>
                    </div>
                    <label>Penanggung Jawab</label>
                    <select name="id_pegawai" id="id_pegawai" class="kondisi form-control" required>
                        <option value="">Pilih pegawai</option>
                        @foreach($pegawai as $p)
                        <option value="{{$p->id}}">{{$p->nama}}</option>
                        @endforeach

                    </select>
                    <div>
                        <label for="">Fasilitas</label>
                        <br>
                        <select class="js-edit-basic-multiple" name="fasilitas_edit_baru[]" id="edit-fasilitas_baru" multiple="multiple" style="width:100%">
                            <option value="">Edit fasilitas</option>
                            @foreach($fasilitas_baru as $f)
                            <option value="{{$f->nama}}">{{$f->nama}}</option>
                            @endforeach
                        </select>
                        <br>

                    </div>
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <input id="lokasi" name="lokasi" type="text" class="form-control" required>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="idruangRapat" id="idruangRapat" value="" required>
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah ruangan -->
<div class="modal fade" id="boostrapModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Ruang Rapat</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route ('simpanRuangan')}}" onkeydown="return event.key != 'Enter';">

                    @csrf
                    <!-- JS = ambil  id
controller ambil nama -->
                    <div class="form-group">
                        <label>Nama Ruangan</label>
                        <input type="text" name="nama" class="form-control" required>
                        <!-- ganti name menjadi sesuai degnan yang ada di database -->
                        <label>Kapasitas ruangan</label>
                        <input type="number" name="kapasitas" class="form-control" required>
                        <div class="form-group">
                            <label>Penanggung Jawab</label>
                            <select name="id_pegawai" class="form-control" required>
                                <option value="">Pilih pegawai</option>
                                @foreach($pegawai as $p)
                                <option value="{{$p->id}}">{{$p->nama}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Fasilitas</label>
                            <br>
                            <select class="select_fasilitas" name="fasilitas_baru[]" multiple="multiple" style="width: 100%;">
                                <option value="">Pilih Fasilitas</option>
                                @foreach($fasilitas_baru as $fb)
                                <option value="{{$fb->nama}}">{{$fb->nama}}</option>
                                @endforeach
                            </select>

                        </div>
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.select_fasilitas').select2();
        $('#edit-fasilitas_baru').select2();

        $('body').on('click', '.editRuangan', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editRuangan')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idruangRapat').val(data.id);
                    $('#nama').val(data.nama);
                    $('#kapasitas').val(data.kapasitas);
                    $('#id_pegawai').val(data.id_pegawai);
                    $('#lokasi').val(data.lokasi);
                    if (data.id_fasilitas_baru == null) {
                        $('#edit-fasilitas_baru').val(data.id_fasilitas_baru);
                    } else {
                        $('#edit-fasilitas_baru').val(data.id_fasilitas_baru.split(',')).trigger("change");
                        //.trigger("change") untuk memicu event change pada elemen select yang telah diubah nilainya oleh Select2. I
                    }
                    $('#modal_editruangan').modal('show');
                }
            });
        })

        $('body').on('click', '.hapusRuangan', function() {
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
                location.href = '<?php echo "hapusRuangan" ?>' + id

                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });
    })
</script>



@endsection