<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
   <?php echo $__env->make('includes.admin.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php //  {!! Form::model($setting,['method'=>'post','route'=>'admin.settings.store','class'=>'form-horizontal']) !!}   ?>
                <?php echo Form::model($setting, ['route' => ['admin.settings.update', $setting->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH',  'files' => true  , 'id' => 'edit-settings']); ?>

                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#global_settings" data-toggle="tab"><?php echo e(trans('admin.GLOBAL_SETTINGS')); ?></a></li>



                    </ul>
                    <div class="tab-content">
                        <!-- Start Global Settings -->
                        <div class="tab-pane active" id="global_settings">


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label(trans('admin.SITE_TITLE'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('site_title',null,['class'=>'form-control','placeholder'=>trans('admin.SITE_TITLE')]); ?>


                                            <div class="error"><?php echo e($errors->first('site_title')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.ADMIN_PAGE_LIMIT'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('page_limit',null,['class'=>'form-control','placeholder'=>trans('admin.ADMIN_PAGE_LIMIT')]); ?>


                                            <div class="error"><?php echo e($errors->first('page_limit')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label(trans('admin.FRONT_PAGE_LIMIT'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('front_page_limit',null,['class'=>'form-control','placeholder'=>trans('admin.FRONT_PAGE_LIMIT')]); ?>


                                            <div class="error"><?php echo e($errors->first('front_page_limit')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label(trans('admin.STAFF_MAIL'),null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('staff_mail',null,['class'=>'form-control','placeholder'=>trans('admin.STAFF_MAIL')]); ?>


                                            <div class="error"><?php echo e($errors->first('staff_mail')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

                                </div>
                            </div><!-- /.col -->


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.FROM_NAME'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('from_name',null,['class'=>'form-control','placeholder'=>trans('admin.FROM_NAME')]); ?>


                                            <div class="error"><?php echo e($errors->first('from_name')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.REPLY_TO_EMAIL'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('reply_to_email',null,['class'=>'form-control','placeholder'=>trans('admin.REPLY_TO_EMAIL')]); ?>


                                            <div class="error"><?php echo e($errors->first('reply_to_email')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->
                            
                                                 <div class="row">

                                <div class="col-md-12">
                                                                <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.FROMEMAIL'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('fromemail',null,['class'=>'form-control','placeholder'=>trans('admin.FROMEMAIL')]); ?>


                                            <div class="error"><?php echo e($errors->first('fromemail')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.COPYRIGHT'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('copyright',null,['class'=>'form-control','placeholder'=>trans('admin.COPYRIGHT')]); ?>


                                            <div class="error"><?php echo e($errors->first('copyright')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

        
                                </div>
                            </div><!-- /.col -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label('Phone No.',null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('phone',null,['class'=>'form-control','placeholder'=>'Phone No.']); ?>

                                            <div class="error"><?php echo e($errors->first('phone')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label('Postal Address',null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::textarea('postal_address',null,['class'=>'form-control','placeholder'=>'Postal Address']); ?>


                                            <div class="error"><?php echo e($errors->first('postal_address')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->


                                </div>
                            </div>
                            
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label(trans('admin.META_TITLE'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('meta_title',null,['class'=>'form-control','placeholder'=>trans('admin.META_TITLE')]); ?>


                                            <div class="error"><?php echo e($errors->first('meta_title')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.META_KEYWORDS'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('meta_keywords',null,['class'=>'form-control','placeholder'=>trans('admin.META_KEYWORDS')]); ?>


                                            <div class="error"><?php echo e($errors->first('meta_keywords')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->
                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group col-md-6 ">
                                        <?php echo Form::label(trans('admin.META_DESCRIPTION'),null,['class'=>'col-sm-4 control-label required_label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::textarea('meta_description',null,['class'=>'form-control','placeholder'=>trans('admin.META_DESCRIPTION')]); ?>


                                            <div class="error"><?php echo e($errors->first('meta_description')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label(trans('admin.EMAIL_SIGNATURE'),null,['class'=>'col-sm-4 control-label required_label    ']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::textarea('email_signature',null,['class'=>'form-control','placeholder'=>trans('admin.EMAIL_SIGNATURE')]); ?>


                                            <div class="error"><?php echo e($errors->first('email_signature')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->

                                </div>
                            </div><!-- /.col -->
                            
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Shipping Charges',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('shipping_amount',null,['class'=>'form-control','placeholder'=>'Shipping Charges']); ?>


                                            <div class="error"><?php echo e($errors->first('shipping_amount')); ?></div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Facebook Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('facebook',null,['class'=>'form-control','placeholder'=>'Facebook Link']); ?>


                                            <div class="error"><?php echo e($errors->first('facebook')); ?></div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Linkedin Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('linkedin',null,['class'=>'form-control','placeholder'=>'Linkedin Link']); ?>


                                            <div class="error"><?php echo e($errors->first('linkedin')); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Twitter Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('twitter',null,['class'=>'form-control','placeholder'=>'Twitter Link']); ?>


                                            <div class="error"><?php echo e($errors->first('twitter')); ?></div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Thumblr Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('thumblr',null,['class'=>'form-control','placeholder'=>'Thumblr Link']); ?>


                                            <div class="error"><?php echo e($errors->first('thumblr')); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Imgur Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('imgur',null,['class'=>'form-control','placeholder'=>'Imgur Link']); ?>


                                            <div class="error"><?php echo e($errors->first('imgur')); ?></div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Gplus Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('gplus',null,['class'=>'form-control','placeholder'=>'Gplus Link']); ?>


                                            <div class="error"><?php echo e($errors->first('gplus')); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Pinterest Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('pinterest',null,['class'=>'form-control','placeholder'=>'Pinterest Link']); ?>


                                            <div class="error"><?php echo e($errors->first('pinterest')); ?></div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            
                            
                            <div class="row">

                                <div class="col-md-12">                                   
                                    <div class="col-md-6 form-group ">
                                        <?php echo Form::label('Instagram Url',null,['class'=>'col-sm-4 control-label']); ?>

                                        <div class='col-sm-8'>
                                            <?php echo Form::text('instagram',null,['class'=>'form-control','placeholder'=>'Instagram Link']); ?>


                                            <div class="error"><?php echo e($errors->first('instagram')); ?></div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            

                        </div><!-- /.row -->

                    </div>
                    <!-- END Global Settings -->


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
            <div class="box-footer">

                <?php echo Html::link(route('admin.settings.index'), trans('admin.CANCEL'), ['id' => 'linkid','class' => 'btn btn-default pull-left']); ?>

                

                <?php echo Form::submit(trans('admin.SUBMIT'),['class' => 'btn btn-info pull-right']); ?>

            </div>

            <?php echo Form::close(); ?>


        </div><!-- /.col -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>