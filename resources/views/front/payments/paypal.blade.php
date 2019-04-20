@extends('layouts.home') 
@section('content')<?php //pr($datas);exit;?>
<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
    <div class="container">
        <?php
        //$paypal_url =  'https://secure.paypal.com/uk/cgi-bin/webscr';
        //$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        //$paypalid   = 'persnaltest99-1@shop.com';
        $paypalid   = 'developer.advocosoft@gmail.com';
        //$paypalid = 'jimjoy1983@yahoo.it';
        //$paypalid   = 'jimjoy1983-facilitator@yahoo.it';
        //$paypalid   = 'abhishek.advocosoft@gmail.com';
        ?>
       <form action="<?=$paypal_url?>" method="post" target="_top">
    <?php /*?><input type="hidden" name="first_name" value="<?php echo Firstname?>">
    <input type="hidden" name="last_name" value="<?php echo Lastname?>">
    <input type="hidden" name="email" value="<?php echo Email?>">
    <input type="hidden" name="address1" value="<?php echo Address?>">
    <input type="hidden" name="address2" value="<?php echo Address2?>">
    <input type="hidden" name="city" value="<?php echo City?>">
    <input type="hidden" name="zip" value="<?php echo Postcode?>">
    <input type="hidden" name="day_phone_a" value="">
    <input type="hidden" name="day_phone_b" value="<?php echo Mobile?>"><?php */?>

    
	<input type='hidden' name='business' value='<?=$paypalid?>'>
        <?php /*?>@foreach($orders['0']->order_detail as $order)
	<input type='hidden' name='item_name' value='{{$order->product_name}}'>
        @endforeach <?php */?>
        <input type='hidden' name='item_name[]' value='{{$datas}}'>
	<input type='hidden' name='quantity' value='1'>
        <input type='hidden' name='custom' value='{{ $orders->order_no}}'>
	<input type='hidden' name='amount' value='{{ $orders->item_total_amount}}'>
	<input type='hidden' name='shipping' value="{{ $orders->shipping_amount}} }}">
	<input type='hidden' name='currency_code' value='USD'>
	<input type='hidden' name='notify_url' value='{{ URL::to('payment-process')}}'>
	<input type='hidden' name='cancel_return' value="{{ URL::to('payment-cancel')}}">
	<input type='hidden' name='return' value="{{ URL::to('payment-success')}}" />
	<!-- COPY and PASTE Your Button Code -->
	<input type="hidden" name="cmd" value="_xclick">
	<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        </form> 
    </div>
</section>
@stop
