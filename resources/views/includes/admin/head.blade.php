<head>
  <meta charset="UTF-8" name="csrf-token" content="{{ csrf_token() }}">
  <title>{{
     isset($title) ? config('settings.CONFIG_SITE_TITLE')." :: ".$title : config('settings.CONFIG_SITE_TITLE') }}
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.4 -->
  {!! Html::style( asset('admin/bootstrap/css/bootstrap.min.css')) !!}
  {!! Html::style( asset('css/font-awesome.css')) !!}
  {!! Html::style( asset('css/ionicons.css')) !!}
  {!! Html::style( asset('admin/plugins/iCheck/flat/blue.css')) !!}
  {!! Html::style( asset('admin/plugins/datepicker/datepicker3.css')) !!}
  {!! Html::style( asset('admin/plugins/daterangepicker/daterangepicker-bs3.css')) !!}
  {!! Html::style( asset('admin/plugins/select2/select2.min.css')) !!}
  {!! Html::style( asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')) !!}
  {!! Html::style( asset('css/bootstrap-multiselect.css')) !!}
  {!! Html::style( asset('admin/plugins/iCheck/all.css')) !!}
  {!! Html::style( asset('admin/css/jquery.noty.css')) !!}
  {!! Html::style( asset('admin/css/noty_theme_default.css')) !!}
  {!! Html::style( asset('admin/dist/css/AdminLTE.min.css')) !!}
  {!! Html::style( asset('admin/dist/css/skins/_all-skins.min.css')) !!}
  {!! Html::style( asset('admin/css/custom.css')) !!}
  {!! Html::style( asset('admin/css/bootstrap-multiselect.css')) !!}
  {!! Html::style( asset('admin/css/jquery-ui.css')) !!}
  {!! Html::style( asset('admin/css/validationEngine.jquery.css')) !!}
  {!! Html::style( asset('admin/css/jquery.dataTables.min.css')) !!}
  {!! Html::script( asset('admin/plugins/jQuery/jQuery-2.1.4.min.js')) !!}
  {!! Html::style( asset('admin/css/jquery.timepicker.css')) !!}
  {!! Html::style( asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')) !!}
  <script type="text/javascript">
    var IMAGE_URL   =   "{!! WEBSITE_ADMIN_IMG_URL !!}";
    var WEBSITE_ADMIN_URL   =   "{!! WEBSITE_ADMIN_URL !!}";
    var WEBSITE_URL   =   "{!! WEBSITE_URL !!}";
    var csrf_token          = "{{ csrf_token()}}";
    var date_format          = "{{ DATE_FORMATE_JS }}";
  </script>
  {!! Html::script(asset('admin/bootstrap/js/bootstrap.min.js')) !!}
  {!! Html::script(asset('js/jquery.noty.js')) !!}
  {!! Html::script(asset('js/jquery.blockUI.js')) !!}
  {!! Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')) !!}
  <!--{!! Html::script( asset('admin/plugins/datepicker/bootstrap-datepicker.js')) !!}-->
  {!! Html::script( asset('ckeditor/ckeditor.js')) !!}
  {!! Html::script( asset('ckeditor/config.js')) !!}
  {!! Html::script( asset('admin/plugins/slimScroll/jquery.slimscroll.min.js')) !!}
  {!! Html::script( asset('admin/dist/js/app.min.js')) !!}
  {!! Html::script( asset('admin/plugins/select2/select2.full.min.js')) !!}
  {!! Html::script( asset('admin/plugins/daterangepicker/daterangepicker.js')) !!}
  {!! Html::script( asset('admin/plugins/timepicker/bootstrap-timepicker.min.js')) !!}
  {!! Html::script( asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.js')) !!}
  {!! Html::script( asset('admin/plugins/iCheck/icheck.min.js')) !!}
  {!! Html::script( asset('admin/js/bootbox.min.js')) !!}
  {!! Html::script( asset('js/bootstrap-multiselect.js')) !!}
  {!! Html::script( asset('admin/dist/js/demo.js')) !!}
  {!! Html::script( asset('admin/js/global.js')) !!}
  {!! Html::script( asset('admin/js/bootstrap-multiselect.js')) !!}
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
  {!! Html::script( asset('admin/js/bootstrap-datetimepicker.js')) !!}
  {!! Html::script( asset('admin/js/jquery-ui.js')) !!}
  
  {!! Html::script( asset('admin/js/jquery.ui.datepicker.validation.js')) !!}
  {!! Html::script( asset('admin/js/jquery.validate.js')) !!}
  {!! Html::script( asset('admin/js/jquery.validationEngine-en.js')) !!}
  {!! Html::script( asset('admin/js/jquery.validationEngine.js')) !!}
  {!! Html::script( asset('admin/js/jquery.dataTables.min.js')) !!}
  {!! Html::script(asset('js/jquery.timepicker.js')) !!}
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
