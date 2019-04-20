<!-- Content Wrapper. Contains page content -->
@extends('layouts.default')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

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
                {!!  Html::decode(Html::link(route('admin.users.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])) !!}
            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">

            {!! Form::model($user,['method'=>'patch','route'=>['admin.users.update',$user->id],'files'=>true]) !!}

            <div class="box-body">
                <div class='box-body-inner col-md-6'>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label(trans('admin.EMAIL'),null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('email',null,['class'=>'form-control','readonly','placeholder'=>trans('admin.EMAIL')]) !!}
                                <div class="error">{{ $errors->first('email') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label(trans('admin.NAME'),null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('first_name',null,['class'=>'form-control','readonly','placeholder'=>trans('admin.NAME')]) !!}
                                <div class="error">{{ $errors->first('first_name') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('Gender',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <?php $data = Config::get('global.gender_list'); ?>
                            <div class="input-group date">
                                {!! Form::select('gender', $data, null, ['class' => 'form-control']) !!}
                                <div class="error">{{ $errors->first('gender') }}</div>
                            </div>
                        </div>
                    </div>
                    @if($user->role_id == 2)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('Looking For',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <?php $data = Config::get('global.gender_list'); ?>
                            <div class="input-group date">
                                {!! Form::select('looking', $data, null, ['class' => 'form-control']) !!}
                                <div class="error">{{ $errors->first('gender') }}</div>
                            </div>
                        </div>
                    </div>
                   @endif
                    <?php /* ?><div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('Looking For',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <?php $data = Config::get('global.gender_list'); ?>
                            <div class="input-group date">
                                {!! Form::select('looking[]', $data, null, ['class' => 'form-control', 'id'=>'languages','multiple'=>'multiple']) !!}
                                <div class="error">{{ $errors->first('gender') }}</div>
                            </div>
                        </div>
                    </div><?php */ ?>

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
                                {!! Form::label('Date Of birth',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('dob',null,['class'=>'form-control','id'=>'dob_reg','placeholder'=>'Date Of Birth']) !!}
                                <div class="error">{{ $errors->first('dob') }}</div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                {!! Form::label('Address',null,['class'=>'required_label']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::text('address',null,['class'=>'form-control input-group-lg','placeholder'=>'Address','id'=>'txtPlaces']) !!}
                                <div class="error">{{ $errors->first('address') }}</div>
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
                    {!! Form::hidden('lat',null,['class'=>'','id'=>'latid']) !!}
                            {!! Form::hidden('lng',null,['class'=>'','id'=>'longid']) !!}
                    {!!  Html::decode(Html::link(route('admin.users.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])) !!}
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
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker();
    });
</script>
<script>
    $(document).ready(function () {
        $('#languages').multiselect({
            nonSelectedText: 'Looking For'
        });
    });
     $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', function () {

            var places = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var mesg = "Address: " + address;
                mesg += "\nLatitude: " + latitude;
                mesg += "\nLongitude: " + longitude;
                //alert(mesg);
                //alert(address);
                $('#latid').val(latitude);
                $('#longid').val(longitude);
            });
        });
    });
</script>
<script>
    $(function () {
        $("#dob_reg").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            //minDate: 'mm-dd-yyyy',
            maxDate:'-18Y',
            changeYear: true,
            onClose: function (selectedDate) {
                //if(selectedDate){$("#dob_reg").datepicker("option", "minDate", selectedDate);}
            }
        });
    });
</script>
@stop
