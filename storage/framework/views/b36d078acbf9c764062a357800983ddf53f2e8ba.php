<?php $__env->startSection('content'); ?>
<style>
    .cut_btn{
    float: left;
    margin-right: 1px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        <?php /* ?>{!!  Html::decode(Html::link(route('admin.advertisement.create'),"<i class='fa  fa-plus'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('Add')])) !!}<?php */ ?>			  

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
            <h3 class="pull-left">
                    <?php echo Form::open(array('route' => 'admin.products_search', 'class' => 'form', 'novalidate' => 'novalidate')); ?>

							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											<?php echo Form::text('product_title', Input::get('product_title'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Product Title, Price, Code, Category, Sub Category'
											));; ?>

										</div>                  
										<div style="float:left; width:0%;">
										</div>
										<div style="float:right; width:0%;">
											<?php echo Form::button('<i class="glyphicon glyphicon-search"></i>', array('type' => 'submit', 'class' => 'btn btn-success')); ?>

										</div>
									</div>
								</div>
							</div>
						<?php echo Form::close(); ?>

                </h3>
            <?php /* ?><h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.users.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
            </h3><?php */ ?>
        </div>
                    <h3 class="pull-right">  
                        <?php echo Html::decode(Html::link(route('admin.products.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])); ?>

                    </h3>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th width="5%">S.No</th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('title', 'Product Title'));?></th>
                                    <th width="5%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('cat_name', 'Category Name'));?></th>
                                    <th width="5%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('cat_name', 'Sub Category Name'));?></th>
                                    <th  width="5%" align="center"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('price', 'Price'));?></th>
                                    <th  width="5%" align="center"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('discount', 'Discount'));?></th>                                   
                                    <th  width="10%" align="center"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('product_code', 'Product Code'));?></th>
                                     <th  width="15%" align="center">Product Color</th>
                                    <th  width="5%" align="center">Product Size</th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at','Date'));?></th>
                                     <th width="5%"><?php echo e(trans('admin.STATUS')); ?></th>
                                    <th width="25%" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$prodcuts->isEmpty()): ?>
                                 <?php $i = $prodcuts->perPage() * ($prodcuts->currentPage() - 1);?>
                                <?php foreach($prodcuts as $key=>$prodcut): ?>

                                <tr>
                                    <td><?php echo e(($i+1)); ?></td>
                                    <td><?php echo e(ucfirst($prodcut->product_title)); ?></td>
                                    <td><?php echo e(ucfirst($prodcut->product_category->cat_name)); ?></td>
                                    <td><?php echo e(ucfirst($prodcut->product_subcategory->cat_name)); ?></td>
                                    <td><?php echo e($prodcut->price); ?></td>
                                    <td>
                                        <?php if(!empty($prodcut->discount)): ?>
                                        <?php echo e($prodcut->discount); ?> %
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($prodcut->product_code); ?></td>
                                    <td>
                                        <?php $sizes = array();?>
                                        
                                        <?php foreach($prodcut->product_color as $productsa): ?>
                                         <?php $size = CommonHelpers::getSize($productsa->size_id); 
                                         if(!empty($size)){
                                         $sizes[] = $size['0']['size'];
                                         }
                                         //$colorName[] = $productsa->colors->color_name;
                                         ?>
                                       
                                        <?php echo e($productsa->colors->color_name); ?>,
                                        
                                        <?php endforeach; ?>
                                        
                                    </td>
                                    <td>
                                         <?php echo e(implode(", ", $sizes)); ?>

                                    </td>
                                    
                                    <td><?php echo e(date_val($prodcut->created_at,DATE_FORMATE )); ?></td>
                                    <td>
                                        <?php if($prodcut->status == 1): ?>
                                          <?php echo Html::decode(Html::link(route('admin.products.status_change',['id' => $prodcut->id,'status'=>$prodcut->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])); ?> <br> Active
                                        <?php else: ?>
                                          <?php echo Html::decode(Html::link(route('admin.products.status_change',['id' => $prodcut->id,'status'=>$prodcut->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])); ?> <br> Inactive
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo Html::decode(Html::link(route('admin.products.edit', $prodcut->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>

                                        <?php echo Html::decode(Html::link(route('web.addimage', $prodcut->id),"<i class='fa  fa-image'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>'Image Upload'])); ?>

                                        
                                        <div class="cut_btn">
                                        <?php echo Form::model($prodcut, ['method' => 'DELETE', 'url' => '/admin/products/' . $prodcut->id]); ?>

                                        <?php echo Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]); ?>

                                        <?php echo Form::close(); ?>

                                        </div>
                                    </td>
                                </tr>
                                        <?php $i++;?>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    
                                <tr>
                                    <td colspan="10">
                                        <div class="data_not_found"> 
                                            Data Not Found 
                                        </div>
                                    </td>
                                </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                        <?php echo $prodcuts->appends(Input::all('products'))->render(); ?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>