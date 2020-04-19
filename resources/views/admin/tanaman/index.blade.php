@extends('layouts.app')

@section('namapage')
List Tanaman
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
                
                <a href="{{ route('tanaman.create') }}"><button type="" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-plus"></i> Add Tanaman</button></a>
             
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30">id tanaman</th>
                                <th>channel id</th>
                                <th>nama petani</th>
                                <th>tanaman</th>
                                <th>Lokasi</th>
                                <!-- <th>id device</th>
                                <th>tgl tanam</th>
                                <th>usia tanaman</th> -->
                                <!-- <th>Actions</th> -->
                                <th>Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $tanaman)



                            <tr>
                                <td>{{ $tanaman->id_tanaman }}</td>
                                <td>{{ $tanaman->device->id_channel }}</td>
                                <td>{{ $tanaman->petani->nama_petani }}</td>
                                <td>{{ $tanaman->jenisTanaman->nama_tanaman }}</td>
                                <td>{{ $tanaman->lokasi }}</td>
                                <td>
                                <form id="hapus" action="{{ route('tanaman.destroy', $tanaman->id_tanaman) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>

                                    <a href="{{ route('history', $tanaman->id_channel) }}" data-toggle="tooltip" data-original-title="History"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                                    <a href="{{ route('tanaman.show', $tanaman->id_tanaman) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                                    <!-- <a href="{{ route('tanaman.show', $tanaman->id_channel) }}" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a> -->
                                    <a href="{{ route('tanaman.destroy', $tanaman->id_tanaman) }}" 
                                        class="hapus" data-toggle="tooltip" data-original-title="Delete" 
                                        onclick="event.preventDefault(); document.getElementById('hapus').submit();"> 
                                        <i class="fa fa-close text-danger"></i>
                                    </a>
                                </td>
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