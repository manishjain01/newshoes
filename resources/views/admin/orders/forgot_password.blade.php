    
@extends('layouts.blank')

@section('content')  


<div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Admin</b> {{config('settings.CONFIG_SITE_TITLE')}}</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body"> 
        <p class="login-box-msg">You need to provide your registered email here.</p>
        
    
        {!! Form::open(array('route' =>  'admin.forgot_password')) !!}

          <div class="form-group has-feedback">
            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
            <div class="error">{{ $errors->first('email') }}</div>
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-4">
                {!! Html::link(route('admin.login'), 'Cancel', array('class' => 'btn btn-default   btn-flat pull-left')) !!}
            </div>
         <div class="col-xs-8">
            {!! Form::submit('Send Password Reset Link',['class'=>'btn btn-primary btn-block btn-flat pull-right'])!!}
            

            </div>
          </div>

        {!! Form::close() !!}


    <!-- jQuery 2.1.4 -->
   {!! Html::script(asset('backend/bootstrap/js/bootstrap.min.js')) !!}
{!! Html::script(asset('backend/js/jquery.noty.js')) !!}

      </div>
</div>

@stop
