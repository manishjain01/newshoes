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
        
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center"><?php echo e(trans('admin.PROFILE_IMAGE')); ?></th>-->
                <th width="5%" align="center">S. No.</th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('type', 'Page Title'));?></th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('price', 'Page Description'));?></th>
              <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at','Date'));?></th>
              <th width="10%"><?php echo e(trans('admin.STATUS')); ?></th>
              <th width="15%" align="center"><?php echo e(trans('admin.EDIT')); ?></th>
            </tr>
            </thead>
            <tbody>
              <?php if(!$cmslist->isEmpty()): ?>
              <?php $i = $cmslist->perPage() * ($cmslist->currentPage() - 1);?>
              <?php foreach($cmslist as $plan): ?>
             
           <tr>
               <td><?php echo e($i+1); ?></td>
              <td><?php echo e(ucfirst($plan->title)); ?></td>             
              <td><?php echo e(str_limit($plan->description, $limit = 200, $end = '...')); ?></td>
               <td><?php echo e(date_val($plan->created_at,DATE_FORMATE )); ?></td>              
              <td>
                  <?php if($plan->status == 1): ?>
                    Active
                  <?php else: ?>
                    Inactive
                  <?php endif; ?>
              </td>
              <td>
                            <?php echo Html::decode(Html::link(route('admin.cms.edit', $plan->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>				  
                           <?php /* ?> {!! Form::model($plan, ['method' => 'DELETE', 'url' => '/admin/cms/' . $plan->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}<?php */?>
              </td>
           </tr>
           <?php $i++;?>
            <?php endforeach; ?>
             <?php else: ?>

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           <?php endif; ?>

            </tbody>
          </table>
           <?php echo $cmslist->appends(Input::all('plan'))->render(); ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>