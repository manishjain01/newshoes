<head>
      
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo e(isset($title) ? config('settings.CONFIG_SITE_TITLE')." :: ".$title : config('settings.CONFIG_SITE_TITLE')); ?></title>
      <meta name="title" content="<?php echo e(config('settings.CONFIG_META_TITLE')); ?>">
      <meta name="keywords" content="<?php echo e(isset($meta_keywords) ? config('settings.CONFIG_META_KEYWORDS')." :: ".$meta_keywords : config('settings.CONFIG_META_KEYWORDS')); ?>">
      <meta name="description" content="<?php echo e(isset($meta_description) ? config('settings.CONFIG_META_DESCRIPTION')." :: ".$meta_description : config('settings.CONFIG_META_DESCRIPTION')); ?>">
    
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      
      <?php echo Html::style( asset('css/bootstrap.min.css')); ?>

      <?php echo Html::style( asset('css/style.css')); ?>

      <?php echo Html::style( asset('css/jquery-ui.css')); ?>

      <?php echo Html::style( asset('js/bootstrap-fileupload/bootstrap-fileupload.css')); ?>


      <?php echo Html::script( asset('js/jquery-3.3.1.min.js')); ?>

      <?php echo Html::script( asset('js/bootstrap.min.js')); ?>

      <?php echo Html::script( asset('js/jquery-ui.js')); ?>

      <?php echo Html::script( asset('js/carouselShoes.js')); ?>


      <?php echo Html::style( asset('css/magiczoomplus.css')); ?>

      <?php echo Html::script( asset('js/magiczoomplus.js')); ?>

      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prettify/188.0.0/prettify.min.js"></script>
      <?php echo Html::script( asset('js/bootstrap-fileupload/bootstrap-fileupload.js')); ?>

   </head>
