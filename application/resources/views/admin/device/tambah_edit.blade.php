@extends('layouts.app')

@section('namapage')
	@if(!isset($update))
		Tambah Device
	@else
		Edit Device
	@endif
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="white-box">
			@if(!isset($update))
		    <h3 class="box-title m-b-0">Form Tambah Device</h3>
		    <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>

			<form class="form-horizontal" method="POST" action="{{ route('device.store') }}" enctype="multipart/form-data" >
				{{csrf_field()}}

				{{--
			    <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Nomor Seri*</label>
	                <div class="col-sm-9">
	                    <input type="input" name="no_seri" class="form-control"  placeholder="Nomor Seri" required>                    
	                </div>
	            </div>
	            --}}

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Id Channel*</label>
	                <div class="col-sm-9">
	                    <input type="number" name="id_channel" class="form-control"  placeholder="Id Channel" required>                    
	                </div>
	            </div>

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Api Key*</label>
	                <div class="col-sm-9">
	                    <input type="text" name="api_key" class="form-control"  placeholder="Api Key" required>                    
	                </div>
	            </div>

	            <div class="form-group row">
                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Pilih Petani*</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="petani_id" required>
                            <option value="">Pilih Petani</option>
                            @foreach($petani as $data)
                            <option value="{{ $data->id_petani }}">{{ $data->nama_petani }}</option>
                            @endforeach
                        </select>
                    </div>      
                </div>

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Tahun Pembelian*</label>
	                <div class="col-sm-9">
	                    <input type="number" name="tahun" class="form-control"  placeholder="Tahun Pembelian" required>                    
	                </div>
	            </div>

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Keterangan*</label>
	                <div class="col-sm-9">
	                    <textarea class="form-control" name="keterangan" placeholder="Keterangan" required></textarea>                    
	                </div>
	            </div>  
            @else
            <!-- update -->
            <h3 class="box-title m-b-0">Form Edit Device</h3>
		    <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>

			<form class="form-horizontal" method="POST" action="{{ route('device.update', $data->id_device) }}" enctype="multipart/form-data">
			    {{csrf_field()}}
				{{ method_field('put') }}

				{{--
			    <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Nomor Seri*</label>
	                <div class="col-sm-9">
	                    <input type="input" name="no_seri" class="form-control" value="{{ $data->nomor_seri }}"  placeholder="Nomor Seri" required>                    
	                </div>
	            </div>
	            --}}

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Id Channel*</label>
	                <div class="col-sm-9">
	                    <input type="number" name="id_channel" value="{{ $data->id_channel }}" class="form-control"  placeholder="Id Channel" required>                    
	                </div>
	            </div>


	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Api Key*</label>
	                <div class="col-sm-9">
	                    <input type="text" name="api_key" value="{{ $data->api_key }}" class="form-control"  placeholder="Api Key" required>                    
	                </div>
	            </div>

	            <div class="form-group row">
                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Pilih Petani*</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="petani_id" required>
                            <option value="{{ $data->id_petani }}">{{ $data->petani->nama_petani }}</option>
                            
                            @foreach($petani as $tani)
                            <option value="{{ $tani->id_petani }}">{{ $tani->nama_petani }}</option>
                            @endforeach
                            
                        </select>
                    </div>      
                </div>

	            <div class="form-group row">
	                <label for="no_hp" class="col-sm-3 control-label col-form-label">Tahun Pembelian*</label>
	                <div class="col-sm-9">
	                    <input type="number" name="tahun" class="form-control" min="0" value="{{ $data->tahun }}" placeholder="Tahun Pembelian" required>                    
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
                	<a href="{{ route('device.index') }}"  class="btn btn-default waves-effect waves-light m-t-10">Batal</a>
                    <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                </div>
            </div>

        </form>

	    </div>
    </div>
</div>


		    

            




@endsection