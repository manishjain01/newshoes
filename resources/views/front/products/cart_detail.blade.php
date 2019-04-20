@extends('layouts.inner') 
@section('content')
<section class="cart_page">
         <div class="container">
            <div class="row">
               <h2 class="heading_page heading_cart">Shopping Cart</h2>
            </div>
         </div>
     <?php $total = 0;
                         $discount_price = 0;
                         $grand_total = 0;
                         $stock = "1";?>
                   @if(!$cart_details->isEmpty())
         <div class="container">
            <div class="row product_tbl block animatable bounceInLeft">
                <form>
               <table>
                  <tr>
                     <th>Product</th>
                     <th></th>
                     <th>Unit Price</th>
                     <th>Discount</th>
                     <th>Size & Color</th>
                     <th>Quantity</th>
                     <th>Total</th>
                     <th>Stock</th>
                  </tr>
                  @foreach($cart_details as $cart_detail)
                   <?php 
                    $total = $total + $cart_detail->price*$cart_detail->qty;
                    $discount_price = $discount_price + $cart_detail->discount*$cart_detail->qty;
                    $grand_total = $total + Configure('CONFIG_SHIPPING_AMOUNT');                  
                   ?>
                  <tr>
                      <?php 
                        $sizeLists = CommonHelpers::getsizeProductList($cart_detail->product_id,$cart_detail->color_id);
                        $colorLists = CommonHelpers::getProductColor($cart_detail->color_id);                    
                    ?>
                     <td class="img_p"><a href="">
                      <?php $productsImage = CommonHelpers::getProductImage($cart_detail->product_id, $cart_detail->color_id); //pr($productsImage);exit;?>
                     @if(!empty($productsImage))
                      <img src="{{PRODUCT_IMAGE_URL.$productsImage['0']['image_name']}}">
                      @else
                      <img src="{{asset('img/no-image.png')}}">
                      @endif
<!--                             <img src="img/1.png">-->
                         </a></td>
                     <td class="title_p">
                        <h3>{{ ucfirst($cart_detail->product_name) }}</h3>
                     </td>
                     <td class="price_p"><i class="fa fa-inr" aria-hidden="true"></i>                        
                         {{ number_format($cart_detail->price*$cart_detail->qty+$cart_detail->discount*$cart_detail->qty,2) }}                        
                         &nbsp;&nbsp;
                                                
                     </td>
                     <td class="price_p">
                     @if(isset($cart_detail->discount) && !empty($cart_detail->discount) && $cart_detail->discount != 0.00)
                         <i class="fa fa-inr" aria-hidden="true"></i> <span>{{ number_format($cart_detail->discount*$cart_detail->qty,2) }} </span>                         
                         @else
                         0
                         @endif  
                     </td>
                     <td class="color_p">
                          <input type="hidden" value="{{$cart_detail->id}}" class="cartIds" />
                        <p>
                            {!! Form::select('size_id', $sizeLists, $cart_detail->size_id, ['id'=>'size_ids','class' => '','datas' =>$cart_detail->id]) !!}
<!--                            <a href="#">9</a>-->
                            <a href="#">
                                <span class="gola" style="background: {{ $colorLists->color_picker }};"></span>
<!--                                <span></span>-->
                            </a></p>
                     </td>
                     <td class="input_p">
                         {!! Form::select('qty', $qtyList, $cart_detail->qty, ['id'=>'qty_cart','class' => '',
                       'datas_qty' =>$cart_detail->id,'datas_pro' =>$cart_detail->product_id,'datas_size' =>$cart_detail->size_id,'datas_color' =>$cart_detail->color_id]) !!}
                       <span class="cart_message{{$cart_detail->id}} error"></span>
<!--                        <p> <input type="number" name="quantity" min="1" max="5" placeholder="1"></p>-->
                     </td>
                     <td class="totl_p"><i class="fa fa-inr" aria-hidden="true"></i> {{ number_format($cart_detail->price*$cart_detail->qty,2) }}  
<!--                         <a href="#" class="remov">X</a>-->
                         
                     </td>
                     
                         
                     <td class="remove_tdd"> 
                      <a href="javascript::void(0);" class="remov remove" id="remove_id" data-id = "{{ $cart_detail->id }}">Remove</a>

                        <?php                      
                     $check_cart_stock = CommonHelpers::check_cart_stock($cart_detail->product_id, $cart_detail->color_id, $cart_detail->size_id, $cart_detail->qty);?>
                     @if($check_cart_stock == 0)
                     <?php $stock = "0";?>
                     <p>Out of stock</p>
                     @else
                     <p>in stock</p>
                     @endif
                        </td>  
                      
                  </tr>
                  @endforeach
               </table>
                </form>
            </div>
            <div class="row shopping_row">
               <div class="col-md-3 block animatable bounceInLeft">
                  <a href="{{ URL::to('/') }}" class="btn_continue"><span>Continue Shopping</span></a>
               </div>
               <div class="col-md-3"></div>
               <div class="col-md-3 block animatable bounceInRight"> 
                   <a href="javascript::void(0);" class="btn_continue" id="remove_all" datas-id = "removecart">
                      <span>Clear Cart</span> 
                   </a>
