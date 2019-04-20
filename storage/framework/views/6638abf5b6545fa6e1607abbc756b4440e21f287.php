<!DOCTYPE html>
<html lang="en">
       <?php echo $__env->make('includes.frontend.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <body class="preloader-active">

	    <?php echo $__env->make('includes.frontend.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    <?php echo $__env->yieldContent('content'); ?>
	    <?php echo $__env->make('includes.frontend.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    </body>
</html>
