<!-- Content Wrapper. Contains page content -->
@extends('layouts.home')

@section('content')  
<script>
    $(function() {
        $("#dob_reg").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            //minDate: 'mm-dd-yyyy',
            maxDate:'-18Y',
            changeYear: true,
            onClose: function(selectedDate) {
                //if(selectedDate){$("#dob_reg").datepicker("option", "minDate", selectedDate);}
            }
        });
    });
</script>
<!--================End Banner Area =================-->
<!--================Blog grid Area =================-->
<section class="blog_grid_area">
    <section class="content-header">
        <h1>
            <?php //echo $pageTitle; ?>
        </h1>
        <?php /* ?>@include('includes.frontend.breadcrumb')<?php */ ?>
    </section>
    <div class="container">
        <div class="row"><?php //pr($errors);exit;?>
            @include('includes.frontend.sidebar')
            <div class="col-md-9 Edit_form_area">
                <div class="page-title">
                    <h3>{{ trans('front.EDIT_PROFILE') }}</h3>
                </div>
                <span class="msg1">
                @if(Session::has('alert-sucess'))
                {!! Session::get('alert-sucess') !!}
                @endif
                @if(Session::has('alert-error'))
                {!! Session::get('alert-error') !!}
                @endif
                </span>
                <div class="registration_form_s">
                    {!! Form::model($user,['route'=>['updateProfile',$user->id],'files'=>true,'id' =>'edit_form']) !!}
                    {!! csrf_field() !!}
                    <div class="col-md-10 buyer-edit-img">
                        <div class="form-group">
                            {!! Form::label(trans('front.PROFILE_IMG'),null,['class'=>'']) !!}
                            {!! Form::file('profile_img',['id'=>'profile_img','onChange'=>'readURL(this);','style'=>'display:none;']) !!}
                        </div>
                        <span>
                            <?php if (!empty($user->profile_img)) { ?>
                                <label for="profile_img">
                                    <img src="public/uploads/{{ $user->profile_img }}" id="img" alt="" class="" width="50" />
                                </label>
                            <span onclick = "remove_img()" class="rem_img userimg">{{trans('front.REMOVE')}}</span>                            
                            <?php } else { ?>
                                <label for="profile_img">
                                    <img src="{{asset("img/no_image.png")}}" id="img" alt="" class="" width="50" />
                                </label>
                            <span id="remove_img1"></span>
                            <?php } ?>
                        </span>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">  
                            {!! Form::label(trans('front.EMAIL'),null,['class'=>'required_label']) !!}
                            {!! Form::text('email',null,['class'=>'form-control input-group-lg','readonly','placeholder'=>trans('front.EMAIL')]) !!}
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">         
                            {!! Form::label(trans('front.NAME'),null,['class'=>'required_label']) !!}
                            {!! Form::text('first_name',null,['class'=>'form-control input-group-lg','id'=>'first_name','readonly','placeholder'=>trans('front.NAME')]) !!}
                            <div class="error">{{ $errors->first('first_name') }}</div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label(trans('front.DOB'),null,['class'=>'required_label']) !!}
                                {!! Form::text('dob',null,['id'=>'dob_reg','class'=>'form-control','placeholder'=>trans('front.DOB')]) !!}
                                
                            <div class="error">{{ $errors->first('dob') }}</div> 
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label(trans('front.GENDER'),null,['class'=>'required_label']) !!}
                            <div class="gender1">
                                <?php $data = Config::get('global.gender_list'); ?>
                                {!! Form::select('gender', $data, null, ['id'=>'gender_reg','class' => 'form-control gender']) !!}  

                            </div>
                        </div>
                    </div>
                    @if($user->role_id == 2)
                    <div class="col-md-5">
                        <div class="form-group" id="looking_for">
                            {!! Form::label(trans('front.LOOKING_FOR'),null,['class'=>'required_label']) !!}
                            <div class="looking1">
                                <?php $data = Config::get('global.lookingfor_list'); ?>
                                {!! Form::select('looking', $data, null, ['id'=>'looking_reg','class' => 'form-control gender']) !!}                                           
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-10">
                        <div class="form-group">       
                            {!! Form::label(trans('front.PHONE'),null,['class'=>'required_label']) !!}
                            {!! Form::text('phone',null,['class'=>'form-control input-group-lg','placeholder'=>trans('front.PHONE')]) !!}
                            <div class="error">{{ $errors->first('phone') }}</div>   
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label(trans('front.ADDRESS'),null,['class'=>'required_label']) !!}
                            {!! Form::text('address',null,['class'=>'form-control input-group-lg','placeholder'=>trans('front.ADDRESS'),'id'=>'txtPlaces']) !!} 
                            <div class="error">{{ $errors->first('address') }}</div>  
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="col-md-10">
                        <div class="reg_chose  form-group">
                            {!! Form::hidden('lat',null,['class'=>'','id'=>'latid']) !!}
                            {!! Form::hidden('lng',null,['class'=>'','id'=>'longid']) !!}
                            {!!  Html::decode(Html::link(route('myaccount'),trans('front.CANCEL'),['class'=>'btn btn-primary btn_can btn-center'])) !!}
                            {!! Form::submit(trans('front.UPDATE'),['class' => 'btn form-control login_btn'])!!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    
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
    
    
    function readURL(input) {
        if (Math.round(input.files[0].size / (1024 * 1024)) > 10) {
             alert('Please select image size less than 10 MB');
            return false;
        } else {
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#remove_img1').addClass("rem_img reg_img").text('<?=trans('front.REMOVE')?>');
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            //$('#img').attr('src', '');
            alert('Invalid Image type format.');
        }
    }
    }
    
    $('#remove_img1').on('click', function() { 
    $('#profile_img').val(''); 
    $('#img').attr('src', '{{asset("img/no_image.png")}}');
    //$('#remove_img1').text('');
    });
    $('#profile_img').change(function () {
        var img1 = $('#profile_img')[0].files[0];
    });
    
    
    function remove_img(){        
       $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
           
            $(".loading-cntant").css("display", "block");
            $.ajax({
                type: "POST",
                url: '/<?php echo WEBSITEURL ?>remove_userimg',
                data: {},
                success: function (msg) {
                    console.log(msg);
                    msg1 = JSON.parse(msg);                  
                    $('.success-msg').html(msg1.message);
                    $("#img").attr("src", '{{asset("img/no_image.png")}}');
                    $(".loading-cntant").css("display", "none");
                    
                },
                error: function (data) {
                }
            });
       
    }
</script>
@stop
