<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $pageTitle; ?>
  </h1>
  <?php echo Html::decode(Html::link(route('admin.categories.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])); ?>				  
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
              <th width="5%">S.No</th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('cat_name', 'Category Name'));?></th>
              <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at','Date'));?></th>
              <th width="10%"><?php echo e(trans('admin.STATUS')); ?></th>
              <th width="15%" align="center"><?php echo e(trans('admin.EDIT')); ?></th>
            </tr>
            </thead>
            <tbody>
              <?php if(!$categories->isEmpty()): ?>
               <?php $i = $categories->perPage() * ($categories->currentPage() - 1);?>
              <?php foreach($categories as $key=>$category): ?>
             
           <tr>
              <td><?php echo e(($i+1)); ?></td>
              <td><?php echo e(ucfirst($category->cat_name)); ?></td>
               <td><?php echo e(date_val($category->created_at,DATE_FORMATE )); ?></td>
              <td>
                  <?php if($category->status == 1): ?>
                    <?php echo Html::decode(Html::link(route('admin.category.status_change',['id' => $category->id,'status'=>$category->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])); ?> <br> Active
                    <?php else: ?>
                    <?php echo Html::decode(Html::link(route('admin.category.status_change',['id' => $category->id,'status'=>$category->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])); ?> <br> Inactive
                  <?php endif; ?>
                 
              </td>
              <td>
				  <?php echo Html::decode(Html::link(route('admin.categories.edit', $category->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>				  
                            <?php /*?>{!! Form::model($category, ['method' => 'DELETE', 'url' => '/admin/categories/' . $category->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}<?php */?>
                            <?php echo Html::decode(Html::link(route('admin.subindex', $category->slug),"<i class='fa fa-th'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>'Sub Category'])); ?>

              </td>
           </tr>
           <?php $i++;?>
            <?php endforeach; ?>
             <?php else: ?>

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           <?php endif; ?>

            </tbody>
          </table>
           <?php echo $categories->appends(Input::all('categories'))->render(); ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>