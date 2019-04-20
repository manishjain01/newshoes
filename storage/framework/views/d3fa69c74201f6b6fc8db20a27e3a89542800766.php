<!DOCTYPE html>
<html lang="en">
       <?php echo $__env->make('includes.admin.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body class="skin-blue sidebar-mini">
	    <?php echo $__env->make('includes.admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    <?php echo $__env->make('includes.admin.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    <?php echo $__env->make('includes.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    <div class="wrapper">
	    <?php echo $__env->yieldContent('content'); ?>
	    <?php echo $__env->make('includes.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>
</html>