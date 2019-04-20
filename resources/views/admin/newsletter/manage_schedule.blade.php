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

             {!! Form::open(['method'=>'post','route'=>['admin.newsletter.manageScheduleStore',$newsletter->id]]) !!}  
            <div class="box-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group ">
                            {!! Form::label(trans('admin.USER_LIST'),null,['class'=>'required_label']) !!}

                            {!! Form::select('email[]', $user_list, null, ['class' => 'form-control','id'=>'multiselectList' ,'multiple' => true]) !!}



                            
                            <div class="error">{{ $errors->first('email') }}</div>
                        </div><!-- /.form-group -->              
                        <div class=" form-group ">
                            {!! Form::label(trans('admin.DATE'),null,['class'=>'required_label']) !!}
                            {!! Form::text('schedule_time',null,['class'=>'form-control date_picker','placeholder'=>trans('admin.DATE')]) !!}
                            <div class="error">{{ $errors->first('time') }}</div>
                        </div><!-- /.form-group -->         
                             <div class=" form-group ">
                            {!! Form::label(trans('admin.SUBJECT'),null,['class'=>'']) !!}
                            {!! Form::label($newsletter->subject,null,['class'=>'form-control disabled']) !!}
                           
                            
                        </div><!-- /.form-group -->

                     

                        
                    


                    </div><!-- /.col -->

                       <div class="form-group col-md-12 ">
                            {!! Form::label(trans('admin.BODY'),null,['class'=>'    ']) !!}
                            {!! $newsletter->body  !!}
                           
                           
                        </div><!-- /.form-group -->
                        <div class="form-group col-md-6">
                            {!! Form::label(trans('admin.STATUS'),null,['class'=>'']) !!}
                            <?php $status_list = Config::get('global.status_list'); ?>
                            {!! Form::select('status', $status_list, null, ['class' => 'form-control']) !!}
                        </div><!-- /.form-group -->

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
<script type="text/javascript">
    $(document).ready(function() {
        $('#multiselectList').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            buttonWidth: '100%',
            numberDisplayed: 1

        });
         $(".date_picker").datepicker({
       startDate: "+1d",
        dateFormat: date_format,
        autoclose: true,
        todayHighlight : true
        }).attr('readonly','readonly');
    });
</script>
   
@stop

