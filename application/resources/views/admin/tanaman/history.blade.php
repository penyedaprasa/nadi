@extends('layouts.app')

@section('namapage')
History Tanaman
@endsection

@section('content')

    @if(Session::has('alert'))
     
        <script type='text/javascript'>
            $(document).ready(function() {
                $.toast({
                    heading: 'Proses Berhasil',
                    text: '{{ Session::get('alert')}}.',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'info',
                    hideAfter: 11000,

                    stack: 6
                })
            });
        </script>

        <!-- <div class="alert alert-success">
          {{ Session::get('alert')}}
        </div> -->
        @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id Channel</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <!-- <th>Hari Ke</th> -->
                                <th>Suhu</th>
                                <th>Cahaya</th>
                                <th>Nutrisi</th>
                                <th>Air Tanah</th>
                                <th>Kelembaban</th>
                                <th>Tangki Air</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $tanaman)

                            
                            @php 

                            if($tanaman->value_temperature > $max_temperature ){
                              $a = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($tanaman->value_temperature <= $max_temperature && $tanaman->value_temperature >= $min_temperature){
                              $a = '<span class="label label-success">Aman</span>';
                            }elseif($tanaman->value_temperature < $min_temperature){
                              $a = '<span class="label label-warning">Kurang</span>';
                            }

                            
                            if($tanaman->value_light > $max_light ){
                              $l = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($tanaman->value_light <= $max_light && $tanaman->value_light >= $min_light ){
                              $l = '<span class="label label-success">Aman</span>';
                            }elseif($tanaman->value_light < $min_light){
                              $l = '<span class="label label-warning">Kurang</span>';
                            }

                            if($tanaman->value_humadity > $max_humadity){
                              $h = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($tanaman->value_humadity <= $max_humadity && $tanaman->value_humadity >= $min_humadity){
                              $h = '<span class="label label-success">Aman</span>';
                            }elseif($tanaman->value_humadity < $min_humadity){
                              $h = '<span class="label label-warning">Kurang</span>';
                            }
                            
                            if($tanaman->value_moisture > $max_moisture ){
                              $m = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($tanaman->value_moisture <= $max_moisture && $tanaman->value_moisture >= $min_moisture){
                              $m = '<span class="label label-success">Aman</span>';
                            }elseif($tanaman->value_moisture < $min_moisture){
                              $m = '<span class="label label-warning">Kurang</span>';
                            }


                            if($tanaman->value_ph > $max_ph){
                              $p = '<span class="label label-danger">Lebih</span>';                        
                            }elseif($tanaman->value_ph <= $max_ph && $tanaman->value_ph >= $min_ph){
                              $p = '<span class="label label-success">Aman</span>';
                            }elseif($tanaman->value_ph < $min_ph){
                              $p = '<span class="label label-warning">Kurang</span>';
                            }

                            if($tanaman->value_level_water == 3){
                              $aww = '<span class="label label-danger">Penuh</span>';                        
                            }elseif($tanaman->value_level_water == 2){
                              $aww = '<span class="label label-success">Sedang</span>';
                            }elseif($tanaman->value_level_water == 1){
                              $aww = '<span class="label label-warning">Kurang</span>';
                            }
                            

                            @endphp
                            
                                                    

                            <tr>
                                <td>{{ $tanaman->id_status_notif }}</td>
                                <td>{{ $tanaman->id_channel }}</td>
                                <td>{{ $tanaman->created_at }}</td>
                                <td>hari ke-{{ $tanaman->hari_ke }} {{ $tanaman->waktu }}</td>
                                <!-- <td></td> -->
                                <td>{{ $tanaman->value_temperature }} &#8451; {!!$a!!}</td>
                                <td>{{ $tanaman->value_light }} % {!!$l!!}</td>
                                <td>{{ $tanaman->value_ph }} pH {!!$p!!}</td>
                                <td>{{ $tanaman->value_moisture }} % {!!$m!!}</td>
                                <td>{{ $tanaman->value_humadity }} % {!!$h!!}</td>
                                <td>{!!$aww!!} </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

    
 
@endsection