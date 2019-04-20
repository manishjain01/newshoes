@extends('layouts.inner') 
@section('content')
<style>
    th {
    text-align: center;
}
</style>
<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec payment_msg">
    <div class="container">
        <h2 style="min-height: 100px;">
            <br /><br />
            @if(Session::has('alert-sucess'))
            {!! Session::get('alert-sucess') !!}
            @endif
            @if(Session::has('alert-error'))
            {!! Session::get('alert-error') !!}
            @endif
        </h2>
        <?php
        if($orders->payment_status == 'Complete'){
        $prorow = array();
            foreach($orderDetails as $orderDetail){                
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
            }
            
            
            ?>
        <?php
        $amount_paid = $orders->item_total_amount+$orders->shipping_amount;
        $tablehead = '<table border="1" style = "width: 100%; text-align: center;">
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Product Quantity</th>
			<th>Gross Amount</th>
			<th>Product Color</th>
			<th>Product Size</th>
                        <th>Product Discount</th>
                        <th>Total Amount</th>
		</tr>
	</thead>
        <tbody>';
            
            
        $tbalefooter = '</tbody>
        <tfoot>
                
		<tr>
			<td colspan="6">Shipping Charge:-</td>
			<td>'.$orders->shipping_amount.'</td>
		</tr>
		<tr>
			<td colspan="6">Amount to paid:-</td>
			<td>'.$amount_paid.'</td>
		</tr>
	</tfoot>
        </table>';
        echo $prorows = $tablehead.implode('<br/>', $prorow).$tbalefooter;
        ?>
        <h2><b>Shipping Address</b></h2>

        <p><strong>Name:&nbsp;</strong>{{ $orders->first_name }}&nbsp;{{ $orders->last_name }}<br />
            <strong>Phone:&nbsp;</strong>{{ $orders->phone }}<br />
        <strong>Address:&nbsp;</strong>{{ $orders->address_1 }}{{ ', '.$orders->address_2 }}<br />
        <strong>City:&nbsp;</strong>{{ $city->city_name }}<br />
        <strong>State:&nbsp;</strong>{{ $state->state_name }}<br />
        <strong>Pincode:&nbsp;</strong>{{ $orders->pincode }}</p>
        <?php }?>
    </div>
</section>

@stop
