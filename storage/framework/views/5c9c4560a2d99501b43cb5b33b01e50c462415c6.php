<!DOCTYPE html>
<html lang="en">
           <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             
       	    <?php echo $__env->make('includes.admin.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body class="login-page">   
	   <?php echo $__env->yieldContent('content'); ?>
	 </body>
</html>