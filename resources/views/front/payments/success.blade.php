@extends('layouts.home') 
@section('content')
<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
    <div class="container">
        <h2>Your order has been placed successfully.<br />
            Your order id - {{ $input['order_no'] }} </h2>
    </div>
</section>

@stop
