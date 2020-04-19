@extends('layouts.app')

@section('namapage')
Detail Tanaman
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box"><p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table class="table table-bordered color-bordered-table primary-bordered-table">
                        <thead>
                            <tr>
                                <th>id Channel</th>
                                <th>Nama Petani</th>
                                <th>Tanaman</th>
                                <th>Tanggal Tanam</th>
                                <th>Usia Tanaman Sekarang</th>
                                <th>Usia Tanaman</th>
                                <th>Lokasi</th>
                                <th>Images</th>
                                <th>Detail</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><center>{{ $data->device->id_channel }}</center></td>
                                <td><center>{{ $data->petani->nama_petani }}</center></td>
                                <td><center>{{ $data->jenisTanaman->nama_tanaman }}</center></td>
                                <td><center>{{ $data->tgl_tanam }}</center></td>
                                <td><center>{{ $now_usia }} hari</center></td>
                                <td><center>{{ $data->jenisTanaman->usia_tanaman }} hari</center></td>
                                <td><center>{{ $data->lokasi }}</center></td>
                                <td><center><img src="{{ asset('images/'.$data->foto_tanaman)  }}" width="50px" height="50px"></center></td>
                                <td>    
                                    <a href="#myModal" alt="default" data-toggle="modal" data-target="#myModal" class="model_img img-responsive">Detail</a>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>

        <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Detail</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <h4>Status Lingkungan</h4>


                            @php 

                            $now_hours = $data->statusNotifWeb->created_at;
                            if ($now_hours <= date("06:10:00") ) {
                                $now_hours = 'Istirahat';
                            }
                            else if ($now_hours <= date("Y-m-d 10:00:00") ) {
                                $now_hours = 'Pagi';
                            }
                            else if ($now_hours <= date("Y-m-d 14:40:00")) {
                                $now_hours = 'Siang';
                            }
                            else if ($now_hours <= date("Y-m-d 18:00:00")) {
                                $now_hours = 'Sore';
                            }
                            else{
                                $now_hours = 'Malam';
                            }

                            

                            if($data->statusNotifWeb->suhu > $max_temperature){
                              $a = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($data->statusNotifWeb->suhu <= $max_temperature && $data->statusNotifWeb->suhu >= $min_temperature){
                              $a = '<span class="label label-success">Aman</span>';
                            }elseif($data->statusNotifWeb->suhu < $min_temperature){
                              $a = '<span class="label label-warning">Kurang</span>';
                            }
                            
                            
                            if($data->statusNotifWeb->cahaya > $max_light){
                              $l = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($data->statusNotifWeb->cahaya <= $max_light && $data->statusNotifWeb->cahaya >= $min_light){
                              $l = '<span class="label label-success">Aman</span>';
                            }elseif($data->statusNotifWeb->cahaya < $min_light){
                              $l = '<span class="label label-warning">Kurang</span>';
                            }  

                            
                            if($data->statusNotifWeb->kelembaban > $max_humadity){
                              $h = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($data->statusNotifWeb->kelembaban <= $max_humadity && $data->statusNotifWeb->kelembaban >= $min_humadity){
                              $h = '<span class="label label-success">Aman</span>';
                            }elseif($data->statusNotifWeb->kelembaban < $min_humadity){
                              $h = '<span class="label label-warning">Kurang</span>';
                            }                            
                            
                            
                            if($data->statusNotifWeb->air_tanah > $max_moisture){
                              $m = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($data->statusNotifWeb->air_tanah <= $max_moisture && $data->statusNotifWeb->air_tanah >= $min_moisture){
                              $m = '<span class="label label-success">Aman</span>';
                            }elseif($data->statusNotifWeb->air_tanah < $min_moisture){
                              $m = '<span class="label label-warning">Kurang</span>';
                            }

                            
                            if($data->statusNotifWeb->nutrisi > $max_ph){
                              $p = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($data->statusNotifWeb->nutrisi <= $max_ph && $data->statusNotifWeb->nutrisi >= $min_ph){
                              $p = '<span class="label label-success">Aman</span>';
                            }elseif($data->statusNotifWeb->nutrisi < $min_ph){
                              $p = '<span class="label label-warning">Kurang</span>';
                            }

                            if($data->value_level_water = 1){
                              $aww = '<span class="label label-danger">Penuh</span>';                        
                            }elseif($data->value_level_water = 2){
                              $aww = '<span class="label label-success">Sedang</span>';
                            }elseif($data->value_level_water = 3){
                              $aww = '<span class="label label-warning">Kurang</span>';
                            }
                            

                            @endphp

                                <div> 
                                    <label for="recipient-name" class="control-label">Suhu : {{ $data->statusNotifWeb->suhu }} &#8451;  {!!$a!!}</label>
                                  
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Cahaya : {{ $data->statusNotifWeb->cahaya }} % {!!$l!!}</label>
                                   
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Kelembaban : {{ $data->statusNotifWeb->kelembaban }} % {!!$h!!}</label>
                                   
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Air Tanah : {{ $data->statusNotifWeb->air_tanah }} % {!!$m!!}</label>
                               
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Nutrisi : {{ $data->statusNotifWeb->nutrisi }} pH {!!$p!!}</label>
                                    
                                </div>

                                <div> 
                                    <label for="recipient-name" class="control-label">Tangki Air : {!!$aww!!}</label>
                                    
                                </div>
                                    
                            </div>
                            <!-- <div>
                                <h4>Keterangan</h4>
                                <p>keterangan</p> 
                            </div> -->

                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
 
@endsection