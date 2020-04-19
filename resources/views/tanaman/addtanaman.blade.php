@extends('layouts.app')

@section('namapage')
Tambah Tanaman
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
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Nama Tanaman*</label>
                                    <div class="col-sm-9">
                                        <!-- <select class="form-control" name="nama_tanaman" required>
                                            <option value="">Pilih Level Pengguna</option>
                                            <option value="bawang">Bawang</option>
                                            <option value="lombok">Lombok</option>
                                        </select> -->
                                        <input type="text" name="nama_tanaman" class="form-control"  placeholder="Nama Tanaman" required> 
                                    </div>      
                                </div>
                                
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 control-label col-form-label">Tanggal Tanam*</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="tgl_tanam" class="form-control"  placeholder="Alamat Petani" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Usia Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="usia_tanaman" class="form-control"  placeholder="Nomor Hp" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Keterangan*</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="keterangan" placeholder="Keterangan" required></textarea>
                                    </div>
                                </div>
                                
                                
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