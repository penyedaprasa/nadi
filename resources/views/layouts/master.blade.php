<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/master/logo.png">
    <title>Horticulture | POLINDRA</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/assets_user/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/assets_user/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/assets_user/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/assets_user/css/colors/blue.css" id="theme" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="assets/assets_user/bootstrap/dist/js/tether.min.js"></script>
    <script src="assets/assets_user/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="assets/assets_user/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="assets/assets_user/js/waves.js"></script>
    <!--Counter js -->
    <script src="plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="plugins/bower_components/morrisjs/morris.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/assets_user/js/custom.min.js"></script>
    <script src="assets/assets_user/js/dashboard1.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-19175540-9', 'auto');
    ga('send', 'pageview');
    </script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> 
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="index.html">
                        <!-- logo image -->
                        <b><img src="plugins/images/users/pic.png" width="48px" height="48px" alt="home" /></b>
                        <!-- <b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b> -->
                        <span class="hidden-xs">
                            <!-- logo text -->
                            <img src="plugins/images/master/text-logo-mini.png" alt="home" />
                            <!-- <img src="plugins/images/eliteadmin-text.png" alt="home" /> -->
                        </span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
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

                    <li class="dropdown"> 
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#">
                            <i class="icon-envelope"></i>
                            <div class="notify">
                                <span class="heartbit"></span>
                                <span class="point"></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5>
                                            <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->


                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="plugins/images/users/pic.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->level }}</b> </a>

                        
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                        
                            <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                            <li><a href="#"><i class="ti-wallet"></i> Tanaman Saya</a></li>
                            <li><a href="#"><i class="ti-email"></i> Jadwal Saya</a></li>
                            <li role="separator" class="divider"></li>
                           
                            <li><a href="{{ route('logout') }}" class="logout-form" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off" ></i> Logout 
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        
                        </ul>
                        <!-- /.dropdown-user -->
                        
                    </li>

                    @endguest


                    <!-- setting -->
                    <li class="right-side-toggle"> <a class="waves-effect waves-light" href="#">
                        <i class="ti-settings"></i></a>
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                        <!-- /input-group -->
                    </li>

                    <!-- tempat navbar -->
                    @guest
                    
                    <li>
                        <a href="" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a>   
                    </li>

                    

                    @else

                    <li>
                        <a href="home" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a>   
                    </li>

                    <!-- <li> 
                        <a href="#" class="waves-effect"><i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i> <span class="hide-menu text-danger">Template Web<span class="fa arrow"></span></span></a>
                    </li> -->

                    <li> 
                        <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Tanaman Saya <span class="fa arrow"></span> </span></a>    
                    </li>

                    <li> 
                        <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Notifikasi <span class="fa arrow"></span> </span></a>    
                    </li>

                    <li> 
                        <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Penjadwalan <span class="fa arrow"></span> </span></a>    
                    </li>

                    @endguest



                    <!-- sampai sini -->
                    
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">@yield('namapage')</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">@yield('namapage')</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                
                @yield('content')

            </div>    
        </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2018 &copy; Horticulture | Teknik Informatika POLINDRA </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->



    
    <!-- CSS Table  -->
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/assets_user/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
     <!-- JS Table  -->
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src='assets/assets_user/js/dataTables.buttons.min.js'></script>
    <script src='assets/assets_user/js/buttons.flash.min.js'></script>
    <script src="assets/assets_user/js/jszip.min.js"></script>
    <script src='assets/assets_user/js/pdfmake.min.js'></script>
    <script src='assets/assets_user/js/vfs_fonts.js'></script>
    <script src='assets/assets_user/js/buttons.html5.min.js'></script>
    <script src='assets/assets_user/js/buttons.print.min.js'></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable(

            {
                "order": [
                    [0, 'desc']
                ],
            });
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 1
                }],
                "order": [
                    [1, 'desc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });

            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([1, 'asc']).draw();
                } else {
                    table.order([1, 'desc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
    
</body>

</html>
