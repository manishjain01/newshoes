@extends('layouts.default')
@section('content')
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
   @include('includes.admin.breadcrumb')
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
   <div class="col-xs-12">
   <div class="box box-primary">
   <div class="box-header with-border">
      <div class="col-md-6">
         <img src="{{asset('img/logo.png')}}">
      </div>
      <div class="col-md-6 detail">
         <p>Order No. #: {{$orderDetail->order_no}}</p>
         <p>Transaction id. #: {{$paymentss->txn_id}}</p>
         <p>Created : {{$orderDetail->created_at}}</p>
         <p>Order Status : <button class="btn btn-warning">{{$orderDetail->order_status}}</button> </p>
         <p>Payment Status : <button class="btn btn-warning">{{$orderDetail->payment_status}} </button> </p>
         
      </div>
   </div>
   <!-- /.box-header -->
   <div class="box-header with-border">
      <div class="col-md-6">
         <p><b>Name</b> : {{$orderDetail->first_name}} {{$orderDetail->last_name}}</p>
         <p><b>Address</b> :{{$orderDetail->address_1}}</p>
         @if(!empty($orderDetail->address_2))
         <p>{{$orderDetail->address_2}}</p>
         @endif
         @if(!empty($city_name))
        <p><b>City</b> :  {{$city_name->city_name}}</p>
         @endif
         @if(!empty($state_name))
          <p><b>State</b> : {{$state_name->state_name}}</p>
         @endif
         <p><b>Pincode</b> : {{$orderDetail->pincode}} </p>
         <p><b>Phone</b> : {{$orderDetail->phone}} </p>
         <p><b>Email</b> : {{$orderDetail->email}} </p>
         
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
            @if(isset($orderProducts) && !empty($orderProducts)) 
            <?$i=0;?>
            @foreach($orderProducts as $key=>$orderProduct)
            <?php $SizeLists = CommonHelpers::getSize($orderProduct->size_id);
                  $colorLists = CommonHelpers::getColor($orderProduct->color_id);?>
            <tr>
               <td>{{ $i+1 }}</td>
               <td>{{$orderProduct->product_name}}</td>
               <td>{{$colorLists['0']['color_name']}}</td>
               <td>{{$SizeLists['0']['size']}}</td>
               <td>{{$orderProduct->quantity}}</td>
               <td align="right">{{$orderProduct->unit_price}}</td>
               <td align="right">{{$orderProduct->unit_price*$orderProduct->quantity}}</td>
            </tr>
            <?$i++;?>
            @endforeach
            
             <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="right"><b>Shipping (Standars Shipping):{{$orderDetail->shipping_amount}}</b></td>
            </tr>
            
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td align="right"><b>Total:{{$orderDetail->shipping_amount+$orderDetail->item_total_amount}}</b></td>
            </tr>
            
            @else
            <tr>
               <td colspan="4" align="center">No Record Found</td>
            </tr>
            @endif
         </tbody>
      </table>
		<div>
			<span class="msg_success">
			@if(Session::has('alert-sucess'))
			{!! Session::get('alert-sucess') !!}
			@endif
			</span>
			<span class="msg_error">
			@if(Session::has('alert-error'))
			{!! Session::get('alert-error') !!}
			@endif
			</span>
		</div>
      
      
      {!! Form::model($orderDetail,['route'=>['orders.update',$orderDetail->id],'files'=>true]) !!}
      <div class="box-body">
		  <div class="row">
                    <div class="col-md-1">
                        <div class="form-group ">
                           {!! Form::label('Status',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
							 <?php $order_status_list = Config::get('global.order_status_list'); ?>
                                {!! Form::select('order_status', $order_status_list, null, ['class' => 'form-control select2 autocomplete']) !!}
                          </div>
                          <input type="hidden" name="order_id" value="{{$orderDetail->id}}">
                    </div>
                    
                    <div class="col-md-4">
						<div class="">
							{!! Form::submit('Save',['class' => 'btn btn-info '])!!}
<!--							{!! Form::reset('Back',['class' => 'btn btn-warning '])!!} -->
							
						</div>
                    </div>
                    
                </div>
      </div>
      {!! Form::close() !!}
      
      
</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
