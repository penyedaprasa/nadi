@extends('layouts.master')

@section('page')
    Dashboard
@endsection

@section('namapage')
Dashboard
@endsection

@section('content')
    

                <!-- .row -->
                <div class="row">
                      <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form pagename</h3>
                            <p class="text-muted m-b-30 font-13"> Lengkapi Form Dengan Benar </p>
                            <form class="form-horizontal" action="trnsql/sql.users.php" method="post" enctype="multipart/form-data">
                                <!-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Username*</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Username" required>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Email*</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <label for="inputPassword3"class="col-sm-3 control-label col-form-label">Password*</label>
                                    <div class="col-sm-9">
                                        <input type="password"  name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword4" class="col-sm-3 control-label col-form-label">Ulangi Password*</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputPassword4" placeholder="Ulangi Password" required>
                                    </div>
                                </div>
								<div class="form-group row">
                                      <label for="inputPassword4" class="col-sm-3 control-label col-form-label">Level*</label>
									  <div class="col-sm-9">
                                         <select class="form-control" name="level" required>
												<option value="">Pilih Level Pengguna</option>
												<option value="dinkes">Admin</option>
                                                <option value="puskesmas">Puskesmas</option>
										 </select>
                                        </div>      
								</div>
                                <div class="form-group m-b-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" name="create" class="btn btn-info waves-effect waves-light m-t-10">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        

@endsection