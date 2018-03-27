<!DOCTYPE html>
<html>
<head>
  <?php $this->template->loadView('head_meta'); ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/AdminLTE.min.css" />

  <link rel="stylesheet" href="<?php echo base_url('assets/'); ?>adminlte/css/skins/skin-blue.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <?php foreach ($extra_css as $key => $css) { ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/') . $css; ?>">
  <?php } ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <?php $this->template->loadView('main_header'); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->template->loadView('main_side_bar'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php $this->template->loadView('content_header'); ?>

      <!-- Main content -->
      <section class="content container-fluid">
      <?php print_r($user_info->username); ?>
      <?php print_r($user_info->id); ?>
      <br>
        <?php echo $content; ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php $this->template->loadView('main_footer'); ?>

    <!-- Control Sidebar -->
    <?php $this->template->loadView('control_sidebar'); ?>

  </div>
  <!-- ./wrapper -->

  <!-- <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets/');?>adminlte/js/adminlte.min.js"></script>
  <?php foreach ($extra_js as $key => $js) { ?>
  <script src="<?php echo base_url('assets/') . $js; ?>"></script>
  <?php } ?>
</body>
</html>
