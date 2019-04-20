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
                    <?php echo Form::open(array('route' => 'admin.orders.search', 'class' => 'form', 'novalidate' => 'novalidate')); ?>

							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											<?php echo Form::text('order_no', Input::get('order_no'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Order No., Email, Transaction Id'
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
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center"><?php echo e(trans('admin.PROFILE_IMAGE')); ?></th>-->
              <th width="5%" align="center">S.<br> No.</th>
              <th width="5%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('first_name', 'Customer Detail'));?></th>
              <th width="5%">Transaction Id</th>
              <th width="5%">Order no</th>
              <th width="15%">Shipping <br>Address</th>
<!--              <th width="10%">Shipping <br>Details</th>-->
              <th width="15%">Pay Mode</th>
              <th width="10%">Cart <br> Total</th>
              <th width="5%">Order <br> Status</th>
              <th width="5%">Payment <br> Status</th>
              <th width="5%"><?php echo \Kyslik\ColumnSortable\Sortable::link(array ('created_at', 'Order date'));?></th>
              <th width="10%" align="center">Actions</th>
            </tr>
            </thead>
            <tbody>
              <?php if(isset($orders) && !empty($orders)): ?>
              <?php $i = $orders->perPage() * ($orders->currentPage() - 1);?>
              <?php foreach($orders as $order): ?>
              
            
           <tr>
               <td><?php echo e(($i+1)); ?></td>
              <td>Name : <?php echo e(ucfirst($order->first_name)); ?> <?php echo e(ucfirst($order->last_name)); ?><br>
				  Email : <?php echo e(ucfirst($order->email)); ?><br>
				  Phone : <?php echo e(ucfirst($order->phone)); ?>

              
              </td>
           
              <td><?php echo e($order->txn_id); ?></td>
             <td><?php echo e($order->order_no); ?></td>
             <td><?php echo e($order->address_1); ?>, <?php echo e($order->address_2); ?></td>
             <?php /*?><td>Method: Standard Method<br> 
		Shipping Amount : {{$order->shipping_amount}}</td><?php */?>
              <td><?php echo e($order->pay_mode); ?></td>
              <td><?php echo e($order->item_total_amount); ?></td>
              <td><?php echo e($order->order_status); ?></td>
              <td><?php echo e($order->payment_status); ?></td>
              <td><?php echo e(date_val($order->created_at,DATE_FORMATE )); ?></td>
              <td>
				  <?php echo Html::decode(Html::link(route('admin.view', $order->order_no),"<i class='fa  fa-eye'> View</i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])); ?>				  
                            
              </td>
         <?php $i++;?>
            <?php endforeach; ?>
             <?php else: ?>

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           <?php endif; ?>

            </tbody>
          </table>
           <?php echo $orders->appends(Input::all('page'))->render(); ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>