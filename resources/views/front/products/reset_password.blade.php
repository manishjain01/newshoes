    
@extends('layouts.blank')

@section('content')  


<div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Admin</b> {{config('settings.CONFIG_SITE_TITLE')}}</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body"> 
       
        
    
        {!! Form::open(array('route' =>  ['admin.reset_password',$email_token])) !!}

          <div class="form-group has-feedback">
            {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
            <div class="error">{{ $errors->first('password') }}</div>
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!! Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
            <div class="error">{{ $errors->first('confirm_password') }}</div>
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-4">
                {!! Html::link(route('admin.login'), 'Cancel', array('class' => 'btn btn-default   btn-flat pull-left')) !!}
            </div>
         <div class="col-xs-8">
            {!! Form::submit('Submit',['class'=>'btn btn-primary      pull-right'])!!}
            

            </div>
          </div>

        {!! Form::close() !!}


      </div>
</div>




@stop
