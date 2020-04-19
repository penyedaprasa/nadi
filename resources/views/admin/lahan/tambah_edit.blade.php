@extends('layouts.app')

@section('namapage')
Tambah Lahan
@endsection

@section('content')


<!-- adad -->
<!-- .row -->
                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form Add Lahan</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" method="POST" action="{{ route('lahan.store') }}">
                                @csrf
                                
                            {{--
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Pilih Tanaman*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="tanaman" required>
                                            <option value="">Pilih Tanaman</option>
                                            @foreach($tanaman as $d)
                                            <option value="{{ $d->id_jenis_tanaman }}">{{ $d->nama_tanaman }}</option>
                                            @endforeach
                                        </select>
                                    </div>      
                                </div>
                            --}}
                                <div class="form-group row">
                                    <label for="inputLevel" class="col-sm-3 control-label col-form-label">Pilih Device*</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="device" required>
                                            <option value="">Pilih Device</option>
                                            @foreach($device as $d)
                                            <option value="{{ $d->id_device }}">{{ $d->nomor_seri }}</option>
                                            @endforeach
                                        </select>
                                    </div>      
                                </div>
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-3 control-label col-form-label">Lokasi*</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="lokasi" placeholder="Lokasi Lahan" required></textarea>
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