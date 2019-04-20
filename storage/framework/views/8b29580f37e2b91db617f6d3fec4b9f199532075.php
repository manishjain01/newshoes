<head>
  <meta charset="UTF-8" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo e(isset($title) ? config('settings.CONFIG_SITE_TITLE')." :: ".$title : config('settings.CONFIG_SITE_TITLE')); ?>

  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.4 -->
  <?php echo Html::style( asset('admin/bootstrap/css/bootstrap.min.css')); ?>

  <?php echo Html::style( asset('css/font-awesome.css')); ?>

  <?php echo Html::style( asset('css/ionicons.css')); ?>

  <?php echo Html::style( asset('admin/plugins/iCheck/flat/blue.css')); ?>

  <?php echo Html::style( asset('admin/plugins/datepicker/datepicker3.css')); ?>

  <?php echo Html::style( asset('admin/plugins/daterangepicker/daterangepicker-bs3.css')); ?>

  <?php echo Html::style( asset('admin/plugins/select2/select2.min.css')); ?>

  <?php echo Html::style( asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')); ?>

  <?php echo Html::style( asset('css/bootstrap-multiselect.css')); ?>

  <?php echo Html::style( asset('admin/plugins/iCheck/all.css')); ?>

  <?php echo Html::style( asset('admin/css/jquery.noty.css')); ?>

  <?php echo Html::style( asset('admin/css/noty_theme_default.css')); ?>

  <?php echo Html::style( asset('admin/dist/css/AdminLTE.min.css')); ?>

  <?php echo Html::style( asset('admin/dist/css/skins/_all-skins.min.css')); ?>

  <?php echo Html::style( asset('admin/css/custom.css')); ?>

  <?php echo Html::style( asset('admin/css/bootstrap-multiselect.css')); ?>

  <?php echo Html::style( asset('admin/css/jquery-ui.css')); ?>

  <?php echo Html::style( asset('admin/css/validationEngine.jquery.css')); ?>

  <?php echo Html::style( asset('admin/css/jquery.dataTables.min.css')); ?>

  <?php echo Html::script( asset('admin/plugins/jQuery/jQuery-2.1.4.min.js')); ?>

  <?php echo Html::style( asset('admin/css/jquery.timepicker.css')); ?>

  <?php echo Html::style( asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')); ?>

  <script type="text/javascript">
    var IMAGE_URL   =   "<?php echo WEBSITE_ADMIN_IMG_URL; ?>";
    var WEBSITE_ADMIN_URL   =   "<?php echo WEBSITE_ADMIN_URL; ?>";
    var WEBSITE_URL   =   "<?php echo WEBSITE_URL; ?>";
    var csrf_token          = "<?php echo e(csrf_token()); ?>";
    var date_format          = "<?php echo e(DATE_FORMATE_JS); ?>";
  </script>
  <?php echo Html::script(asset('admin/bootstrap/js/bootstrap.min.js')); ?>

  <?php echo Html::script(asset('js/jquery.noty.js')); ?>

  <?php echo Html::script(asset('js/jquery.blockUI.js')); ?>

  <?php echo Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>

  <!--<?php echo Html::script( asset('admin/plugins/datepicker/bootstrap-datepicker.js')); ?>-->
  <?php echo Html::script( asset('ckeditor/ckeditor.js')); ?>

  <?php echo Html::script( asset('ckeditor/config.js')); ?>

  <?php echo Html::script( asset('admin/plugins/slimScroll/jquery.slimscroll.min.js')); ?>

  <?php echo Html::script( asset('admin/dist/js/app.min.js')); ?>

  <?php echo Html::script( asset('admin/plugins/select2/select2.full.min.js')); ?>

  <?php echo Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>

  <?php echo Html::script( asset('admin/plugins/timepicker/bootstrap-timepicker.min.js')); ?>

  <?php echo Html::script( asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.js')); ?>

  <?php echo Html::script( asset('admin/plugins/iCheck/icheck.min.js')); ?>

  <?php echo Html::script( asset('admin/js/bootbox.min.js')); ?>

  <?php echo Html::script( asset('js/bootstrap-multiselect.js')); ?>

  <?php echo Html::script( asset('admin/dist/js/demo.js')); ?>

  <?php echo Html::script( asset('admin/js/global.js')); ?>

  <?php echo Html::script( asset('admin/js/bootstrap-multiselect.js')); ?>

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
  <?php echo Html::script( asset('admin/js/bootstrap-datetimepicker.js')); ?>

  <?php echo Html::script( asset('admin/js/jquery-ui.js')); ?>

  
  <?php echo Html::script( asset('admin/js/jquery.ui.datepicker.validation.js')); ?>

  <?php echo Html::script( asset('admin/js/jquery.validate.js')); ?>

  <?php echo Html::script( asset('admin/js/jquery.validationEngine-en.js')); ?>

  <?php echo Html::script( asset('admin/js/jquery.validationEngine.js')); ?>

  <?php echo Html::script( asset('admin/js/jquery.dataTables.min.js')); ?>

  <?php echo Html::script(asset('js/jquery.timepicker.js')); ?>

  <script>
  $(function(){
    if($('#edit-editor-content').length>0){  
      CKEDITOR.replace('edit-editor-content',{
        customConfig: '/public/ckeditor'
      });
    }
    $("#datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-100:+0'
    });
  });
  </script>
  <script type="text/javascript">
    $(function () {
      var token = $('meta[name="csrf-token"]').attr('content');
      $(".select2").select2();
    });
  </script>
 


    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAU1dsRIRDWl75vrc8zdU8AOzXZdWuEP34"></script>

</head>
