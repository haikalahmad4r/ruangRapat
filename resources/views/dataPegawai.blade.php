@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">

    </div>
    @if(Session::has('sukses'))
    <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ Session::get('sukses') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#boostrapModal-2">Tambah Pegawai</button>
                        </h4>
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
                                                        <th width="5%">NO</th>
                                                        <th width>Nama</th>
                                                        <th width=>Jabatan</th>
                                                        <th width=>Divisi</th>
                                                        <th width="10%">Opsi</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($pegawai as $p)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $p->nama }}</td>
                                                        <td>{{ $p->jabatan }}</td>
                                                        <td>{{ $p->divisiPegawai->nama }}</td>

                                                        <td>
                                                            <a class="btn btn-sm btn-warning editPegawai" data-id="{{$p->id}}">Edit</a>
                                                            <a class="btn btn-sm btn-danger hapusPegawai" data-id="{{$p->id}}"> Hapus</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <!--simpan id dari setiap id di database -->
                                                </tbody>
                                            </table>
                                            <!-- Hapus Kendaraan -->
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
<!-- <th width="10%">Lampiran</th> -->
<!-- <td>
        <a class="btn btn-sm btn-default lampiranPegawai" data-id="{{$p->id}}" target="_blank"> Lampiran</a>


</td> -->



<!-- modal lampiran -->
<div class="modal fade" id="modal_lampiranPegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lampiran"></h4>
            </div>
            <div class="modal-body">
                <div id="testing" class="form-group"></div>
                <!-- id testing dari yang ada di javascript -->
            </div>
        </div>
    </div>
</div>


<!-- tambah pegawai -->

<div class="modal fade" id="boostrapModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Tambah Pegawai</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ route('tambahPegawai')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">

                    @csrf
                    <div class="form-group">

                        <label>Nama Pegawai</label>
                        <input type="text" name="nama" class="form-control" required>
                        <label for="">Divisi</label>
                        <select name="divisi_id" id="" class="divisi form-control" required>
                            <option value="">Pilih Divisi</option>
                            @foreach($divisi as $d)
                            <option value="{{$d->id}}">{{$d->nama}}</option>

                            @endforeach
                        </select>
                        <!-- <label>Divisi</label>
                        <input type="text" name="divisi" class="form-control" required> -->
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="jabatan" class="jabatan form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="manager">Manager</option>
                                <option value="Assisten Manager">Assisten Manager</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>


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

<!-- edit pegawai -->

<div class="modal fade" id="modal_editPegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Edit Pegawai</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('updateDataPegawai')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input id="nama" type="text" name="nama" class="form-control" required>
                        <label>Divisi</label>
                        <select name="divisi_id" id="divisi_id" class="kondisi form-control">
                            <!-- id tidak boleh bentrok -->
                            <option value="">Pilih Ruangan</option>
                            @foreach($divisi as $d)
                            <option value="{{$d->id}}">{{$d->nama}}</option>
                            @endforeach
                        </select>


                    </div>

                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan" class=" form-control" id="jabatan" required>
                            <option value="">Pilih Jenis</option>
                            <option value="manager">Manager</option>
                            <option value="Assisten Manager">Assisten Manager</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="staf">staf</option>
                        </select>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="idPegawaiedit" id="idPegawaiedit" value="" required>
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

        //Edit Pegawai

        $('body').on('click', '.editPegawai', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('editDataPegawai')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                //dari js ambil id 
                {
                    $('#idPegawaiedit').val(data.id);
                    $('#no_induk').val(data.no_induk);
                    $('#nama').val(data.nama);
                    $('#divisi').val(data.divisi);
                    $('#divisi_id option[value="' + data.divisi_id + '"]').prop(
                        'selected', true);
                    $('#jabatan option[value="' + data.jabatan + '"]').prop(
                        'selected', true
                    );
                    var filename = data.lampiran;
                    var object = "<object data=\"lampiran/{FileName}\"  width=\"100px\" height=\"100px\">";
                    object += "</object>";
                    object = object.replace(/{FileName}/g, "/" + filename);
                    $('#testing2').html(object);
                    //nama id tidak boleh samaa


                    $('#modal_editPegawai').modal('show');



                }
            })
        })




        //Hapus  Pegawai
        $('body').on('click', '.hapusPegawai', function() {
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
                location.href = '<?php echo "hapusDataPegawai" ?>' + id

                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });

        //lampiran Pegawai
        $('body').on('click', '.lampiranPegawai', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route ('lampiranPegawai')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    //  Syntax success:function(data) di atas digunakan sebagai callback function atau fungsi yang akan dieksekusi setelah request Ajax berhasil dilakukan dan mereturn data dalam format JSON dari server. 
                    //Parameter data dalam fungsi success ini akan memuat data yang diterima dari server, yang dalam kasus ini berisi objek yang berisi data pegawai yang dipilih beserta data lampiran-nya.

                    $('#idPegawai').val(data.id);
                    var filename = data.lampiran;
                    var object = "<object data=\"lampiran/{FileName}\" type=\"application/pdf\" width=\"800px\" height=\"700px\">";
                    //"<object data=\"lampiran/{FileName}\": Mendefinisikan object dengan atribut data yang mengarahkan ke file yang akan ditampilkan. lampiran pada syntax ini adalah direktori yang berisi file-file lampiran, sedangkan {FileName} adalah variabel yang akan diganti dengan nama file yang diperoleh dari response data.
                    // type=\"application/pdf\": Atribut type mendefinisikan tipe konten file yang akan ditampilkan, pada kasus ini adalah file pdf.


                    object += "</object>";
                    //Kode tersebut menambahkan tag penutup </object> ke dalam variabel object yang sebelumnya telah diberi nilai tag pembuka <object>.
                    object = object.replace(/{FileName}/g, "/" + filename);
                    $('#testing').html(object);
                    //nama id dari si object nantinya di tarik di id form
                    $('#lampiran').html(data.lampiran);



                    // console.log(data.lampiran);

                    $('#modal_lampiranPegawai').modal('show');


                }
            })
        })
    })
</script>

@endsection


<!-- kode diatas adalah sebuah perulangan foreach yang akan menampilkan data dari objek $ruangRapat yang diterima dari controller.  -->
<!--data-id berfungsi utnuk simpan id dari setiap id di database -->