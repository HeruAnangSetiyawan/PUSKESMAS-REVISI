<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistem Pelayanan Puskesmas Nusamandiri</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>/adminlte/index2.html"><b>Sistem Pelayanan Puskesmas Nusamandiri</b></a>
            </div>
            <!-- /.login-logo -->
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
      <?php echo validation_errors() ;?>
            <div class="login-box-body">
            

                <!--<form action="<?php echo base_url(); ?>/adminlte/index2.html" method="post">-->
                <?php echo form_open('auth/cheklogin'); ?>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-danger btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                    </div>
                   
                </div>
                <!-- /.col -->


                <!-- /.col -->
               
                </form>




            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
