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
                            <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#boostrapModal-2">Tambah Fasilitas</button>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered">


                                    <thead>
                                        <tr>
                                            <th width="8%">NO</th>
                                            <th>Nama</th>
                                            <th width="10%">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($fasilitas_baru as $fb)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $fb->nama }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning editFasilitas" data-id="{{$fb->id}}">Edit</a>
                                                <a class="btn btn-sm btn-danger hapusFasilitas " data-id="{{$fb->id}}">Hapus</a>
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

<!-- Tambah Fasilitas -->
<div class="modal fade" id="boostrapModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Tambah Fasilitas</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route ('simpanFasilitas_baru')}}" onkeydown="return event.key != 'Enter';">

                    @csrf

                    <div class="form-group">

                        <label>Nama Fasilitas</label>
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

<script>
</script>
@endsection