<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageTitle;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('public/admin_assets/dist/css/adminlte.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('public/admin_assets/plugins/iCheck/square/blue.css');?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php echo $this->session->flashdata('message');?>
      <form action="<?php echo current_url();?>" method="post">
        <input type="hidden" name="<?=$csrf_name;?>" value="<?=$csrf_hash;?>" id="token_val">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="username" placeholder="Email" required="">
          <span class="fa fa-envelope form-control-feedback"><?php echo form_error('username'); ?></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" placeholder="Password" required="">
          <span class="fa fa-lock form-control-feedback"><?php echo form_error('password'); ?></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <!-- <label>
                <input type="checkbox"> Remember Me
              </label> -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4"> 
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url('public/admin_assets/plugins/jquery/jquery.min.js');?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('public/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('public/admin_assets/plugins/iCheck/icheck.min.js');?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
</body>
</html>
