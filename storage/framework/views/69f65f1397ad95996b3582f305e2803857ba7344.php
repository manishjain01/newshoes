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
  
      <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <div class="tab-content col-md-12">
    <div id="account_info" class="tab-pane fade in active">
     
<form action="/action_page.php" id="panel_address" style="display: block;">
    <div class="form-group  col-md-12">

      <input type="text" class="form-control" id="email" placeholder="First Name" name="email">
    </div>
    <div class="form-group  col-md-12">

      <input type="text" class="form-control" id="pwd" placeholder="Last Name" name="pwd">
    </div>
   


<div class="form-group col-md-12">

      <input type="email" class="form-control" id="email" placeholder="Email ID" name="email">
    </div>
<div class="form-group  col-md-12">

      <input type="text" class="form-control" id="email" placeholder="Contact No." name="email">
    </div>
<div class="col-md-4"></div>
<div class="form-group  col-md-4">

    <button type="submit" class="btn btn-default">Submit</button>
 </div>
  </form>


    </div>
    <div id="addres" class="tab-pane fade">
      <form action="/action_page.php" id="panel_address" style="display: block;">
    <div class="form-group col-md-12">
     
      <textarea class="form-control frm_area" rows="5" id="comment" placeholder="Shipping Address"></textarea>
    </div>
    <div class="form-group col-md-12">
     
      <textarea class="form-control frm_area" rows="5" id="comment" placeholder="Billing Address"></textarea>
    </div>


    <div class="form-group col-md-12">

      <input type="text" class="form-control" id="email" placeholder="Location *" name="email">
    </div>
    <div class="form-group col-md-12">

      <input type="text" class="form-control" id="pwd" placeholder="Province *" name="pwd">
    </div>
   


<div class="form-group col-md-12">

      <input type="text" class="form-control" id="email" placeholder="State *" name="email">
    </div>
<div class="form-group col-md-12">

      <input type="text" class="form-control" id="email" placeholder="Country *" name="email">
    </div>


<div class="col-md-4"></div>
<div class="col-md-4">
    <button type="submit" class="btn btn-default">Submit</button>
 </div>
  </form>
    </div>
    <div id="chng_pass" class="tab-pane fade">
      <form action="/action_page.php" id="panel_address" style="display: block;">

    <div class="form-group col-md-12">

      <input type="text" class="form-control" id="email" placeholder="Old Password" name="email">
    </div>
    <div class="form-group col-md-12"">

      <input type="text" class="form-control" id="pwd" placeholder="New Password" name="pwd">
    </div>
   


<div class="form-group col-md-12"">

      <input type="text" class="form-control" id="email" placeholder="Confirm New Password" name="email">
    </div>
    <div class="col-md-2"></div>
    
<div class="form-group btn_chng1 col-md-4">
    <button type="submit" class="btn btn-default chng_p">Cancel</button>
  </div>
  <div class="form-group  col-md-4">
    <button type="submit" class="btn btn-default">Save</button>
  </div>
  </form>
    </div>
    <div id="order_m" class="tab-pane fade">
      <div class="col-md-12 order_mm">
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
      </div>
<div class="col-md-12 orders">
   <div class="col-md-2">
  <a href="#"> <img src="img/3.png"></a>    
   </div>
   <div class="col-md-7">
  <h3>Order ID <span>#1235844</span></h3>
    <p>Name &nbsp;&nbsp;<span><a href="#">Dany Roy</a></span></p>
    <p class="size">Size <span>4</span> &nbsp;&nbsp;| &nbsp;&nbsp;Qty <span>1</span></p>    
   </div>
   <div class="col-md-3">
      <p>Date 20 Feb 2018</p>
        <p>Amount <span>&nbsp;&nbsp;Rs. 20555</span></p>
   </div>
 <div class="col-md-12"> 
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
</div>
</div>



    </div>
     <div id="wish_l" class="tab-pane fade">
 <div class="col-md-12 div_show_wish">
   <div class="col-md-2">
 <a href="#"> <img src="img/3.png"></a>
</div>
<div class="col-md-10"><h3><a href="#">Print Dress Floral Print Dress</a></h3><a href="#" class="right_rmv">Remove</a>
  <span>Floral Print Dress</span>
  <p><i class="fa fa-inr" aria-hidden="true"></i> 2,200 <span><i class="fa fa-inr" aria-hidden="true"></i> 3,200</span></p>

<form id="panel_address" style="display: block;">
 
    <div class="form-group order_frm_slct col-md-4">

     <select>
  <option value="volvo">Select Size</option>
  <option value="saab">Saab</option>
  <option value="opel">Opel</option>
  <option value="audi">Audi</option>
</select>
 </div>
  <div class="form-group col-md-4 order_frm_slct" >   

 <button type="submit" class="btn btn-default">ADD TO BAG</button>
  </div>
  </form>

</div>



</div>
    </div>
  </div>
</div>
</section>
     
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>