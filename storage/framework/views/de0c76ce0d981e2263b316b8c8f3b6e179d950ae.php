<?php $__env->startSection('content'); ?>
<style>
   .heading{
   background:#0000002e;	
   }
   
   
   .msg_success{
color:#38B861;
}
.msg_error{
color:#D93025;
}
</style>
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
      <div class="col-md-6">
         <img src="<?php echo e(asset('img/logo.png')); ?>">
      </div>
      <div class="col-md-6 detail">
         <p>Order No. #: <?php echo e($orderDetail->order_no); ?></p>
         <p>Transaction id. #: <?php echo e($paymentss->txn_id); ?></p>
         <p>Created : <?php echo e($orderDetail->created_at); ?></p>
         <p>Order Status : <button class="btn btn-warning"><?php echo e($orderDetail->order_status); ?></button> </p>
         <p>Payment Status : <button class="btn btn-warning"><?php echo e($orderDetail->payment_status); ?> </button> </p>
         
      </div>
   </div>
   <!-- /.box-header -->
   <div class="box-header with-border">
      <div class="col-md-6">
         <p><b>Name</b> : <?php echo e($orderDetail->first_name); ?> <?php echo e($orderDetail->last_name); ?></p>
         <p><b>Address</b> :<?php echo e($orderDetail->address_1); ?></p>
         <?php if(!empty($orderDetail->address_2)): ?>
         <p><?php echo e($orderDetail->address_2); ?></p>
         <?php endif; ?>
         <?php if(!empty($city_name)): ?>
        <p><b>City</b> :  <?php echo e($city_name->city_name); ?></p>
         <?php endif; ?>
         <?php if(!empty($state_name)): ?>
          <p><b>State</b> : <?php echo e($state_name->state_name); ?></p>
         <?php endif; ?>
         <p><b>Pincode</b> : <?php echo e($orderDetail->pincode); ?> </p>
         <p><b>Phone</b> : <?php echo e($orderDetail->phone); ?> </p>
         <p><b>Email</b> : <?php echo e($orderDetail->email); ?> </p>
         
      </div>
      <div class="col-md-6">
         Out Sole
      </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
      <table id="example1" class="table table-bordered table-striped" style="width:100%">
         <thead>
            <tr class="heading">
               <th width="5%" >S.No.</th>
               <th width="20%" >Items</th>
               <th width="20%" >Color</th>
               <th width="20%" >Size</th>
               <th width="15%" >Quantity</th>
               <th width="15%" align="right">Price</th>
               <th width="15%" align="right">Total Price</th>
            </tr>
         </thead>
         <tbody>
            <?php if(isset($orderProducts) && !empty($orderProducts)): ?> 
            <?$i=0;?>
            <?php foreach($orderProducts as $key=>$orderProduct): ?>
            <?php $SizeLists = CommonHelpers::getSize($orderProduct->size_id);
                  $colorLists = CommonHelpers::getColor($orderProduct->color_id);?>
            <tr>
               <td><?php echo e($i+1); ?></td>
               <td><?php echo e($orderProduct->product_name); ?></td>
               <td><?php echo e($colorLists['0']['color_name']); ?></td>
               <td><?php echo e($SizeLists['0']['size']); ?></td>
               <td><?php echo e($orderProduct->quantity); ?></td>
               <td align="right"><?php echo e($orderProduct->unit_price); ?></td>
               <td align="right"><?php echo e($orderProduct->unit_price*$orderProduct->quantity); ?></td>
            </tr>
            <?$i++;?>
            <?php endforeach; ?>
            
             <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="right"><b>Shipping (Standars Shipping):<?php echo e($orderDetail->shipping_amount); ?></b></td>
            </tr>
            
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="right"><b>Total:<?php echo e($orderDetail->shipping_amount+$orderDetail->item_total_amount); ?></b></td>
            </tr>
            
            <?php else: ?>
            <tr>
               <td colspan="4" align="center">No Record Found</td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
		<div>
			<span class="msg_success">
			<?php if(Session::has('alert-sucess')): ?>
			<?php echo Session::get('alert-sucess'); ?>

			<?php endif; ?>
			</span>
			<span class="msg_error">
			<?php if(Session::has('alert-error')): ?>
			<?php echo Session::get('alert-error'); ?>

			<?php endif; ?>
			</span>
		</div>
      
      
      <?php echo Form::model($orderDetail,['route'=>['orders.update',$orderDetail->id],'files'=>true]); ?>

      <div class="box-body">
		  <div class="row">
                    <div class="col-md-1">
                        <div class="form-group ">
                           <?php echo Form::label('Status',null,['class'=>'required_label']); ?>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
							 <?php $order_status_list = Config::get('global.order_status_list'); ?>
                                <?php echo Form::select('order_status', $order_status_list, null, ['class' => 'form-control select2 autocomplete']); ?>

                          </div>
                          <input type="hidden" name="order_id" value="<?php echo e($orderDetail->id); ?>">
                    </div>
                    
                    <div class="col-md-4">
						<div class="">
							<?php echo Form::submit('Save',['class' => 'btn btn-info ']); ?>

<!--							<?php echo Form::reset('Back',['class' => 'btn btn-warning ']); ?> -->
							
						</div>
                    </div>
                    
                </div>
      </div>
      <?php echo Form::close(); ?>

      
      
</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<!-- /.content-wrapper -->

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>