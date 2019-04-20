<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        @include('includes.admin.breadcrumb')
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <h3 class="pull-right">  
                    {!!  Html::decode(Html::link(route('admin.users.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::open(['route'=>'admin.users.store','files'=>true]) !!}  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.FIRST_NAME'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('first_name',null,['class'=>'form-control','placeholder'=>trans('admin.FIRST_NAME')]) !!}
                            <div class="error">{{ $errors->first('first_name') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.LAST_NAME'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">{!! Form::text('last_name',null,['class'=>'form-control','placeholder'=>trans('admin.LAST_NAME')]) !!}
                            <div class="error">{{ $errors->first('last_name') }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.EMAIL'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>trans('admin.EMAIL')]) !!}
                            <div class="error">{{ $errors->first('email') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.PHONE'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>trans('admin.PHONE')]) !!}
                            <div class="error">{{ $errors->first('phone') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.PASSWORD'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::password('password',['class'=>'form-control','placeholder'=>trans('admin.PASSWORD')]) !!}
                            <div class="error">{{ $errors->first('password') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label(trans('admin.CONFIRM_PASSWORD'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::password('confirm_password',['class'=>'form-control','placeholder'=>trans('admin.CONFIRM_PASSWORD')]) !!}
                            <div class="error">{{ $errors->first('confirm_password') }}</div>
                        </div>
                    </div>
                </div>
                
                      
<!--                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label(trans('admin.PROFILE_IMAGE'),null,['class'=>'required_label']) !!}
                                        
                                         {!! Form::file('profile_image') !!}
                                          <div class="error">{{ $errors->first('profile_image') }}</div>    
                            </div>
                           </div> -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                           {!! Form::label(trans('admin.STATUS'),null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <?php $status_list = Config::get('global.status_list'); ?>
                              {!! Form::select('status', $status_list, null, ['class' => 'form-control select2 autocomplete']) !!}
                        </div>
                    </div>
                </div>
                
            </div>

            
</div><!-- /.box-body -->


<div class="box-footer">

    <div class="box-footer">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="pull-right">
                    {!! Form::reset(trans('admin.RESET'),['class' => 'btn btn-default '])!!} 
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
</div>
<!-- /.box-footer -->

{!! Form::close() !!}

</div><!-- /.box -->


</section><!-- /.content -->
</div>
<style>
.box-body-inner.col-md-6 {
    margin: 0 25%;
}
</style>
@stop