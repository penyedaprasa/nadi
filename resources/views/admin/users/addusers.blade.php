@extends('layouts.app')

@section('namapage')
Tambah Users
@endsection

@section('content')


<!-- adad -->
<!-- .row -->
                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            @if(!isset($update))
                            <h3 class="box-title m-b-0">Form Add User</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            

                            <form class="form-horizontal" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label col-form-label">{{ __('EMail') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail3" value="{{ old('email') }}" placeholder="Email" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="inputPassword4" class="col-sm-3 control-label col-form-label">{{ __('Password') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-sm-3 control-label col-form-label">{{ __('Re Password') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="Re Password" required>
                                        
                                    </div>
                                </div>

                                <!-- tani -->
                                <div class="form-group row">
                                    <label for="nama_petani" class="col-sm-3 control-label col-form-label">{{ __('Nama Petani') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_petani" class="form-control"  placeholder="Nama Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 control-label col-form-label">{{ __('Alamat Petani') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="alamat" class="form-control"  placeholder="Alamat Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">{{ __('Nomor Hp') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="no_hp" class="form-control"  placeholder="Nomor Hp" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_device" class="col-sm-3 control-label col-form-label">Image*</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="foto_petani" class="form-control" required>        
                                    </div>
                                </div>
                                <!-- end tani -->

                                @else

                            <h3 class="box-title m-b-0">Form Edit User</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            
                                <form class="form-horizontal" method="POST" action="{{ route('users.update', $data->id_user) }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{ method_field('put') }}                               

                                <!-- tani -->
                                <div class="form-group row">
                                    <label for="nama_petani" class="col-sm-3 control-label col-form-label">Nama Petani*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_petani" value="{{ $data->petani->nama_petani }}" class="form-control"  placeholder="Nama Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 control-label col-form-label">Alamat Petani*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="alamat" value="{{ $data->petani->alamat }}" class="form-control"  placeholder="Alamat Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Nomor Hp*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="no_hp" value="{{ $data->petani->no_hp }}" class="form-control"  placeholder="Nomor Hp" required>
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label col-form-label">EMail*</label>
                                    <div class="col-sm-9">
                                        <input type="email" value="{{ $data->email }}" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword4" class="col-sm-3 control-label col-form-label">{{ __('Password') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-sm-3 control-label col-form-label">{{ __('Re Password') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="Re Password" required>
                                        
                                    </div>
                                </div>
                            
                                @endif
                            
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection