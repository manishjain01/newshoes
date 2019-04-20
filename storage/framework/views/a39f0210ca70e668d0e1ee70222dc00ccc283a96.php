<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  

<section class="detail_pagee">
    <div class="container">
        <div class="row review_rating_row rvw_detail_page">
            <div class="col-md-12"><h2 class="heading_page">Reviews and Rating <i class="fa fa-star f1" aria-hidden="true"></i></h2> </div>
            <div class="col-md-12">
                <ul>
                    <?php if(isset($reviews) && !empty($reviews)): ?>
                    <?php foreach($reviews as $key=>$review): ?>
                    <li class="col-md-12">
                        <div class="col-md-1 col-xs-2">
                            <?php if(isset($review->profile_img) && !empty($review->profile_img)): ?> 
                            <?php if(substr($review->profile_img, 0, 4) == 'http'): ?>
                            <img alt="" src="<?php echo e($review->profile_img); ?>">
                            <?php else: ?>    
                            <img alt="" src="<?php echo e(USER_IMAGE_URL.$review->profile_img); ?>">
                            <?php endif; ?>
                            <?php else: ?>
                            <img alt="" src="<?php echo e(asset('img/user.png')); ?>">   
                            <?php endif; ?>
                           
                        </div>
                        <div class="col-md-11 col-xs-10">
                            <h4><?php echo e($review->first_name); ?> <?php echo e($review->last_name); ?></h4> 
                            <a href="javascript:void(0);">
                                <?for($i=0; $i<$review->rating; $i++){?>
                                <i class="fa fa-star f1" aria-hidden="true"></i> 
                                <? } ?>
<!--                                <i class="fa fa-star f1" aria-hidden="true"></i> 
                                <i class="fa fa-star f2" aria-hidden="true"></i> 
                                <i class="fa fa-star f3" aria-hidden="true"></i> 
                                <i class="fa fa-star f4" aria-hidden="true"></i>
                                <i class="fa fa-star f5" aria-hidden="true"></i>-->
                            </a>
                            <p><?php echo e($review->comment); ?></p></div>
                    </li>
                     <?php endforeach; ?>
                    <?php endif; ?>
                    
                </ul>
                <div class="col-md-12 pg_ni">

                    <?php echo $reviews->appends(Input::all('page'))->render(); ?>


                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>