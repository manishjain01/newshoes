@extends('layouts.default')

@section('content')  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
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
                    {!!  Html::decode(Html::link(route('admin.colors.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::open(['route'=>'admin.colors.store','files'=>true]) !!}  
            <div class="box-body">
            <div class='box-body-inner col-md-6'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Color Picker',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div id="cp2" class="input-group colorpicker-component"> 
                             {!! Form::text('color_picker',null,['class'=>'form-control','placeholder'=>'Color Picker']) !!}
                            <span class="input-group-addon"><i></i></span>
                          </div>                            
                            <div class="error">{{ $errors->first('color_picker') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            {!! Form::label('Color Name',null,['class'=>'required_label']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::text('color_name',null,['class'=>'form-control','placeholder'=>'Color Name']) !!}
                            <div class="error">{{ $errors->first('color_name') }}</div>
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
<script type="text/javascript">
    $('#cp2').colorpicker();
</script>
@stop
