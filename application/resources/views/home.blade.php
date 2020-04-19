@extends('layouts.master')

@section('page')
    Dashboard
@endsection

@section('namapage')
Dashboard
@endsection

@section('content')
    
     <!-- /.row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="row row-in">

                                <div class="col-lg-2 col-sm-6 row-in-br">
                                    <div class="col-in row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <img src="assets/plugins/images/users/pic.png" alt="user-img" width="150" class="img-circle"><b class="hidden-xs">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-in row">
                                        <!-- <div class="col-md-10 col-sm-10 col-xs-10"> -->
                                            <a>NAMA TANAMAN : </a>
                                    </div>
                                    <div class="col-in row">
                                        <!-- <div class="col-md-10 col-sm-10 col-xs-10"> -->
                                            <a>ALAMAT TANAMAN : </a>
                                    </div>
                                    <div class="col-in row">
                                        <!-- <div class="col-md-10 col-sm-10 col-xs-10"> -->
                                            <a>USIA TANAMAN : </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row -->
                <!-- /.row -->


                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form <?php echo "pageName"; ?></h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" action="trnsql/sql.haji.php" enctype="multipart/form-data" method="post">

                                <div class="form-group row">
                                      <label for="inputPassword4" class="col-sm-2 control-label col-form-label">Pilih Tanaman*</label>
                                      <div class="col-sm-9">
                                         <select class="form-control" name="broadcast_type" required id='subtype'>
                                                <option value="">-----Blank-----</option>
                                                <option value="eksternal">Bawang</option>
                                                <option value="internal">Lombok</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 control-label col-form-label">Alamat Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="broadcast_name" class="form-control" id="inputEmail3" placeholder="Broadcast Name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 control-label col-form-label">Tanggal Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="broadcast_desc" class="form-control" id="inputEmail3" placeholder="Broadcast Description" required>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-2 col-sm-9">
                                        <button type="submit" name='bc' class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
              
       <!-- /.container-fluid -->
                <!-- FORM TAMBAH  -->

                <!-- list data -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0"><?php echo "pageName"; ?></h3>
                            <p class="text-muted m-b-30"><?php echo"pageName;"; ?></p>
                            <div class="table-responsive">
                                <table id="example" class="table display">
                                    <thead>
                                        <tr>
                                            <th>Form</th>
                                            <th>Kategori</th>
                                            <th>Tipe</th>
                                           
                                            <th>Tanggal</th>
                                            
                                        </tr>
                                    </thead>
                                        <tr>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                           
                                            <td>2011/07/25</td>    
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- list data -->





                
              

       <!-- /.container-fluid -->
                <!-- tambah jadwal -->

                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form Tambah Tanaman</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" action="trnsql/sql.haji.php" enctype="multipart/form-data" method="post">

                                <div class="form-group row">
                                      <label for="inputPassword4" class="col-sm-2 control-label col-form-label">Pilih Tanaman*</label>
                                      <div class="col-sm-9">
                                         <select class="form-control" name="broadcast_type" required id='subtype'>
                                                <option value="">-----Blank-----</option>
                                                <option value="eksternal">Bawang</option>
                                                <option value="internal">Lombok</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 control-label col-form-label">Alamat Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="broadcast_name" class="form-control" id="inputEmail3" placeholder="Broadcast Name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 control-label col-form-label">Tanggal Tanaman*</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="broadcast_desc" class="form-control" id="inputEmail3" placeholder="Broadcast Description" required>
                                    </div>
                                </div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-2 col-sm-9">
                                        <button type="submit" name='bc' class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                                    </div>
                                </div>

                        </div>
                    </div>

@endsection