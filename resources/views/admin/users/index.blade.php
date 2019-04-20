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
                    {!! Form::open(array('route' => 'admin_user_search', 'class' => 'form', 'novalidate' => 'novalidate')) !!}
							<div class="row">
								<div class="col-lg-12">
									<div style="width:100%;">
										<div style="float:left; width:78%;margin-left: 1%;">
											{!! Form::text('search', Input::get('search'), array(
												'required', 
												'class' => 'form-control', 
												'placeholder' => 'Search by Name, Email, Phone'
											)); !!}
										</div>
                  
										<div style="float:left; width:2%;">
										</div>
										<div style="float:right; width:20%;">
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
<!--            <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
                <th width="5%" align="center">S. No.</th>
              <th width="15%">@sortablelink('first_name', 'Name')</th>
              <th width="15%">Profile Image</th>
              <th width="15%">@sortablelink('email', trans('admin.EMAIL'))</th>
              <th width="15%">@sortablelink('phone', trans('admin.PHONE'))</th>
              <th width="15%">Address</th>
              <th width="10%">@sortablelink('created_at', trans('admin.REGISTERED_ON'))</th>
<!--              <th width="10%">{{trans('admin.STATUS')}}</th>-->
              <th width="15%" align="center">Action</th>
            </tr>
            </thead>
            <tbody>
              @if(!$users->isEmpty())
              <?php $i = $users->perPage() * ($users->currentPage() - 1);?>
              @foreach ($users as $user)
              <?php
              $cityName = CommonHelpers::cityName($user->city);
              $stateName = CommonHelpers::stateName($user->state);?>
            
           <tr>
               <td>{{ $i+1 }}</td>
              <td>{{ ucfirst($user->first_name.' '.$user->last_name)}}</td>
             <!-- <td>{{$user->profile_img}}</td>-->
             <td><img src="{{asset('/uploads/user/'.$user->profile_img)}}" alt="" style="height:100px;with:100px;"></td>
              <td>{{$user->email}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->address_1.' '.$user->address_2}}
              @if(!empty($cityName))
              , {{$cityName->city_name}}
              @endif
              @if(!empty($stateName))
              , {{$stateName->state_name}}
              @endif
              @if(!empty($user->pincode))
              , {{$user->pincode}}
              @endif
              </td>
              <td>{{ date_val($user->created_at,DATE_FORMATE ) }}</td>
              
              
              <?php /*?><td>
                  @if($user->status == 1)
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!} <br> Active
                  @else
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!} <br> Inactive
                  @endif
              </td><?php */?>
              <td>
			<?php /*?>{!!  Html::decode(Html::link(route('admin.users.edit', $user->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}<?php */?>				  
                            {!! Form::model($user, ['method' => 'DELETE', 'url' => '/admin/users/' . $user->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}
              </td>
         <?php $i++;?>
            @endforeach
             @else

                <tr><td colspan="6"><div class="data_not_found"> Data Not Found </div></td></tr>

           @endif

            </tbody>
          </table>
           {!! $users->appends(Input::all('page'))->render() !!}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
