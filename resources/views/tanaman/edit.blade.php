@extends('layouts.app')

@section('namapage')
Edit Tanaman
@endsection

@section('content')


<!-- adad -->
<!-- .row -->
                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form Add User</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" method="POST" action="{{ route('tanaman.store') }}">
                                @csrf
                                
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Jenis Tanaman*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="nama_tanaman" required>
                                            <option value="">Pilih Level Pengguna</option>
                                            <option value="bawang">Bawang</option>
                                            <option value="lombok">Lombok</option>
                                        </select>
                                        
                                    </div>      
                                </div>
                                
                                <!-- tani -->
                                
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 control-label col-form-label">{{ __('Tgl Tanam') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="tgl_tanam" class="form-control"  placeholder="Alamat Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">{{ __('Usia') }}*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="usia_tanaman" class="form-control"  placeholder="Nomor Hp" required>
                                        
                                    </div>
                                </div>
                                
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