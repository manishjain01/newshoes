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
  </section>
 <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <h3 class="pull-right">  
                    {!!  Html::decode(Html::link(route('admin.plans.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::open(['route'=>'admin.plans.store','files'=>true]) !!}  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Plan Type',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('type',null,['class'=>'form-control','placeholder'=>'Plan Type']) !!}
                            <div class="error">{{ $errors->first('type') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Plan Price', null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">{!! Form::text('price',null,['class'=>'form-control','placeholder'=>'Plan Price']) !!}
                            <div class="error">{{ $errors->first('price') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('Discount',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('discount',null,['class'=>'form-control','placeholder'=>'Discount']) !!}
                                <div class="error">{{ $errors->first('discount') }}</div>
                            </div>
                        </div>
                    </div>

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

                <div class="pull-right">
                    {!! Form::reset(trans('admin.RESET'),['class' => 'btn btn-default '])!!} 
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
</div>
<!-- /.box-footer -->

{!! Form::close() !!}

</div><!-- /.box -->


 </section>
 
</div>
@stop
