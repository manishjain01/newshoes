<?php $__env->startSection('content'); ?> 

<section class="about_us">
   <div class="container">
      <div class="row">
          <h2 class="heading_page block animatable moveUp"><?php echo e($cmslist->title); ?></h2>
          <p><?php echo $cmslist->description; ?></p>
      </div>
   </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>