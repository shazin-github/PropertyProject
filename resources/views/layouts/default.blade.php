<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Brokergenius Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  -->
  <link rel="stylesheet" href="dist/css/font-awesome.min.css">
  <!-- Ionicons 
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- Skin-blue-->
  <link rel="stylesheet" href="dist/css/skins/skin-red.min.css">
  <!-- dataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- application -->
  <link rel="stylesheet" href="dist/css/application.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
@if( Session::has('email') )
<body class="skin-red sidebar-mini">
  <div id="overlay">
    <table width="100%" height="100%">
      <tr><td valign="middle"><img src="dist/img/squares_1.gif" width="80px" height="80px"/><p>Processing</p></td></tr>
    </table>
  </div>
  
  <div class="wrapper">
    <div id="left_nav">
      @include('includes.left_nav')
    </div>
@else
<body class="layout-top-nav skin-red sidebar-mini">
  <div id="overlay">
    <table width="100%" height="100%">
      <tr><td valign="middle"><img src="dist/img/squares_1.gif" width="80px" height="80px"/><p>Processing</p></td></tr>
    </table>
  </div>

  <div class="wrapper">
    <div id="left_nav"  style="display: none">
    @include('includes.left_nav')
    </div>
@endif
        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">

        <!-- Main content -->
        <section class="content" style="padding: 5px">
          @yield('content')
        </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!--<footer class="main-footer"></footer>-->
    </div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- dataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins\datatables\extensions\Scroller\js\dataTables.scroller.min.js"></script>
<!-- notifyMe -->
<script src="plugins/notifyMe/jquery.notifyme.min.js"></script>
<!-- Main application -->
<script src="dist/js/application.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
