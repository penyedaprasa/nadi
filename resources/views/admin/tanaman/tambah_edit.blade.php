@extends('layouts.app')

@section('namapage')
    @if(!isset($update))
        Tambah Jenis Tanaman
    @else
        Edit Jenis Tanaman
    @endif
@endsection

@section('content')


<!-- adad -->
<!-- .row -->
                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            @if(!isset($update))
                            <h3 class="box-title m-b-0">Form Tambah Jenis Tanaman</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" method="POST" action="{{ route('tanaman.store') }}" enctype="multipart/form-data">
                                {{csrf_field()}}


                                <!-- ambil dari master tanaman -->
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Nama Tanaman*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="id_jenis_tanaman" id="tanaman_id" required>
                                            <option value="">Pilih Tanaman</option>
                                            
                                            @foreach($tanaman as $d)
                                            <option value="{{ $d->id_jenis_tanaman }}">{{ $d->nama_tanaman }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>      
                                </div>
                                <!-- ambil dari data petani -->
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label" onchange="myFunction()">Nama Petani*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="id_petani" id="nama_petani" required>
                                            <option value="">Pilih Petani</option>
                                            @foreach($petani as $d)
                                            <option value="{{ $d->id_petani }}">{{ $d->nama_petani }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- ambil dari data device -->
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Device*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="id_device" id="nama_device" required>
                                            <option value="">Pilih Device</option>ss
                                         
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Tanggal Tanam*</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="tgl_pas_tanam" class="form-control" required>
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Lokasi*</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="lokasi" placeholder="Keterangan" required></textarea>
                                    </div>
                                </div>

                                <!-- penambahan -->
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Gambar Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="foto_tanaman" class="form-control"  placeholder="Foto Tanaman" required>
                                        
                                    </div>
                                </div>


                            @else
                                <!-- update -->
                                <h3 class="box-title m-b-0">Form Edit Jenis Tanaman</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" method="POST" action="{{ route('tanaman.update', $data->id_jenis_tanaman) }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{ method_field('put') }}
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Nama Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_tanaman" class="form-control" value="{{ $data->nama_tanaman }}" placeholder="Nama Tanaman" required> 
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Usia Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="usia_tanaman" class="form-control" value="{{ $data->usia_tanaman }}" placeholder="Usia Tanaman" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Keterangan*</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="keterangan" placeholder="Keterangan" required>{{ $data->keterangan }}</textarea>
                                    </div>
                                </div>
                            @endif
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <a href="{{ route('tanaman.index') }}"  class="btn btn-default waves-effect waves-light m-t-10">Batal</a>
                                        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                                        @php
                                        
                                        @endphp
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!--script type="text/javascript">
            $("select[name='id_petani']").change(function () {
            var menanam = $(this).val();
            if (menanam != '') {
                $.ajax({
                    type: 'GET',
                    data: 'id=' + menanam,
                    // url: '{$config->site_url("surat/spph/ajax_pegawai_attribute")}',
                    url: "{{ url('admin/tanaman/create') }}",
                    success: function (pegawai) {
                        // $("input[name='id_jenis_tanaman']").val(pegawai.pegawai_nama_lengkap).trigger("change");
                        $("input[name='id_petani']").val(pegawai.id_petani).trigger("change");
                        $("input[name='id_device']").val(pegawai.menanam).trigger("change");
                        // $("input[name='ttd_jabatan_struktural_id']").val(pegawai.jabatan_struktural_id).trigger("change");
                    }
                    });
                }
            });
            </script-->

            <script type="text/javascript">
             $('#nama_petani').change(function () {
                    $('#nama_device').empty();
                    $('#nama_device').append($("<option></option>").attr("value", "-").text("Pilih Device"));
                    $.ajax({
                        url: "{{ route('get.petani') }}",
                      type: 'POST',
                      data: {id_petani: $("#nama_petani").val()},
                      success : function (response) {
                         $.each(response.data, function(key, value){
                            // console.log(value.id_device)
                            $('#nama_device').append($("<option></option>").attr("value", value.id_device).text(value.id_channel));
                         });
                     }
                 });
                });
            </script>

@endsection