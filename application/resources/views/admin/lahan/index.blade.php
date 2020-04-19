@extends('layouts.app')

@section('namapage')
List Lahan
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
                <a href="{{ route('lahan.create') }}"><button type="" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-plus"></i> Add Users</button></a>
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>id Lahan</th>
                                <th>Lokasi</th>
                                <th>Nama Petani</th>
                                <th>Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td>{{ $d->id_lahan }}</td>
                                <td>{{ $d->lokasi }}</td>
                                <td>{{ $d->petani->nama_petani }}</td>
                                
                                <td>
                                <form id="hapus" action="{{ route('device.destroy', $d->id_device) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>
                                    <a href="{{ route('lahan.show', $d->id_lahan) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                                    <a href="{{ route('device.destroy', $d->id_device) }}" 
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