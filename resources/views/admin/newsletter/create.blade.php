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
                    {!!  Html::decode(Html::link(route('admin.newsletter.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                </h3>
            </div>
            {!! Form::open(['route'=>'admin.newsletter.store']) !!}  
            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.TITLE'),null,['class'=>'required_label']) !!}
                            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>trans('admin.TITLE')]) !!}
                            <div class="error">{{ $errors->first('title') }}</div>
                        </div><!-- /.form-group -->              
                        <div class="col-md-6 form-group ">
                            {!! Form::label(trans('admin.SUBJECT'),null,['class'=>'required_label']) !!}
                            {!! Form::text('subject',null,['class'=>'form-control','placeholder'=>trans('admin.SUBJECT')]) !!}
                            <div class="error">{{ $errors->first('subject') }}</div>
                        </div><!-- /.form-group -->

                        <div class="form-group col-md-12 ">
                            {!! Form::label(trans('admin.BODY'),null,['class'=>'required_label    ']) !!}
                            {!! Form::textarea('body',null,['id'=>'edit-editor-content', 'class'=>'form-control ckeditor','placeholder'=>trans('admin.BODY')]) !!}
                            <div class="error">{{ $errors->first('body') }}</div>
                        </div><!-- /.form-group -->

                        
                        <div class="form-group col-md-6">
                            {!! Form::label(trans('admin.STATUS'),null,['class'=>'required_label']) !!}
                            <?php $status_list = Config::get('global.status_list'); ?>
                            {!! Form::select('status', $status_list, null, ['class' => 'form-control']) !!}
                        </div><!-- /.form-group -->


                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.box-body -->


            <div class="box-footer">

                <div class="pull-right">
                    {!! Form::reset(trans('admin.RESET'),['class' => 'btn btn-default '])!!} 
                    {!! Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info '])!!}
                </div>
            </div>
            <!-- /.box-footer -->

            {!! Form::close() !!}

        </div><!-- /.box -->


    </section><!-- /.content -->
</div>

   
@stop

