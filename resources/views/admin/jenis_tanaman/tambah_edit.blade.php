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
                            <form class="form-horizontal" method="POST" action="{{ route('jenis_tanaman.store') }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Nama Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_tanaman" class="form-control"  placeholder="Nama Tanaman" required> 
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Usia Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="usia_tanaman" class="form-control"  placeholder="Usia Tanaman" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Keterangan*</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="keterangan" placeholder="Keterangan" required></textarea>
                                    </div>
                                </div>

                                <!-- penambahan -->
                                
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Foto Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="foto_tanaman" class="form-control"  placeholder="Foto Tanaman" required>
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Cahaya*</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="min_cahaya" class="form-control" placeholder="min" required> <br>
                                        <input type="text" name="max_cahaya" class="form-control" placeholder="max" required> 
                                    </div>      
                                </div>

                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Suhu*</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="min_suhu" class="form-control" placeholder="min" required> <br>
                                        <input type="text" name="max_suhu" class="form-control" placeholder="max" required> 
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Kelembaban*</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="min_kelembaban" class="form-control" placeholder="min" required> <br>
                                        <input type="text" name="max_kelembaban" class="form-control" placeholder="max" required> 
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Nutrisi*</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="min_nutrisi" class="form-control" placeholder="min" required> <br>
                                        <input type="text" name="max_nutrisi" class="form-control" placeholder="max" required> 
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Air Tanah*</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="min_tanah" class="form-control" placeholder="min" required> <br>
                                        <input type="text" name="max_tanah" class="form-control" placeholder="max" required> 
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection