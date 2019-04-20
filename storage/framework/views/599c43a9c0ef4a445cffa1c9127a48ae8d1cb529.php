<!-- Content Wrapper. Contains page content -->


<?php $__env->startSection('content'); ?>  

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        <?php echo $__env->make('includes.admin.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="pull-right">  
                    <?php echo Html::decode(Html::link(route('admin.cms.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

                </h3>
            </div>
            <?php echo Form::model($cms,['method'=>'patch','route'=>['admin.cms.update',$cms->id]]); ?>


            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="col-md-6 form-group ">
                            <?php echo Form::label(trans('admin.TITLE'),null,['class'=>'required_label']); ?>

                            <?php echo Form::text('title',null,['class'=>'form-control','placeholder'=>trans('admin.TITLE')]); ?>

                            <div class="error"><?php echo e($errors->first('title')); ?></div>
                        </div><!-- /.form-group -->

                        <div class="form-group col-md-12 ">
                            <?php echo Form::label(trans('admin.DESCRIPTION'),null,['class'=>'required_label']); ?>

                            <?php echo Form::textarea('description',null,['class'=>'form-control ckeditor','placeholder'=>trans('admin.DESCRIPTION')]); ?>

                            <div class="error"><?php echo e($errors->first('description')); ?></div>
                        </div><!-- /.form-group -->

                        <div class="form-group col-md-6 ">
                            <?php echo Form::label(trans('admin.META_KEYWORDS'),null,['class'=>'required_label']); ?>

                            <?php echo Form::textarea('meta_keywords',null,['class'=>'form-control ','placeholder'=>trans('admin.META_KEYWORDS')]); ?>

                            <div class="error"><?php echo e($errors->first('meta_keywords')); ?></div>
                        </div><!-- /.form-group -->  
                        <div class="form-group col-md-6 ">
                            <?php echo Form::label(trans('admin.META_DESCRIPTION'),null,['class'=>'required_label']); ?>

                            <?php echo Form::textarea('meta_description',null,['class'=>'form-control ','placeholder'=>trans('admin.META_DESCRIPTION')]); ?>

                            <div class="error"><?php echo e($errors->first('meta_description')); ?></div>
                        </div><!-- /.form-group -->
                        <div class="form-group col-md-6 ">
                            <?php echo Form::label(trans('admin.META_TITLE'),null,['class'=>'required_label']); ?>

                            <?php echo Form::text('meta_title',null,['class'=>'form-control ','placeholder'=>trans('admin.META_TITLE')]); ?>

                            <div class="error"><?php echo e($errors->first('meta_title')); ?></div>
                        </div><!-- /.form-group --> 
                        <div class="form-group col-md-6">
                            <?php echo Form::label(trans('admin.STATUS'),null,['class'=>'required_label']); ?>

                            <?php $status_list = Config::get('global.status_list'); ?>
                            <?php echo Form::select('status', $status_list, null, ['class' => 'form-control']); ?>

                        </div><!-- /.form-group -->


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">

                    <?php echo Html::decode(Html::link(route('admin.cms.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])); ?>

                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info ']); ?>

                </div>
            </div>
            <!-- /.box-footer -->
            <?php echo Form::close(); ?>

        </div><!-- /.box -->
    </section><!-- /.content -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>