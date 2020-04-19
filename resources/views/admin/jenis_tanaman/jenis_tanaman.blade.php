@extends('layouts.app')

@section('namapage')
Jenis Tanaman
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

@foreach($data as $a)
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="row row-in">

                <div class="col-lg-2 col-sm-6 row-in-br">
                    <div class="col-in row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <img src="{{ asset('images/jenis_tanaman/'.$a->gambar_tanaman)  }}" alt="user-img" width="150" height="150px" class="img-circle"><b class="hidden-xs">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-in row">
                        <!-- <div class="col-md-10 col-sm-10 col-xs-10"> -->
                            <a>NAMA TANAMAN : </a> <a>     {{ $a->nama_tanaman }}</a>                    
                    </div>
                   
                    <div class="col-in row">
                        <!-- <div class="col-md-10 col-sm-10 col-xs-10"> -->
                            <a>USIA TANAM : </a> <a>    {{ $a->usia_tanaman }} hari</a>
                    </div>
                    <div class="col-in row">
                        <!-- tombol modal -->
                        <a href="#myModal" alt="default" data-toggle="modal" data-target="#myModal" class="model_img img-responsive">Detail</a>
                    </div>

                </div>


            </div>
            
        </div>
    </div>
</div>
<!--row -->

<!-- modals -->

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
                                <h4>Ideal Tanaman</h4>
                                <div> 
                                    <label for="recipient-name" class="control-label">Suhu*</label>
                                    <br>
                                    <label for="recipient-name" class="right">Min : {{ $a->min_suhu }}</label>
                                    <br>
                                    <label for="recipient-name" class="right">Max : {{ $a->max_suhu }}</label>  
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Cahaya*</label>
                                    <br>
                                    <label for="recipient-name" class="right">Min : {{ $a->min_cahaya }}</label>
                                    <br>
                                    <label for="recipient-name" class="right">Max : {{ $a->max_cahaya }}</label>  
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Kelembaban*</label>
                                    <br>
                                    <label for="recipient-name" class="right">Min : {{ $a->min_kelembaban }}</label>
                                    <br>
                                    <label for="recipient-name" class="right">Max : {{ $a->max_kelembaban }}</label>
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Air Tanah*</label>
                                    <br>
                                    <label for="recipient-name" class="right">Min : {{ $a->min_tanah }}</label>
                                    <br>
                                    <label for="recipient-name" class="right">Max : {{ $a->max_tanah }}</label>  
                                </div>
                                <div> 
                                    <label for="recipient-name" class="control-label">Nutrisi*</label>
                                    <br>
                                    <label for="recipient-name" class="right">Min : {{ $a->min_nutrisi }}</label>
                                    <br>
                                    <label for="recipient-name" class="right">Max : {{ $a->max_nutrisi }}</label>
                                </div>
                                    
                            </div>
                            <div>
                                <h4>Keterangan</h4>
                                <p>{{ $a->keterangan }}</p> 
                            </div>

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

        <style type="text/css">
            .left    { text-align: left;}
            .right   { text-align: right;}
            .center  { text-align: center;}
            .justify { text-align: justify;}
        </style>
        


@endforeach

    
@endsection