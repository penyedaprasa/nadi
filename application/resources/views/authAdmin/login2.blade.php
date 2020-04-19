<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Horticulture">
    <meta name="author" content="Horticulture">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/master/logo.png') }} ">
    <title>Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/assets_admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet"> 
    <!-- animation CSS -->
    <link href="{{ asset('assets/assets_admin/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/assets_admin/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('assets/assets_admin/css/colors/green.css') }}" id="theme" rel="stylesheet">
    <!-- tables CSS -->
    <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/bower_components/jquery-wizard-master/css/wizard.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link rel="{{ asset('stylesheet" href="plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}" />
    <link href="{{ asset('assets/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    
</head>


<style type ="text/css">
.login-registerr{background:url(assets/plugins/images/master/3.jpga ) center center/cover no-repeat!important;height:100%;position:fixed}
</style>

<body>
    <!-- Preloader --> 
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div> 
    </div> 
    <section id="wrapper" class="login-registerr" >
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" action="{{ route('admin.login.submit') }}" method="POST" >
                 @csrf

                    <a href="#" class="text-center db"><img src="{{ asset('images/layouts/logo_holtikulture.png') }}" width="150px" height="150px" alt="Home" />
                    
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            <!-- <input class="form-control" type="text" required="" placeholder="Email" name="email"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                           <!-- <input class="form-control" type="password" required="" placeholder="Password" name="password"> -->
                        </div>
                    </div>

                    <br>

                    <!-- <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
        
                                <input id="checkbox-signup" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i>Lupa password?</a> </div>
                    </div> -->
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <div class="social">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                    <br>
                    <br>
                    <br>
                    <br>
                        <div class="col-sm-12 text-center">
                            <p>2018 © Horticulture </p>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" action='index.php?page=recover' method="post">
                
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Masukkan email dan akan dikirim link ganti password! <br>Laptop aplikasi harus terkoneksi internet!</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="email" >
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="reset">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/assets_admin/bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('assets/assets_admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('assets/assets_admin/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/assets_admin/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/assets_admin/js/custom.min.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
