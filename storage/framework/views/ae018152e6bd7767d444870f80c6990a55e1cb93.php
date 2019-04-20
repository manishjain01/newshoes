  <!-- Content Wrapper. Contains page content -->
  

  <?php $__env->startSection('content'); ?>  

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header with-border+">
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
                 
                 <th width="30%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('name', trans('admin.NAME')));?></th>
                 <th width="30%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('subject', trans('admin.SUBJECT')));?></th>
                  <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('updated_at', trans('admin.UPDATED_AT')));?></th>
                  <th  width="20%" align="center"><?php echo e(trans('admin.ACTION')); ?></th>
                  
                </tr>
                </thead>
                 <tbody id="data-table-check">
                   <?php if(!$emailtemplates->isEmpty()): ?>
                  <?php foreach($emailtemplates as $emailtemplate): ?>
                    <tr>
                     <td><?php echo e($emailtemplate->name); ?></td>
                     <td><?php echo e($emailtemplate->subject); ?></td>
                    
                     <td><?php echo e(date_val($emailtemplate->updated_at,DATE_FORMATE )); ?></td>
                     <td align="center">
                        <?php echo Html::decode(Html::link(route('admin.emailtemplates.edit', $emailtemplate->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php else: ?>

                      <tr><td colspan="5"><div class="data_not_found"> Data Not Found </div></td></tr>


                      <?php endif; ?>
                </tbody>
              </table>
              <?php echo $emailtemplates->appends(Input::all('page'))->render(); ?>

            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php $__env->stopSection(); ?>
  <!-- /.content-wrapper -->


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>