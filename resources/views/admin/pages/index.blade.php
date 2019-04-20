@extends('layouts.default')

@section('content')  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php 
        $admin = adminUser();
        echo trans('admin.HELLO').' '.ucfirst($admin->first_name);
      ?>
    </h1>
    <h5 class="title_bottom">User Information</h5>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$totalusers_count}}</h3>
            <p>Total Registered Customers</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
          </div>
          <a href="{{route('admin.users.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      
        <?php /*?><div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{$todayusers_count}}</h3>
            <p>Customers Registered today</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
          </div>
          <a href="{{route('admin.users.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$weeklyusers_count}}</h3>
            <p>Customers Registered this Week</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-o" aria-hidden="true"></i>
          </div>
          <a href="{{route('admin.users.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><?php */?>
        
    </div>
  </section>
  
</div>
@stop
