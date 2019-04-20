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
            <h3 class="pull-left">
                    <?php echo Form::open(array('route' => 'admin_user_search', 'class' => 'form', 'novalidate' => 'novalidate')); ?>

							<div class="row">
								<div class="col-lg-12">
									<div style="width:100%;">
										<div style="float:left; width:78%;margin-left: 1%;">
											<?php echo Form::text('search', Input::get('search'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Name, Email, Phone'
											));; ?>

										</div>
                  
										<div style="float:left; width:2%;">
										</div>
										<div style="float:right; width:20%;">
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
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--            <th  width="15%" align="center"><?php echo e(trans('admin.PROFILE_IMAGE')); ?></th>-->
                <th width="5%" align="center">S. No.</th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('first_name', 'Name'));?></th>
              <th width="15%">Profile Image</th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('email', trans('admin.EMAIL')));?></th>
              <th width="15%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('phone', trans('admin.PHONE')));?></th>
              <th width="15%">Address</th>
              <th width="10%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', trans('admin.REGISTERED_ON')));?></th>
<!--              <th width="10%"><?php echo e(trans('admin.STATUS')); ?></th>-->
              <th width="15%" align="center">Action</th>
            </tr>
            </thead>
            <tbody>
              <?php if(!$users->isEmpty()): ?>
              <?php $i = $users->perPage() * ($users->currentPage() - 1);?>
              <?php foreach($users as $user): ?>
              <?php
              $cityName = CommonHelpers::cityName($user->city);
              $stateName = CommonHelpers::stateName($user->state);?>
            
           <tr>
               <td><?php echo e($i+1); ?></td>
              <td><?php echo e(ucfirst($user->first_name.' '.$user->last_name)); ?></td>
             <!-- <td><?php echo e($user->profile_img); ?></td>-->
             <td><img src="<?php echo e(asset('/uploads/user/'.$user->profile_img)); ?>" alt="" style="height:100px;with:100px;"></td>
              <td><?php echo e($user->email); ?></td>
              <td><?php echo e($user->phone); ?></td>
              <td><?php echo e($user->address_1.' '.$user->address_2); ?>

              <?php if(!empty($cityName)): ?>
              , <?php echo e($cityName->city_name); ?>

              <?php endif; ?>
              <?php if(!empty($stateName)): ?>
              , <?php echo e($stateName->state_name); ?>

              <?php endif; ?>
              <?php if(!empty($user->pincode)): ?>
              , <?php echo e($user->pincode); ?>

              <?php endif; ?>
              </td>
              <td><?php echo e(date_val($user->created_at,DATE_FORMATE )); ?></td>
              
              
              <?php /*?><td>
                  @if($user->status == 1)
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!} <br> Active
                  @else
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!} <br> Inactive
                  @endif
              </td><?php */?>
              <td>
			<?php /*?>{!!  Html::decode(Html::link(route('admin.users.edit', $user->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}<?php */?>				  
                            <?php echo Form::model($user, ['method' => 'DELETE', 'url' => '/admin/users/' . $user->id]); ?>

                            <?php echo Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]); ?>

                            <?php echo Form::close(); ?>

              </td>
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