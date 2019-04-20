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
        <div class="box-header with-border">
            <h3 class="pull-right">  
                {!!  Html::decode(Html::link(route('admin.plans.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">

            {!! Form::model($plan,['method'=>'patch','route'=>['admin.plans.update',$plan->id],'files'=>true]) !!}

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
                                {!! Form::label('Plan Price',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('price',null,['class'=>'form-control','placeholder'=>'Plan Price']) !!}
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
                <div class="pull-right">

                    {!!  Html::decode(Html::link(route('admin.plans.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
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