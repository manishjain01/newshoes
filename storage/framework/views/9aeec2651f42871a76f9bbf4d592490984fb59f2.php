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
                    <?php echo Form::open(array('route' => 'admin.banner_search', 'class' => 'form', 'novalidate' => 'novalidate')); ?>

							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											<?php echo Form::text('title', Input::get('title'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Banner Title'
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
                    <?php /*?><h3 class="pull-right">  
                        {!!  Html::decode(Html::link(route('admin.banner.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
                    </h3><?php */?>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th width="5%">S.No</th>
                                    <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('title', 'Banner Title'));?></th>
                                    <th width="15%">Banner Image</th>
                                    <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at','Date'));?></th>
                                    <th width="15%" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$banners->isEmpty()): ?>
                                 <?php $i = $banners->perPage() * ($banners->currentPage() - 1);?>
                                <?php foreach($banners as $key=>$banner): ?>

                                <tr>
                                    <td><?php echo e(($i+1)); ?></td>
                                    <td><?php echo e(ucfirst($banner->title)); ?></td>
                                    <td><img class="image1" src="<?php echo e(BANNER_IMAGE_URL.$banner->image); ?>"  width="80"/></td>
                                    
                                   
                                   
                                  
                                   
                                    <td><?php echo e(date_val($banner->created_at,DATE_FORMATE )); ?></td>
                                    <td>
                                        <?php echo Html::decode(Html::link(route('admin.banner.edit', $banner->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>

                                        <?php /*?><div class="cut_btn">
                                        {!! Form::model($banner, ['method' => 'DELETE', 'url' => '/admin/banner/' . $banner->id]) !!}
                                        {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                                        {!! Form::close() !!}
                                        </div><?php */?>
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
                        <?php echo $banners->appends(Input::all('banner'))->render(); ?>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>