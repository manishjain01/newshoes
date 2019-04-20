<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Data tables</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <?php //  {!! Form::model($setting,['method'=>'post','route'=>'admin.settings.store','class'=>'form-horizontal']) !!}   ?>
{!!Form::model($setting, ['route' => ['admin.grades.update', $setting->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH',  'files' => true  , 'id' => 'edit-settings']) !!}
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#global_settings" data-toggle="tab">{{ trans('admin.GLOBAL_SETTINGS') }}</a></li>



                    </ul>
                    <div class="tab-content">
                        <!-- Start Global Settings -->
                        <div class="tab-pane active" id="global_settings">


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        {!! Form::label(trans('admin.SITE_TITLE'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('site_title',null,['class'=>'form-control','placeholder'=>trans('admin.SITE_TITLE')]) !!}

                                            <div class="error">{{ $errors->first('site_title') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        {!! Form::label(trans('admin.ADMIN_PAGE_LIMIT'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('page_limit',null,['class'=>'form-control','placeholder'=>trans('admin.ADMIN_PAGE_LIMIT')]) !!}

                                            <div class="error">{{ $errors->first('page_limit') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        {!! Form::label(trans('admin.FRONT_PAGE_LIMIT'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('front_page_limit',null,['class'=>'form-control','placeholder'=>trans('admin.FRONT_PAGE_LIMIT')]) !!}

                                            <div class="error">{{ $errors->first('front_page_limit') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        {!! Form::label(trans('admin.FROM_NAME'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('from_name',null,['class'=>'form-control','placeholder'=>trans('admin.FROM_NAME')]) !!}

                                            <div class="error">{{ $errors->first('from_name') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->


                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        {!! Form::label(trans('admin.STAFF_MAIL'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('staff_mail',null,['class'=>'form-control','placeholder'=>trans('admin.STAFF_MAIL')]) !!}

                                            <div class="error">{{ $errors->first('staff_mail') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        {!! Form::label(trans('admin.REPLY_TO_EMAIL'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('reply_to_email',null,['class'=>'form-control','placeholder'=>trans('admin.REPLY_TO_EMAIL')]) !!}

                                            <div class="error">{{ $errors->first('reply_to_email') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-6 form-group ">
                                        {!! Form::label(trans('admin.META_TITLE'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('meta_title',null,['class'=>'form-control','placeholder'=>trans('admin.META_TITLE')]) !!}

                                            <div class="error">{{ $errors->first('meta_title') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group col-md-6 ">
                                        {!! Form::label(trans('admin.META_KEYWORDS'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('meta_keywords',null,['class'=>'form-control','placeholder'=>trans('admin.META_KEYWORDS')]) !!}

                                            <div class="error">{{ $errors->first('meta_keywords') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->
                                </div>
                            </div><!-- /.col -->
                                       <div class="row">

                                <div class="col-md-12">
                                    
                                    <div class="form-group col-md-6 ">
                                        {!! Form::label(trans('admin.META_DESCRIPTION'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::text('meta_description',null,['class'=>'form-control','placeholder'=>trans('admin.META_DESCRIPTION')]) !!}

                                            <div class="error">{{ $errors->first('meta_description') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group ">
                                        {!! Form::label(trans('admin.EMAIL_SIGNATURE'),null,['class'=>'col-sm-4 control-label']) !!}
                                        <div class='col-sm-8'>
                                            {!! Form::textarea('email_signature',null,['class'=>'form-control','placeholder'=>trans('admin.EMAIL_SIGNATURE')]) !!}

                                            <div class="error">{{ $errors->first('email_signature') }}</div>
                                        </div>
                                    </div><!-- /.form-group -->

                                </div>
                            </div><!-- /.col -->

                        </div><!-- /.row -->

                    </div>
                    <!-- END Global Settings -->


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
            <div class="box-footer">

                {!! Html::link(route('admin.settings.index'), trans('admin.CANCEL'), array('id' => 'linkid')) !!}
                {!! Form::submit(trans('admin.SUBMIT'),['class' => 'btn btn-info pull-right'])!!}
            </div>

            {!! Form::close() !!}

        </div><!-- /.col -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->

