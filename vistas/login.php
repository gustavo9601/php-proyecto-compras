<?php
@session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADVentas | www.incanatoit.com</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>ADVentas</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingrese sus datos de Acceso</p>
        <form action="../../index2.html" method="post" id="frmAcceso">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Login" id="logina">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="clavea">
                <span class="fa  fa-unlock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">

                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div><!-- /.col -->
            </div>
        </form>


        <a href="#">Olvidé mi password</a><br>


    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="../public/js/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../public/js/bootstrap.min.js"></script>
<!--Botobox-->
<script src="../public/js/bootbox.min.js"></script>

<!--Acceso-->
<script src="../vistas/scripts/login.js"></script>

</body>
</html>