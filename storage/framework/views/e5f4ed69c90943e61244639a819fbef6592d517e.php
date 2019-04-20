<?php $__env->startSection('content'); ?>  

 
<section class="banner_dash">
   <div class="container-fluid">
      <div class="col-md-6"></div>
      <div class="col-md-6">
         <h2 class="heading_page dsh_hrading">My Dashboard</h2>
      </div>
   </div>
</section>

<section class="dash_tab">
   <div class="container">
      <span class="msg1" style="color:#38B861;">
      <?php if(Session::has('alert-sucess')): ?>
      <?php echo Session::get('alert-sucess'); ?>

      <?php endif; ?>
      <?php if(Session::has('alert-error')): ?>
      <?php echo Session::get('alert-error'); ?>

      <?php endif; ?>
      </span>
      <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      
      <div id="order_m" class="tab-pane fade">
<!--          <div class="col-md-12 order_mm">
              <form id="panel_address" style="display: block;">
                  <div class="col-md-8"></div>
                  <div class="form-group order_frm_slct col-md-4">

                      <select>
                          <option value="volvo">All</option>
                          <option value="saab">Your Order</option>
                          <option value="opel">Return Order</option>

                      </select>
                  </div>

              </form>
          </div>-->
                <?php if(!$orderLists->isEmpty()): ?>
               <?php foreach($orderLists as $orderList): ?>
               <?php  $orders = CommonHelpers::user_orders($orderList->id);?>
               <?php foreach($orders as $key=>$order): ?>

          <div class="col-md-12 orders">
              <div class="col-md-2">
                  <a href="#"> <img src="<?php echo e(PRODUCT_IMAGE_URL.$order->image_name); ?>"></a>    
              </div>
              <div class="col-md-7">
                  <h3>Order ID <span>#<?php echo e($order->order_no); ?></span></h3>
                  <p>Product Name &nbsp;&nbsp;<span><a href="#"><?php echo e($order->product_name); ?></a></span>
                  </p>
                  <p class="size">Size <span><?php echo e($order->size); ?></span> &nbsp;&nbsp;| &nbsp;&nbsp;Qty <span><?php echo e($order->quantity); ?></span></p>
                  <p>
                  <span>Gross Amount <b>Rs. <?php echo e(($order->discount*$order->quantity)+($order->unit_price*$order->quantity)); ?></b></span>
                  <span class="date_productss1">Discount <b>Rs. <?php echo e($order->discount*$order->quantity); ?></b>
                  </span>
                  <span class="date_productss1">Amount <b>Rs. <?php echo e($order->unit_price*$order->quantity); ?></b></span>
                  </p>
                      
              </div>
              <div class="col-md-3">
                  <p>Date <?php echo e(date('j F, Y', strtotime($order->created_at))); ?></p>
<!--                  <p>Amount <span>&nbsp;&nbsp;Rs. <?php echo e(($order->discount*$order->quantity)+($order->unit_price*$order->quantity)); ?></span></p>-->
              </div>
<!--              <div class="col-md-12"> 
                  <h3 class="sttss">Status</h3> 
                  <div class="wrapper1 col-md-12">

                      <div class="dot one"></div>
                      <div class="dot two"></div>
                      <div class="dot three"></div>
                      <div class="dot four"></div>
                      <div class="dot five"></div>
                      <div class="progress-bar first"></div>
                      <div class="message message-1">Pending</div>
                      <div class="message message-2">In Process</div>
                      <div class="message message-3">Shiped</div>
                      <div class="message message-4">Delivered</div>
                      <div class="message message-5">Cancelled</div>


                  </div>
              </div>-->
          </div>
               <?php endforeach; ?>
               <div class="col-md-12" style="text-align: center; font-size: 14px; ">
                   <p style="padding-top: 10px;"><strong style="color:#489a11; ">Summary:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Total Amount:&nbsp;&nbsp; <strong><?php echo e($orderList->item_total_amount); ?></strong>
                   &nbsp;&nbsp;&nbsp;&nbsp;Shipping Charge:&nbsp;&nbsp;<strong><?php echo e($orderList->shipping_amount); ?></strong>
                 &nbsp;&nbsp;&nbsp;&nbsp;Amount Paid:&nbsp;&nbsp;<strong><?php echo e(($orderList->shipping_amount)+($orderList->item_total_amount)); ?></strong>
                   &nbsp;&nbsp;&nbsp;&nbsp;Payment Status:&nbsp;&nbsp;<strong><?php echo e($orderList->payment_status); ?></strong></p>
               </div>
               <span style="border-bottom: 2px dotted #adadad; padding:5px; color:#fff; margin-bottom: 18px; line-height: 0; display: block;">.</span>
               <?php endforeach; ?>
               <div class="col-md-12 pg_ni order_listings">
                     
                   <ul>
               <?php echo $orderLists->appends(Input::all('page'))->render(); ?>

                   </ul>
               </div>
               <?php else: ?>
               <br />
               <h2>Order Not Found.</h2>
               <?php endif; ?>



      </div>
      
      
      
   </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>