<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')

@section('content')  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
        @include('includes.admin.breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="pull-right">  
                            {!!  Html::decode(Html::link(route('admin.emaillogs.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
                        </h3>
                    </div>
                    <div class="box-body">

                        <div class='box-body no-padding' >
                            <div class="mailbox-read-info">
                                <h3> {{$email_log->subject}}</h3>
                                <h5>{{trans('admin.EMAIL_TYPE')}} :-{{ $email_log->email_type}} </h5>
                                <h5>{{trans('admin.TO')}} :  {{$email_log->email_to}}
                                    <span class="mailbox-read-time pull-right">{{ date_val($email_log->created_at,DATE_FORMATE ) }}</span></h5>
                            </div>
                            <div class="mailbox-read-message">
                                <?php echo $email_log->message ?>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@stop
<!-- /.content-wrapper -->
