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
                            <h3 class="box-title m-b-0">Form Add User</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" method="POST" action="{{ route('users.update', $users->id_user) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label col-form-label">{{ __('EMail') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="email" value="{{ $users->email }}" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail3" value="{{ old('email') }}" placeholder="Email" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Level*</label>
                                    <div class="col-sm-9">
                                        <select value="{{ $users->level }}" class="form-control" name="level" required>
                                            <option value="">Pilih Level Pengguna</option>
                                            <option value="1" >Admin</option>
                                            <option value="0" >Petani</option>
                                        </select>
                                        @if ($errors->has('Level'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('Level') }}</strong>
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
                 
                                <!-- end tani -->
                        
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">{{ __('Simpan') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
@endsection