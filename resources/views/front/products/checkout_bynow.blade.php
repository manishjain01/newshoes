@extends('layouts.inner') 
@section('content')
<style type="text/css">
    .context-menu {cursor: context-menu;}

    a[disabled="disabled"] {
        pointer-events: none;
    }
</style>

<section class="check_out">
    <div class="container"> 

        <div class="row check_out1" >
            <div class="col-md-12">  
                <h3 class="add_heading block animatable moveUp"><span class="one" style="color: #222;">Address</span> <span class="two">----- Summary</span> <span class="three">----- Payment </span></h3></div>

            <div class="col-md-12 btm_dvv">  
                <?php //pr($deliver_city_name);
               if(empty($users[0]->first_name) || empty($users[0]->last_name) ||empty($users[0]->email) ||empty($users[0]->address_1) || empty($users[0]->phone) || empty($deliver_city_name->city_name) || empty($deliver_state_name->state_name) || empty($users[0]->pincode)){
                   $isdisabled = "1"; 
               }else{
                    $isdisabled = "0";
               }
                ?>
                <div class="col-md-12 address_showw block animatable bounceInLeft">
                    <div class="col-md-6">
                        <h3>Select Delivery Address</h3>
                    </div> 
                    <div class="col-md-6">
                        <a href="{{URL::to('delivery_address',$order_no)}}/ByNow" <?php  if(isset($isdisabled) && $isdisabled != 1){?>disabled="disabled" style="display:none;"<?php }?>>
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Address</a>
                    </div>  
                </div>
                <form method="post" id="address_form">
                <div class="col-md-12 min_er">
                    <div class="success-msg2 error"></div>
                    <div class="col-md-6 address_boxx block animatable bounceInRight">
                        <h1>Account Address:</h1><br />
                        <h4>{{ucfirst($auth->first_name).' '.ucfirst($auth->last_name)}}</h4> 
                        <p>Email:- {{$auth->email}}</p>
                        @if(!empty($auth->phone))
                        <p>Phone:- {{$auth->phone}}</p>
                        @endif
                        @if(!empty($auth->address_1))
                        <p>Address:- {{$auth->address_1}}</p>
                        @endif
                        @if(!empty($auth->address_2))
                        <p>{{$auth->address_2}},</p>
                        @endif                   
                        @if(!empty($city_name))
                        <p>City:- {{$city_name->city_name}},</p>
                        @endif
                        @if(!empty($state_name))
                        <p>State:- {{$state_name->state_name}}</p>
                        @endif
                        @if(!empty($users[0]->pincode))
                        <p>Pincode:- {{$auth->pincode}}</p>
                        @endif
     <!--                <p>Jaipur &nbsp;&nbsp;&nbsp; 335012</p>
                     <p>Mobile &nbsp;&nbsp;&nbsp; 9857421245</p>-->
                        <div class="col-md-12 edit_radooo">
                        <a href="{{URL::to('edit_address',$order_no)}}/ByNow">Edit</a>
                        <input type="radio" name="type_address" class="type_add" value="1">
                        </div>
                    </div>
                    
                    <div class="col-md-6 address_boxx block animatable bounceInRight" <?php  if(isset($isdisabled) && $isdisabled == 1){?>disabled="disabled" style="display:none;"<?php }?>> 
                        <h1>Shipping Address:</h1><br />
                        <h4>{{ucfirst($users[0]->first_name).' '.ucfirst($users[0]->last_name)}}</h4> 
                        @if(!empty($users[0]->email))
                        <p>Email:- {{$users[0]->email}}</p>
                        @endif
                        @if(!empty($users[0]->phone))
                        <p>Phone:- {{$users[0]->phone}}</p>
                        @endif
                        @if(!empty($users[0]->address_1))
                        <p>Address:- {{$users[0]->address_1}}</p>
                        @endif
                        @if(!empty($users[0]->address_2))
                        <p>{{$users[0]->address_2}},</p>
                        @endif                   
                        @if(!empty($deliver_city_name))
                        <p>City:- {{$deliver_city_name->city_name}},</p>
                        @endif
                        @if(!empty($deliver_state_name))
                        <p>State:- {{$deliver_state_name->state_name}}</p>
                        @endif
                        @if(!empty($users[0]->pincode))
                        <p>Pincode:- {{$users[0]->pincode}}</p>
                        @endif
     <!--                <p>Jaipur &nbsp;&nbsp;&nbsp; 335012</p>
                     <p>Mobile &nbsp;&nbsp;&nbsp; 9857421245</p>-->
                        <div class="col-md-12 edit_radooo">
                        <a href="{{URL::to('delivery_address',$order_no)}}/ByNow" >Edit</a>
                         <input type="radio" name="type_address" class="type_add" value="2">
                         </div>
                    </div>
                </div>
                <div class="col-md-12 conti_n block animatable moveUp">
                    <a href="javascript:void(0);" id="show1">Continue</a>
                </div>
                    </form>
            </div>
        </div>

        <!-----onerow--->
        <div class="row check_out2" style="display: none;">
            <div class="col-md-12">  
                <h3 class="add_heading block animatable moveUp"><span class="one">Address</span> <span class="two" style="color: #222;">----- Summary</span> <span class="three">----- Payment </span></h3></div>

            <div class="col-md-12 btm_dvv">  
                <div class="col-md-12 address_showw block animatable bounceInLeft">
                    <div class="col-md-12">
                        <h3>Checkout Summary</h3>

                    </div>
                </div>
                <div class="col-md-12 min_er">
                    <div class="col-md-8 sumy_showw block animatable bounceInLeft">
                        <div class="col-md-7">
                            <h4>My Bag <span>(1 item)</span></h4>
                        </div>
                        <div class="col-md-5"><h3> &nbsp;</h3></div>
                                                
                        <?php
                        $total = $order_details->unit_price * $order_details->quantity;
                        $discount_price = $order_details->discount * $order_details->quantity;
                        $grand_total = $total + Configure('CONFIG_SHIPPING_AMOUNT');
                        ?>
                        <div class="col-md-12 product_s">
                            <div class="col-md-3">
                                <?php $productsImage = CommonHelpers::getProductImage($order_details->product_id, $order_details->color_id); ?>
                                @if(!empty($productsImage))
                                <img src="{{PRODUCT_IMAGE_URL.$productsImage['0']['image_name']}}">
                                @else
                                <img src="{{asset('img/no-image.png')}}">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h4>{{ ucfirst($order_details->product_name) }}</h4>
                                <p class="price">
                                    <i class="fa fa-inr" aria-hidden="true"></i> 
                                    {{ $order_details->unit_price*$order_details->quantity + $order_details->discount*$order_details->quantity}}                                   
                                    <span style="
                                          text-decoration: line-through;
                                          font-size: 18px;
                                          color: #e69f00;
                                          padding: 2% 0%;">       
                                        @if(isset($order_details->discount) && !empty($order_details->discount) && $order_details->discount != 0.00)
                                        &nbsp;&nbsp;&nbsp;<i class="fa fa-inr" aria-hidden="true"></i> 
                                        {{ $order_details->discount*$order_details->quantity }} </span>                                   
                                    &nbsp;&nbsp;&nbsp;<i class="fa fa-inr" aria-hidden="true"></i> 
                                    {{ $order_details->unit_price*$order_details->quantity }}
                                    @endif

                                </p>
