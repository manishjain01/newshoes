@extends('layouts.inner')
@section('content')  


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

<section class="dash_user ">
<!--         <div class="container-fluid">
            <img src="{{asset('img/banner.png')}}">
         </div>-->
         <div class="container">
         <div class="row">
       
            <div class="col-md-9 order_mng1">
               <h4>Order Managment</h4>
               @if(!$orderLists->isEmpty())
               @foreach($orderLists as $orderList)
               <?php  $orders = CommonHelpers::user_orders($orderList->id);?>
               
               @foreach($orders as $key=>$order)
               <?php //pr($order);exit;?>
               <div class="col-md-12 div_show">
                  <img src="{{PRODUCT_IMAGE_URL.$order->image_name}}">
                  <h3>Order ID &nbsp;&nbsp;<b>#{{$order->order_no}}</b> <span class="date_productss">Date {{date('j F, Y', strtotime($order->created_at))}}</span></h3>
                  <h3 class="pr_nm">Name &nbsp;&nbsp;<b>{{$order->product_name}}</b><span class="date_productss1">Gross Amount <b>Rs. {{($order->discount*$order->quantity)+($order->unit_price*$order->quantity)}}</b></span><span class="date_productss1">Discount <b>Rs. {{$order->discount*$order->quantity}}</b></span><span class="date_productss1">Amount <b>Rs. {{$order->unit_price*$order->quantity}}</b></span></h3>
                  <p><b>Size</b>&nbsp;&nbsp;&nbsp;&nbsp; {{$order->size}}&nbsp;&nbsp;  |  <b>&nbsp;&nbsp;&nbsp;&nbsp;Qty</b>&nbsp;&nbsp; {{$order->quantity}}</p>
<!--                  <p class="stts">Status</p>
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
                  </div>-->
<!--                  <p class="view_ordr"><a href="javascript::void(0);">View Order</a></p>-->
               </div>
               @endforeach
               <div class="col-md-12" style="text-align: center;">
                   <p><strong style="color:#489a11">Summary:</strong>&nbsp;&nbsp;&nbsp;&nbsp;Total Amount:&nbsp;&nbsp; <strong>{{$orderList->item_total_amount}}</strong>
                   &nbsp;&nbsp;&nbsp;&nbsp;Shipping Charge:&nbsp;&nbsp;<strong>{{$orderList->shipping_amount}}</strong>
                 &nbsp;&nbsp;&nbsp;&nbsp;Amount Paid:&nbsp;&nbsp;<strong>{{($orderList->shipping_amount)+($orderList->item_total_amount)}}</strong></p>
               </div>
               <span style="border-bottom: 2px dotted #adadad; padding:5px; color:#fff; margin-bottom: 18px; line-height: 0; display: block;">.</span>
               @endforeach
               <div class="col-md-12 pg_ni order_listings">
                     
                   <ul>
               {!! $orderLists->appends(Input::all('page'))->render() !!}
                   </ul>
               </div>
               @else
               
               <div>Order Not Found.</div>
               @endif
               
               
               
            </div>
         </div>
      </section>
@stop
