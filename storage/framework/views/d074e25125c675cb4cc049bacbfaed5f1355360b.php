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

      <div class="box box-primary">
        <div class="box-header with-border">
            
            <?php /* ?><h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.users.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
            </h3><?php */ ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--            <th  width="15%" align="center"><?php echo e(trans('admin.PROFILE_IMAGE')); ?></th>-->
                <th width="5%" align="center">S. No.</th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('name', 'Name'));?></th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('email', trans('admin.EMAIL')));?></th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('subject', 'Subject'));?></th>
              <th width="15%">Message</th>
              <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', trans('admin.REGISTERED_ON')));?></th>
<!--              <th width="10%"><?php echo e(trans('admin.STATUS')); ?></th>-->
<!--              <th width="15%" align="center">Action</th>-->
            </tr>
            </thead>
            <tbody>
              <?php if(!$users->isEmpty()): ?>
              <?php $i = $users->perPage() * ($users->currentPage() - 1);?>
              <?php foreach($users as $user): ?>
            
            
           <tr>
               <td><?php echo e($i+1); ?></td>
              <td><?php echo e(ucfirst($user->name)); ?></td>
            
              <td><?php echo e($user->email); ?></td>
              <td><?php echo e($user->subject); ?></td>
              <td><?php echo e($user->message); ?> </td>
              <td><?php echo e(date_val($user->created_at,DATE_FORMATE )); ?></td>
              
             
         <?php $i++;?>
            <?php endforeach; ?>
             <?php else: ?>

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           <?php endif; ?>

            </tbody>
          </table>
           <?php echo $users->appends(Input::all('page'))->render(); ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>