<!--   		<p class="price">
                    <i class="fa fa-inr" aria-hidden="true"></i> &nbsp;2500
                </p>-->

                                <?php $size = CommonHelpers::getSize($order_details->size_id);
                                $colorLists = CommonHelpers::getProductColor_image($order_details->color_id,$order_details->product_id);?>
                                <p class="size_p">Size: <span>{{$size[0]['size']}}</span>
                                    &nbsp;&nbsp;&nbsp; Qty: <span> {{ $order_details->quantity }}</span>
                                    &nbsp;&nbsp;Color:&nbsp;&nbsp; <span class="color_p" style="background: {{ $colorLists->color_picker }};"></span> 
                                </p>
                            </div>
                        </div>
                        

                    </div>
                    <div class="col-md-4 totl_dlt order_sss">
                        <h4>Order Summary</h4>
                        <table class="block animated moveUp">
                            <tbody><tr>
                                    <td class="">Product total Price</td>
                                    <td class="">Rs. {{ $total + $discount_price}}</td>
                                </tr>
                                @if(isset($discount_price) && !empty($discount_price) && $discount_price != 0.00)
                                <tr>
                                    <td class="">Discount</td>
                                    <td class="">Rs. {{ $discount_price }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td class="">Shipping</td>
                                    <td class="">Rs. 
                                        @if($grand_total != '0.00')
                                        {{ Configure('CONFIG_SHIPPING_AMOUNT') }}
                                        @else
                                        0.00
                                        @endif
                                    </td>
                                </tr>
                                <tr class="total">
                                    <td class="">Payable Amout</td>
                                    <td class="">Rs. {{ $grand_total }}</td>
                                </tr>
                            </tbody></table>
                    </div>
                </div>
                <div class="col-md-12 conti_n block animatable moveUp">
                    <a href="#" id="show2">Process to Payment</a>
                </div>
            </div>
        </div>


        <!-----tworow--->
        <div class="row check_out3" style="display: none;">
            <div class="col-md-12">  
                <h3 class="add_heading block animatable moveUp"><span class="one">Address</span> <span class="two">----- Summary</span> <span class="three" style="color: #222;">----- Payment </span></h3></div>

            <div class="col-md-12 btm_dvv">  
                <div class="col-md-12 address_showw address_showw1 block animatable bounceInLeft">
                    <div class="col-md-6">
                        <h3>Select Payment Method</h3>
                    </div> 
                    <div class="col-md-6 taltal">
                        <h3>Total Payable &nbsp;&nbsp;&nbsp;&nbsp;<span><i class="fa fa-inr" aria-hidden="true"></i> {{ $grand_total }}</span></h3>
                    </div>  
                </div>

                <div class="col-md-12 min_er1">
                    <div class="tab block animatable bounceInLeft">
                   <!--  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Credit/ Debit Card <i class="fa fa-chevron-right" aria-hidden="true"></i></button>-->
                        <button class="tablinks" onclick="openCity(event, 'Paris')">Paytm <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                </div>
                    <div id="Paris" class="tabcontent">
                        <form action="{{URL::to("/")}}/payment" method="post" class="pymnt_pay" id="payForm">
                            <input type="hidden" value="{{$order_no}}" name="order_no" />
                            <input type="hidden" value="{{$grand_total}}" name="checkout_amount" class="grand_total"/>
                            <input type="radio" checked="checked" name="pay_mode" class="pay_mode" value="paytm" style="display:none;">
<!--                            <h3>Paytm</h3>-->
        <img src="../img/paytm.jpg" class="img_paytms" style="max-height: 260px; margin-left: auto; margin-right: auto; display: block;">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            @if($grand_total != '0.00')
                            <button type="submit" class="btn_amount btn" id="pay_now" />Pay Now</button>
                                @else
                            <button type="button" class="btn_amount btn" id="pay_now11" onclick="alert('Item Not Found.');"  />Pay Now</button>
                            @endif
                        </form>
                    </div>


                    <script>
                        function openCity(evt, cityName) {
                            var i, tabcontent, tablinks;
                            tabcontent = document.getElementsByClassName("tabcontent");
                            for (i = 0; i < tabcontent.length; i++) {
                                tabcontent[i].style.display = "none";
                            }
                            tablinks = document.getElementsByClassName("tablinks");
                            for (i = 0; i < tablinks.length; i++) {
                                tablinks[i].className = tablinks[i].className.replace(" active", "");
                            }
                            document.getElementById(cityName).style.display = "block";
                            evt.currentTarget.className += " active";
                        }

                    // Get the element with id="defaultOpen" and click on it
                        //document.getElementById("defaultOpen").click();
                    </script>
                </div>
            </div>
        </div>




        <script>
            $(document).ready(function () {
                $("#show1").click(function () {
                   $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
                  var type_add =   $('input[name=type_address]:checked', '#address_form').val();
                if(type_add){
                  $.ajax({
                      type: "POST",
            url: '{{URL::to("/")}}/selectOrderAddress',
            cache: false,
            data: {type_address: type_add},
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    if (msg1.status == '0') {
                       $('.success-msg2').html(msg1.message);
                    } else if (msg1.status == '1') {
                        $('.success-msg2').html(msg1.message);
                        //$(".loading-cntant").css("display", "none");
                        $(".check_out2").show();
                        $(".check_out1").hide();
                    }				

                },
                error: function (data) {
                }
            });
                  
                }else{
                    alert('Please Select Address radio button.');
                }   
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#show2").click(function () {
                    $(".check_out3").show();
                    $(".check_out2").hide();
                    
                });
            });
            
             $(document).ready(function () {
                $(".one").click(function () {
                    $(".check_out1").show();
                    $(".check_out2").hide();
                    $(".check_out3").hide();  
                    $('.success-msg2').text('');
                });
                $(".two").click(function () {
                    $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
                    var type_add =   $('input[name=type_address]:checked', '#address_form').val();
                    if(type_add == undefined){
                        alert('Please Select Address radio button.');
                    }else{
                      $.ajax({
                      type: "POST",
            url: '{{URL::to("/")}}/selectOrderAddress',
            cache: false,
            data: {type_address: type_add},
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    if (msg1.status == '0') {
                       $('.success-msg2').html(msg1.message);
                    } else if (msg1.status == '1') {
                        $('.success-msg2').html(msg1.message);
                        //$(".loading-cntant").css("display", "none");
                       $(".check_out1").hide();
                    $(".check_out2").show();
                    $(".check_out3").hide();
                    }				

                },
                error: function (data) {
                }
            });  
                    
                }
                });
                $(".three").click(function () {
                    var type_add =   $('input[name=type_address]:checked', '#address_form').val();
                    if(type_add == undefined){
                        alert('Please Select Address radio button.');
                    }else{
                        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
                    var type_add =   $('input[name=type_address]:checked', '#address_form').val();
                    if(type_add == undefined){
                        alert('Please Select Address radio button.');
                    }else{
                      $.ajax({
                      type: "POST",
            url: '{{URL::to("/")}}/selectOrderAddress',
            cache: false,
            data: {type_address: type_add},
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    if (msg1.status == '0') {
                       $('.success-msg2').html(msg1.message);
                    } else if (msg1.status == '1') {
                        $('.success-msg2').html(msg1.message);
                        //$(".loading-cntant").css("display", "none");
                    $(".check_out1").hide();
                    $(".check_out2").hide();
                    $(".check_out3").show();
                    }				

                },
                error: function (data) {
                }
            });  
                    
                }
                    
                }
                });
            });
        </script>

    </div>
</section>

<script>    
     $(document.body).on('click',"#pay_now",function (e) {
         var pay_mode = $('.pay_mode').is(":checked");
         if(pay_mode == false){
         alert("Please Select Payment Method.");
          return false;
     }else{
                
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });

        
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/check_stock',
            cache: false,
            data: {},
            success: function (msg) { 
                console.log(msg);
                msg1 = JSON.parse(msg);
                var k = 0;
                 $.each(msg1.data, function (key, value) {
                        console.log(value);
                        if(value.stock == 0){
                            alert(msg1.message);
                            //$('#panel_review').css('display', 'block');
                            //$('.check_stock'+value.product_id+''+value.color_id+''+value.size_id).html(msg1.message);
                          k++;
                        return false;
                        }
                    });
                    if(k == 0){
                    $('form#payForm').submit();
                    console.log(456);
                    return true;
                    }
                    console.log("as", k);
            },
            error: function (data) {
            }
        });
        
};

        return false;

});
</script>
@stop
