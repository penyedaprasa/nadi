@extends('layouts.master')

@section('page')
    Dashboard
@endsection

@section('namapage')
Dashboard
@endsection

@section('content')
    
    
    <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <p class="text-muted m-b-30"></p>
                            <div class="table-responsive">
                              <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20">id</th>
                                            <th>Name</th>
                                            <th>Date (yyyy-mm-dd)</th>
                                            <th>Id Users</th>
                                            <th>Actions</th>
                                            
                                        </tr>
                                    </thead>
                     				<tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>
                                                <a href="#" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a>
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