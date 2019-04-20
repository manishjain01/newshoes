<?php $__env->startSection('content'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
  <?php echo Html::decode(Html::link(route('admin.colors.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])); ?>				  
<?php echo $__env->make('includes.admin.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

      <div class="box box-primary">
          <?php if(Session::has('alert-sucess')): ?>
                <div class="alert alert-info alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo Session::get('alert-sucess'); ?>

                </div>
            <?php endif; ?>
            <?php if(Session::has('alert-error')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert" id="message">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo Session::get('alert-error'); ?>

                </div>
            <?php endif; ?>
        
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center"><?php echo e(trans('admin.PROFILE_IMAGE')); ?></th>-->
                <th width="5%">S.No</th>
                <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('color_picker', 'Color Picker'));?></th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('color_name', 'Color Name'));?></th>
              <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at','Date'));?></th>
              <th width="10%"><?php echo e(trans('admin.STATUS')); ?></th>
              <th width="15%" align="center"><?php echo e(trans('admin.EDIT')); ?></th>
            </tr>
            </thead>
            <tbody>
              <?php if(!$colors->isEmpty()): ?>
               <?php $i = $colors->perPage() * ($colors->currentPage() - 1);?>
              <?php foreach($colors as $key=>$color): ?>
             
           <tr>
              <td><?php echo e(($i+1)); ?></td>
              <td>
                  <span style="width: 25px; height: 25px; background-color: <?php echo e($color->color_picker); ?>; float: left;"></span>
                 
              </td>
              <td><?php echo e(ucfirst($color->color_name)); ?></td>
               <td><?php echo e(date_val($color->created_at,DATE_FORMATE )); ?></td>
              
              
              <td>
                  <?php if($color->status == 1): ?>
                    Active
                  <?php else: ?>
                    Inactive
                  <?php endif; ?>
              </td>
              <td>
				  <?php echo Html::decode(Html::link(route('admin.colors.edit', $color->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>				  
                           <?php /*?>{!! Form::model($color, ['method' => 'DELETE', 'url' => '/admin/colors/' . $color->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!} <?php */?>
              </td>
           </tr>
           <?php $i++;?>
            <?php endforeach; ?>
             <?php else: ?>

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           <?php endif; ?>

            </tbody>
          </table>
           <?php echo $colors->appends(Input::all('colors'))->render(); ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $('#cp2').colorpicker();
</script>
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>