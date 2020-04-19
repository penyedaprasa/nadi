@extends('layouts.app')

@section('namapage')
List Lahan
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a href="{{ route('lahan.create') }}"><button type="" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-plus"></i> Add Users</button></a>
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table class="table table-bordered color-bordered-table primary-bordered-table">
                        <thead>
                            <tr>
                                <th>id Lahan</th>
                                <th>Lokasi</th>
                                <th>Nama Petani</th>
                                <th>Nama Tanah</th>
                                <th>Tanggal Tanam</th>
                                <th>Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                
                                <td>
                                
                                    <a href="#" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="#" 
                                        class="hapus" data-toggle="tooltip" data-original-title="Delete" 
                                        onclick="event.preventDefault(); document.getElementById('hapus').submit();"> 
                                        <i class="fa fa-close text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
 
@endsection