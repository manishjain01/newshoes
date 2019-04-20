 

<?php $__env->startSection('content'); ?>  


<div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Admin</b><?php echo e(config('settings.CONFIG_SITE_TITLE')); ?></a>
      </div>
      <div class="login-box-body"> 
        <p class="login-box-msg">Sign in to start your session</p>
        
    
        <?php echo Form::open(array('url' =>  URL::to('admin/login'))); ?>


          <div class="form-group has-feedback">
            <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']); ?>

            <div class="error"><?php echo e($errors->first('email')); ?></div>
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <?php echo Form::password('password',['class'=>'form-control','placeholder'=>'Password']); ?>

            <div class="error"><?php echo e($errors->first('password')); ?></div>
            <!--<input type="password" class="form-control" placeholder="Password" />-->
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
        <?php echo Html::link(route('admin.forgot_password'), 'Forgot Password', array('class' => 'btn btn-default btn-flat')); ?>

            </div><!-- /.col -->
            <div class="col-xs-4">
            <?php echo Form::submit('Sign In',['class'=>'btn btn-primary btn-block btn-flat']); ?>


            </div>
          </div>

        <?php echo Form::close(); ?>



    <!-- jQuery 2.1.4 -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>