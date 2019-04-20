<?php $__env->startSection('content'); ?>
<style>
    span.msg_success {
    font-size: 16px;
    padding-bottom: 5px;
    float: left;
    font-weight: 600;
    color: green;
}
</style>
<section class="contact_bnnr">
    <div class="container-fluid">
        <div class="row contact_fromm">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3561.231571861156!2d75.80407951451811!3d26.80075417135403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396dca209a6815df%3A0xe7336632737d54c5!2s51%2F43%2C+Sanganer%2C+Sector+5%2C+Pratap+Nagar%2C+Jaipur%2C+Rajasthan+302033!5e0!3m2!1sen!2sin!4v1549453807978"  width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>

                    <a href="https://www.pureblack.de/webdesign/"></a></div>
                <style>.mapouter{text-align:right;height:500px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}</style>
            </div>
        </div>
    </div>
</section>
<section class="contct_form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading_page heading_cart1">Contact Us</h2> 
            </div>
        </div>
         <div class="row address_row contact_fromm">
            <div class="col-md-6">
                <div>
                    <span class="msg_success">
                        <?php if(Session::has('alert-sucess')): ?>
                        <?php echo Session::get('alert-sucess'); ?>

                        <?php endif; ?>
                    </span>
                    <span class="msg_error">
                        <?php if(Session::has('alert-error')): ?>
                        <?php echo Session::get('alert-error'); ?>

                        <?php endif; ?>
                    </span>
                </div>

                <?php echo Form::open(['route'=>'contact_us_post','class'=>'frm_cnt']); ?> 
                <div class="form-group">
                    <?php echo Form::text('name',null,['class'=>'form-control','placeholder'=>'Enter Name']); ?>

                    <div class="error"><?php echo e($errors->first('name')); ?></div>
                </div>
                <div class="form-group">
                    <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>'Enter Email']); ?>

                    <div class="error"><?php echo e($errors->first('email')); ?></div>
                </div>

                <div class="form-group">
                    <?php echo Form::text('subject',null,['class'=>'form-control','placeholder'=>'Subject']); ?>

                    <div class="error"><?php echo e($errors->first('subject')); ?></div>
                </div>

                <div class="form-group">
                    <?php echo Form::textarea('message',null,['class'=>'form-control textarea','maxlength'=>'500','placeholder'=>'Enter Message Character Limit 500']); ?>

                    <div class="error"><?php echo e($errors->first('message')); ?></div>
                </div>
                <!--<button type="submit" class="btn btn-default">Submit</button>-->
                <?php echo Form::submit('Submit',['class' => 'btn btn-default']); ?>

                <?php echo Form::close(); ?>

            </div>
            <div class="col-md-6 address_cont_fld">
                <h4><i class="fa fa-map-marker" aria-hidden="true"></i> Address</h4>
                <p> <?php echo Configure('CONFIG_POSTAL_ADDRESS'); ?></p>
                <h4><i class="fa fa-phone" aria-hidden="true"></i> Number</h4>
                <p> <?php echo e(Configure('CONFIG_PHONE')); ?></p>
                <h4><i class="fa fa-envelope" aria-hidden="true"></i> Email ID</h4>
                <p><a href="javascript:void(0);"><?php echo e(Configure('CONFIG_FROMEMAIL')); ?></a></p>
            </div>
        </div>  
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>