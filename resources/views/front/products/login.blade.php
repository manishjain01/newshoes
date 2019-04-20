@extends('layouts.frontend')
  @section('content')  

    <div class="content-wrapper">
        
     <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box  box-primary">
        
           
      	    {!! Form::open(array('url' =>  URL::to('login'))) !!}

          <div class="form-group has-feedback">
            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
            <div class="error">{{ $errors->first('email') }}</div>
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
            <div class="error">{{ $errors->first('password') }}</div>
            <!--<input type="password" class="form-control" placeholder="Password" />-->
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
        {!! Html::link(route('admin.forgot_password'), 'Forgot Password', array('class' => 'btn btn-default btn-flat')) !!}
            </div><!-- /.col -->
            <div class="col-xs-4">
            {!! Form::submit('Sign In',['class'=>'btn btn-primary btn-block btn-flat'])!!}

            </div>
          </div>

        {!! Form::close() !!}
      </div><!-- /.box -->
    </section><!-- /.content -->
    </div>
  @stop