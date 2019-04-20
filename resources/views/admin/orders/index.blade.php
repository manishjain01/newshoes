@extends('layouts.default')
@section('content')
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
            <h3 class="pull-left">
                    {!! Form::open(array('route' => 'admin.orders.search', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
							<div class="row">
								<div class="col-lg-12">
									<div style="width:198%;">
										<div style="float:left; width:98%;margin-left: 1%;">
											{!! Form::text('order_no', Input::get('order_no'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Order No., Email, Transaction Id'
											)); !!}
										</div>
         
										<div style="float:left; width:0%;">
										</div>
										<div style="float:right; width:0%;">
											{!! Form::button('<i class="glyphicon glyphicon-search"></i>', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
										</div>
									</div>
								</div>
							</div>
						{!! Form::close() !!}
                </h3>
            <?php /* ?><h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.users.create'),"<i class='fa  fa-plus'></i>".trans('admin.ADD_NEW'),['class'=>'btn btn-primary'])) !!}
            </h3><?php */ ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
              <th width="5%" align="center">S.<br> No.</th>
              <th width="5%">@sortablelink('first_name', 'Customer Detail')</th>
              <th width="5%">Transaction Id</th>
              <th width="5%">Order no</th>
              <th width="15%">Shipping <br>Address</th>
<!--              <th width="10%">Shipping <br>Details</th>-->
              <th width="15%">Pay Mode</th>
              <th width="10%">Cart <br> Total</th>
              <th width="5%">Order <br> Status</th>
              <th width="5%">Payment <br> Status</th>
              <th width="5%">@sortablelink('created_at', 'Order date')</th>
              <th width="10%" align="center">Actions</th>
            </tr>
            </thead>
            <tbody>
              @if(isset($orders) && !empty($orders))
              <?php $i = $orders->perPage() * ($orders->currentPage() - 1);?>
              @foreach ($orders as $order)
              
            
           <tr>
               <td>{{ ($i+1)}}</td>
              <td>Name : {{ ucfirst($order->first_name)}} {{ ucfirst($order->last_name)}}<br>
				  Email : {{ ucfirst($order->email)}}<br>
				  Phone : {{ ucfirst($order->phone)}}
              
              </td>
           
              <td>{{$order->txn_id}}</td>
             <td>{{$order->order_no}}</td>
             <td>{{$order->address_1}}, {{$order->address_2}}</td>
             <?php /*?><td>Method: Standard Method<br> 
		Shipping Amount : {{$order->shipping_amount}}</td><?php */?>
              <td>{{$order->pay_mode}}</td>
              <td>{{$order->item_total_amount}}</td>
              <td>{{$order->order_status}}</td>
              <td>{{$order->payment_status}}</td>
              <td>{{ date_val($order->created_at,DATE_FORMATE ) }}</td>
              <td>
				  {!!  Html::decode(Html::link(route('admin.view', $order->order_no),"<i class='fa  fa-eye'> View</i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                            
              </td>
         <?php $i++;?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $orders->appends(Input::all('page'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