<!--                   <a href="#" class="btn_continue"><span>Clear Cart</span></a>-->
               </div>
<!--               <div class="col-md-3 block animatable bounceInRight">
                   <a href="#" class="btn_continue1">
                       <span>Update Cart</span>
                   </a>
               </div>-->
            </div>
            <div class="row totl_dlt ">
               <div class="col-md-6"></div>
               <div class="col-md-6">
                  <table class="block animatable moveUp">
                      
                     <tr>
                        <td class="">Product total Price</td>
                        <td class="">Rs. {{ number_format($total+$discount_price,2) }}</td>
                     </tr>
                      
                     
                     @if(isset($discount_price) && !empty($discount_price) && $discount_price != 0.00)
                     <tr>
                        <td class="">Discount</td>
                        <td class="">Rs. {{ number_format($discount_price,2) }}</td>
                     </tr>
                      @endif
                       
                     <tr>
                        <td class="">Shipping</td>
                        @if($grand_total != '0')
                        <td class="">Rs. <?php echo number_format(Configure('CONFIG_SHIPPING_AMOUNT'),2); ?></td>
                         @else
                         <td class="">Rs. 0</td>
                          @endif
                     </tr>
                     <tr class="total">
                        <td class="">Total</td>
                        <td class="">Rs. {{ number_format($grand_total,2) }}</td>
                     </tr>
                  </table>
                   @if(Auth::check())
                   <a  <?php if($stock == 0){?>href="javascript:void(0)" onclick="alert('This product quantity not available in stock')"<?php }else{?> href="{{ URL::to('checkout') }}" <?php }?> id="checkout_cart" class="btn_continue1 btn_continue3 block animatable bounceInLeft">
                            <span>Proceed to Chekcout</span>
                        </a>
                     @else
                     <a href="javascript::void(0)" data-toggle="modal" data-target="#myModal" class="btn_continue1 btn_continue3 block animatable bounceInLeft login_wishlist">
                         <span>Proceed to Chekcout</span>
                     </a>
                     <br /><br /><br />
                     <a <?php if($stock == 0){?>href="javascript:void(0)" onclick="alert('This product quantity not available in stock')"<?php }else{?>href="{{ URL::to('guest_checkout') }}"<?php }?>  id="checkout_cart" class="btn_continue1 btn_continue3 block animatable bounceInLeft">Continue as a guest</a>
                     @endif
                     
<!--                  <a href="#" class="btn_continue1 btn_continue3 block animatable bounceInLeft">
                      <span>Proced to Checkout</span>
                  </a>-->
               </div>
            </div>
         </div>
                   @else
            <div class="no-cart">
                <h2>YOUR SHOPPING BAG IS EMPTY</h2>
                <h6>Don't let it stay empty. Add items from your cart</h6>
            </div>
@endif
</section>


<script>
    $(document).on("click", "#remove_id", function () {
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        cartId = $(this).attr("data-id");
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/cartDetail',
            cache: false,
            data: {
                cartId: cartId
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

    });
    
    
    $(document).on("click", "#remove_all", function () {
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        cartId = $(this).attr("datas-id");
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/cartDetail',
            cache: false,
            data: {
                cartremove: cartId
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

    });
    
    $(document.body).on('change',"#size_ids",function (e) {       
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
         var optVal= $(this).val();
         var cartIds = $(this).attr("datas");         
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/cartDetail',
            cache: false,
            data: {
                size_id: optVal,
                cartIds: cartIds
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                if(msg1.message == "Successfully"){ console.log(121);
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

});
   
  $(document.body).on('change',"#qty_cart",function (e) {       
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
         var optVal= $(this).val();
         var cartIds = $(this).attr("datas_qty"); 
         var product_id = $(this).attr("datas_pro");
         var size_id = $(this).attr("datas_size");
         var color_id = $(this).attr("datas_color");
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/cartDetail',
            cache: false,
            data: {
                qty_id: optVal,
                qcartIds: cartIds,
                product_id: product_id,
                sizeId: size_id,
                color_id: color_id
            },
            success: function (msg) {
                msg1 = JSON.parse(msg);
                console.log(msg1);
                console.log(msg1.message);
                $('.cart_message'+cartIds).html(msg1.message);
                $('#checkout_cart').attr('href', 'javascript:void(0)');
                $('#checkout_cart').attr('onclick', "alert('This product quantity not available in stock')");
                if(msg1.message == "Successfully"){ 
                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
                 }
            },
            error: function (data) {
            }
        });
        return false;

});
 
 
 
</script>
@stop
