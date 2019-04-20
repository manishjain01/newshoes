<head>
  <meta charset="UTF-8" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo e(isset($title) ? config('settings.CONFIG_SITE_TITLE')." :: ".$title : config('settings.CONFIG_SITE_TITLE')); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.4 -->
  <?php echo Html::style( asset('admin/bootstrap/css/bootstrap.min.css')); ?>

  <!-- FontAwesome 4.3.0 -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons 2.0.0 -->
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <?php echo Html::style( asset('admin/dist/css/AdminLTE.min.css')); ?>

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <?php echo Html::style( asset('admin/dist/css/skins/_all-skins.min.css')); ?>

  <?php echo Html::style( asset('admin/css/custom.css')); ?>

  <?php echo Html::style( asset('admin/css/jquery.noty.css')); ?>

  <?php echo Html::style( asset('admin/css/noty_theme_default.css')); ?>

  <!-- iCheck -->

  <!-- iCheck for checkboxes and radio inputs -->
  
 
  <!-- jQuery 2.1.4 -->
<?php echo Html::script( asset('admin/plugins/jQuery/jQuery-2.1.4.min.js')); ?>

<!-- jQuery UI 1.11.4 -->

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript">

  var IMAGE_URL   =   "<?php echo WEBSITE_ADMIN_IMG_URL; ?>";

</script>

<?php echo Html::script(asset('admin/bootstrap/js/bootstrap.min.js')); ?>

<?php echo Html::script(asset('js/jquery.noty.js')); ?>

<?php echo Html::script(asset('js/jquery.blockUI.js')); ?>

<!-- Morris.js charts -->

<?php echo Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>

<!-- datepicker -->
<?php echo Html::script( asset('admin/plugins/datepicker/bootstrap-datepicker.js')); ?>

<!-- Bootstrap WYSIHTML5 -->
<?php echo Html::script( asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>

<!-- Slimscroll -->
<?php echo Html::script( asset('admin/plugins/slimScroll/jquery.slimscroll.min.js')); ?>


<!-- adminLTE App -->
<?php echo Html::script( asset('admin/dist/js/app.min.js')); ?>

<!-- Select2 -->
<?php echo Html::script( asset('admin/plugins/select2/select2.full.min.js')); ?>

<!-- date-range-picker -->

<?php echo Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>

<!-- bootstrap time picker -->
<?php echo Html::script( asset('admin/plugins/timepicker/bootstrap-timepicker.min.js')); ?>

<!-- bootstrap color picker -->
<?php echo Html::script( asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.js')); ?>



<!-- iCheck 1.0.1 -->
<?php echo Html::script( asset('admin/plugins/iCheck/icheck.min.js')); ?>

<?php echo Html::script( asset('admin/js/global.js')); ?>

  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
	 <div class="loading-cntant" >
			<div class="loader"></div>
		</div>
