<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Apps Admin PHP ">
    <meta name="author" content="TechnoGIS Indonesia">
    <link rel="icon" type="image/png" sizes="16x16" href="uploads/images/assets/image">
    <title>{{ config('app.name', 'Laravel') }}</title>
   <!--  CSS Start Here-->
    <!-- Bootstrap Core CSS -->
    <link href="assets/assets_admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/assets_admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/assets_admin/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/assets_admin/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- custome plugin -->
    <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!--js script start here-->
    <!-- Bootstrap Core JavaScript -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="assets/assets_admin/bootstrap/dist/js/tether.min.js"></script>
    <script src="assets/assets_admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="assets/assets_admin/js/jquery.slimscroll.js"></script> 
    <!--Wave Effects -->
    <script src="assets/assets_admin/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/assets_admin/js/custom.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!-- Toast message JavaScript -->
    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>

</head>
<body>
    <!-- Preloader-->
 <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>


<!-- asda -->
<!-- Navigation -->
        <div class="no-print">
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="index.php"><b><img src="plugins/images/users/pic.png" width="48px" height="48px" alt="home" /></b><span class="hidden-xs"><strong>H</strong>orticulture</span></a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    @guest
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="plugins/images/users/pic.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">Masuk</b> </a>

                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="{{ route('login') }}"><i class="ti-user"></i> Login</a></li>
                        </ul>

                    </li>
                    @else

                    <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->level }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                    @endguest

                    <li class="right-side-toggle"> <a class="waves-effect waves-light" href="#" target="_blank"><i class="ti-settings"></i></a></li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        </div>

        <!-- asda -->

                <div class="no-print">
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                        <!-- /input-group -->
                    </li>
                    <li class="user-pro">
                        <a href="#" class="waves-effect"><img src="plugins/images/users/pic.png" alt="user-img" class="img-circle"> <span class="hide-menu">robet
                <span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>   
                            <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                    <!-- <li> <a href="index.php?page=home" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard </span></a></li> -->
                    <!--li> <a href="#" class="waves-effect"><i data-icon="&#xe008;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Form Koesioner<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="index.php?page=form">List Koesioner</a></li>
                            <li><a href="index.php?page=addform">Add Koesioner</a></li> 
                             <li> <a href="javascript:void(0)" class="waves-effect">+ Form Categories <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li> <a href="index.php?page=formcategories">List Categories</a> </li>
                                    <li> <a href="index.php?page=formaddcategories">Add Categories</a> </li>
                                </ul>
                            </li>   
                        </ul>
                    </li-->

                    <li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="&#xe009;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Data Rekap<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?page=nambahcoy">+ Add Data</a> </li>
                            <li> <a href="javascript:void(0)" class="waves-effect">+ Data Maternal <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li> <a href="index.php?page=maternal">List Data</a> </li>
                                    <li> <a href="index.php?page=maternalbulanan">Data Per-Bulan</a> </li>
                                </ul>
                            </li>
                            <li> <a href="javascript:void(0)" class="waves-effect">+ Data Neonatal <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li> <a href="index.php?page=neonatal">List Data</a> </li>
                                    <li> <a href="javascript:void(0)">Data Per-Bulan</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-chart p-r-10"></i> <span class="hide-menu"> Reports <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?page=maternalreport">Maternal Report</a></li>
                            <li> <a href="index.php?page=neonatalreport">Neonatal Report</a></li>
                            < <li> <a href="index.php?page=usersreport">Users Report</a></li> >
                        </ul>
                    </li> -->
                     <!--li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="&#xe00d;" class="linea-icon linea-elaborate fa-fw"></i> <span class="hide-menu">Responden<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?page=responden">List Responden</a> </li>
                           
                        </ul>
                    </li-->

                    <!-- galeri -->
                    <!-- <li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="O" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Gallery<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?page=gallery">List Gallery</a> </li>       
                        </ul>
                    </li> -->
                    
                     <!--li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="R" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Maps<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="javascript:void(0)">List Maps</a> </li>
                            <li> <a href="javascript:void(0)">Add Map</a> </li>
                            <li> <a href="javascript:void(0)" class="waves-effect">+ Map Categories <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li> <a href="javascript:void(0)">List Categories</a> </li>
                                    <li> <a href="javascript:void(0)">Add Categories</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </li>-->
                    
                    <!-- <li><a href="javascript:void(0);" class="waves-effect"><i data-icon=")" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Mailbox<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="inbox.html">Inbox</a></li>
                            <li> <a href="inbox-detail.html">Inbox detail</a></li>
                            <li> <a href="compose.html">Compose mail</a></li>
                        </ul>
                    </li> -->
                    <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-people p-r-10"></i> <span class="hide-menu"> Users <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            
                            <li> <a href="users/create">Add Users</a> </li>
                        </ul>
                    </li>

                    <!-- report -->
                    <!-- <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-chart p-r-10"></i> <span class="hide-menu"> Reports <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?page=generalreport">General Report</a></li>
                            <li> <a href="index.php?page=respondenreport">Responden Report</a></li>
                            <li> <a href="index.php?page=usersreport">Users Report</a></li>
                        </ul>
                    </li> -->

                    <!-- setting -->
                    <!-- <li> <a href="#" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Setting<span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="index.php?page=setting">General Setting</a></li>
                            <li><a href="index.php?page=messagehome">Dashboard Message</a></li>
                            <li><a href="index.php?page=logo">Logo & Banner</a></li>
                            </ul>
                    </li> -->

                    <!-- panduan -->
                    <!-- <li>
                        <a href="index.php?page=panduan" class="waves-effect">
                            <i class="linea-icon linea-basic" data-icon="&#xe00b;"></i>
                                <span class="hide-menu">Panduan</span>
                            </i>
                        </a>
                    </li> -->
                   
                </ul>
            </div>
        </div>
    </div>

  

    @yield('content')

    <!-- asdas -->
    <footer class="footer text-center"> 2019 &copy; TA </footer> 