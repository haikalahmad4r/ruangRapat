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
                            <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#boostrapModal-2">Tambah Divisi</button>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable" class="table table-striped table-bordered">


                                    <thead>
                                        <tr>
                                            <th width="10%">NO</th>
                                            <th>Nama</th>
                                            <th width="10%">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($divisi as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->nama }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning editDivisi" data-id="{{$d->id}}">Edit</a>
                                                <a class="btn btn-sm btn-danger hapusDivisi " data-id="{{$d->id}}">Hapus</a>
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

<!-- Tambah Divisi -->
<div class="modal fade" id="boostrapModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Tambah Divisi</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route ('simpanDivisi')}}" onkeydown="return event.key != 'Enter';">

                    @csrf

                    <div class="form-group">

                        <label>Nama Divisi</label>
                        <input type="text" name="nama" class="form-control" required>
                        <!-- ganti name menjadi sesuai degnan yang ada di database -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Divisi -->

<div class="modal fade" id="modal_editDivisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Edit Fasilitas</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('updateDivisi')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input id="nama_divisi" name="nama_divisi" type="text" class="form-control" required>

                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="iddivisi" id="iddivisi" value="">
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


        // edit
        $('body').on('click', '.editDivisi', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editDivisi')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#iddivisi').val(data.id);
                    $('#nama_divisi').val(data.nama);
                    $('#modal_editDivisi').modal('show');
                }
            })
        })
        // hapus
        $('body').on('click', '.hapusDivisi', function() {
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
                location.href = '<?php echo "hapusDivisi" ?>' + id

                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });
    })
</script>


@endsection