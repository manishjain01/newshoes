@extends('layouts.frontend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

      <div class="box box-primary">
        
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
<!--                  <th  width="15%" align="center">{{trans('admin.PROFILE_IMAGE')}}</th>-->
              <th width="15%">@sortablelink('first_name', 'Client Name')</th>
              <th width="15%">@sortablelink('email', trans('admin.EMAIL'))</th>
              <th width="15%">@sortablelink('phone', trans('admin.PHONE'))</th>
              <th width="15%">@sortablelink('phone', 'DOB')</th>
              <th width="15%">@sortablelink('phone', trans('admin.PROFILE_IMAGE'))</th>
              <th width="10%">@sortablelink('created_at', trans('admin.REGISTERED_ON'))</th>
              <th width="10%">{{trans('admin.STATUS')}}</th>
              <th width="15%" align="center">{{trans('admin.EDIT')}}</th>
            </tr>
            </thead>
            <tbody>
              @if(!$users->isEmpty())
              @foreach ($users as $user)
              
            
           <tr>
              <td>{{ ucfirst($user->first_name.' '.$user->last_name)}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->dob}}</td>
              <td>{!! BasicFunction::showImage(PROFILE_IMAGES_UPLOAD_DIRECTROY_PATH,PROFILE_IMAGES_ONTHEFLY_IMAGE_PATH,$user->profile_img,array('width'=>'100', 'height'=>'100','zc'=>2)) !!}</td>
              <td>{{ date_val($user->created_at,DATE_FORMATE ) }}</td>
              
              
              <td>
                  @if($user->status == 1)
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-check'></i>",['class'=>'btn btn-success confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.ACTIVE'), "data-alert"=>trans('admin.INACTIVE_ALERT')])) !!} <br> Active
                  @else
                    {!!  Html::decode(Html::link(route('admin.users.status_change',['id' => $user->id,'status'=>$user->status]),"<i class='fa  fa-remove'></i>",['class'=>'btn btn-danger confirm_link','data-toggle'=>'tooltip','title'=>trans('admin.INACTIVE'), "data-alert"=>trans('admin.ACTIVE_ALERT')])) !!} <br> Inactive
                  @endif
              </td>
              <td>
				  {!!  Html::decode(Html::link(route('admin.users.edit', $user->id),"<i class='fa  fa-edit'></i>",['class'=>'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.EDIT')])) !!}				  
                            {!! Form::model($user, ['method' => 'DELETE', 'url' => '/admin/users/' . $user->id]) !!}
                            {!! Form::button("<i class='fa  fa-trash-o'></i>", ['type' => 'submit','class' => 'btn btn-primary','data-toggle'=>'tooltip','title'=>trans('admin.DELETE')]) !!}
                            {!! Form::close() !!}
              </td>
         
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



<script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAscwBWCB3bJe5V28425Dd05Ik7D5Mxsyk",
    authDomain: "meetnepalidev.firebaseapp.com",
    databaseURL: "https://meetnepali-4f1d5.firebaseio.com/",
    projectId: "meetnepalidev",
    storageBucket: "meetnepalidev.appspot.com",
    //messagingSenderId: "164314844996"
  };
  firebase.initializeApp(config);
  var database = firebase.database();
  console.log(database);
</script>
@stop
<!-- /.content-wrapper -->