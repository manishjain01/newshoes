@extends('layouts.frontend')
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
<section class="blog_grid_area">
    <section class="content-header">
        <h1>
            <?php //echo $pageTitle; ?>
        </h1>
        <?php /* ?>@include('includes.frontend.breadcrumb')<?php */ ?>
    </section>
    <div class="container">

        <div class="row">

            @include('includes.frontend.sidebar')

            <div class="col-md-9 Edit_form_area">
                <div class="page-title">
                    <h3>{{ trans('front.EDIT_PRODUCT')}}</h3>
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
                    {!! Form::model($product,['method'=>'patch','route'=>['products.update',$product->id],'files'=>true]) !!}
                    {!! csrf_field() !!}


                    <div class="form-group">
                        {!! Form::label(trans('front.PRODUCT_NAME'),null,['class'=>'required_label']) !!}
                        {!! Form::text('product_name',null,['class'=>'form-control','placeholder'=>trans('front.PRODUCT_NAME')]) !!}
                        <div class="error">{{ $errors->first('product_name') }}</div>
                    </div>

                    <?php /*?><div class="form-group">
                        {!! Form::label('Product Title',null,['class'=>'required_label']) !!}
                        {!! Form::text('product_title',null,['class'=>'form-control','placeholder'=>'Product Title']) !!}
                        <div class="error">{{ $errors->first('product_title') }}</div>
                    </div><?php */ ?>
                    <div class="form-group">
                        {!! Form::label(trans('front.PRODUCT_DES'),null,['class'=>'required_label']) !!}
                        {!! Form::textarea('product_description',null,['class'=>'form-control','placeholder'=>trans('front.PRODUCT_DES'),'rows'=>'4','cols'=>'3']) !!}
                        <div class="error">{{ $errors->first('product_description') }}</div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(trans('front.GENDER'),null,['class'=>'required_label']) !!}                           
                        <?php $data = Config::get('global.gender_list'); ?>
                        {!! Form::select('gender', $data, null, ['id'=>'gender_reg','class' => 'form-control gender']) !!} 
                        <div class="error">{{ str_replace('The gender must be between 1 and 4', 'Gender is required', $errors->first('gender')) }}</div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(trans('front.PRODUCT_PHONE'),null,['class'=>'required_label']) !!}
                        {!! Form::text('product_phone',null,['class'=>'form-control','placeholder'=>trans('front.PRODUCT_PHONE')]) !!}
                        <div class="error">{{ $errors->first('product_phone') }}</div>
                    </div>


                    <div class="form-group">
                        {!! Form::label(trans('front.DOB'),null,['class'=>'required_label']) !!}
                       
                            {!! Form::text('dob',null,['id'=>'dob_reg','class'=>'form-control','placeholder'=>trans('front.DOB')]) !!}
                           
                        <div class="error">{{ $errors->first('dob') }}</div> 
                    </div>


                    <div class="form-group">
                        {!! Form::label(trans('front.PRODUCT_LOCATION'),null,['class'=>'required_label']) !!}
                        {!! Form::text('product_location',null,['id'=>'product_location','class'=>'form-control','placeholder'=>trans('front.PRODUCT_LOCATION')]) !!}
                        <div class="error">{{ $errors->first('product_location') }}</div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group create-img">
                            {!! Form::label(trans('front.PRODUCT_IMAGE'),null,['class'=>'required_label']) !!}
                            {!! Form::file('profile_img1',['id'=>'profile_img1','onChange'=>'readURL(this,1);','style'=>'display:none;']) !!}
                            
                                <?php if (!empty($product->profile_img1)) { ?>
                                    <label for="profile_img1">
                                        <img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img1 }}" id="img1" alt="" class="" width="50" />
                                    </label>
                                <?php /* ?><span onclick = "remove_img('{{ $product->profile_img1 }}', {{$product->id}}, 'profile_img1', 1)" class="rem_img">Remove</span><?php */ ?>
                                <?php } else { ?>
                                    <label for="profile_img1">
                                        <img src="{{asset("img/no_image.png")}}" id="img1" alt="" class="" width="50" />
                                    </label>
                                <?php } ?>
                            
                            <div class="error">{{ $errors->first('profile_img1') }}</div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
							{!! Form::label(trans('front.PRODUCT_IMG_DES1'),null,['class'=>'']) !!}
                            {!! Form::textarea('description1',null,['class'=>'form-control','rows'=>"3",'placeholder'=>trans('front.PRODUCT_IMG_DES1')]) !!}
                            <div class="error">{{ $errors->first('description1') }}</div>
                        </div> </div>

                    <div style="clear:both;"></div>
                    <div class="col-md-2">
                        <div class="form-group create-img">
                            {!! Form::label(trans('front.PRODUCT_IMAGE').'2',null,['class'=>'']) !!}
                            {!! Form::file('profile_img2',['id'=>'profile_img2','onChange'=>'readURL(this,2);','style'=>'display:none;']) !!}
                        
                                <?php if (!empty($product->profile_img2)) { ?>
                                    <label for="profile_img2">
                                        <img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img2 }}" id="img2" alt="" class="" width="50" />
                                         
                                    </label>
                                <span onclick = "remove_img('{{ $product->profile_img2 }}', {{$product->id}}, 'profile_img2', 2)" class="rem_img">{{ trans('front.REMOVE') }}</span>
                                <?php } else { ?>
                                    <label for="profile_img2">
                                        <img src="{{asset("img/no_image.png")}}" id="img2" alt="" class="" width="50" />
                                       
                                    </label>
                                <span id="remove_img2"></span>
                                <?php } ?>
                   
                            <div class="error">{{ $errors->first('profile_img2') }}</div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
						{!! Form::label(trans('front.PRODUCT_IMG_DES1'),null,['class'=>'']) !!}
                            {!! Form::textarea('description2',null,['class'=>'form-control','rows'=>"3",'placeholder'=>trans('front.PRODUCT_IMG_DES1').'2']) !!}
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="col-md-2">
                        <div class="form-group create-img">
                            {!! Form::label(trans('front.PRODUCT_IMAGE').'3',null,['class'=>'']) !!}
                            {!! Form::file('profile_img3',['id'=>'profile_img3','onChange'=>'readURL(this,3);','style'=>'display:none;']) !!}                      
                           
                                <?php if (!empty($product->profile_img3)) { ?>
                                    <label for="profile_img3">
                                        <img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img3 }}" id="img3" alt="" class="" width="50" />
                                    </label>
                                <span onclick = "remove_img('{{ $product->profile_img3 }}', {{$product->id}}, 'profile_img3', 3)" class="rem_img">{{ trans('front.REMOVE') }}</span>
                                <?php } else { ?>
                                    <label for="profile_img3">
                                        <img src="{{asset("img/no_image.png")}}" id="img3" alt="" class="" width="50" />
                                    </label>
                                <span id="remove_img3"></span>
                                <?php } ?>
                            
                            <div class="error">{{ $errors->first('profile_img3') }}</div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
						{!! Form::label(trans('front.PRODUCT_IMG_DES1'),null,['class'=>'']) !!}
                            {!! Form::textarea('description3',null,['class'=>'form-control','rows'=>"3",'placeholder'=>trans('front.PRODUCT_IMG_DES1').'3']) !!}
                        </div> </div>
                    <div style="clear:both;"></div>
                    <div class="col-md-2">
                        <div class="form-group create-img">
                            {!! Form::label(trans('front.PRODUCT_IMAGE').'4',null,['class'=>'']) !!}
                            {!! Form::file('profile_img4',['id'=>'profile_img4','onChange'=>'readURL(this,4);','style'=>'display:none;']) !!}
                          
                                <?php if (!empty($product->profile_img4)) { ?>
                                    <label for="profile_img4">
                                        <img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img4 }}" id="img4" alt="" class="" width="50" />
                                    </label>
                            <span onclick = "remove_img('{{ $product->profile_img4 }}', {{$product->id}}, 'profile_img4', 4)" class="rem_img">{{ trans('front.REMOVE') }}</span>
                                <?php } else { ?>
                                    <label for="profile_img4">
                                        <img src="{{asset("img/no_image.png")}}" id="img4" alt="" class="" width="50" />
                                    </label>
                                <span id="remove_img4"></span>
                                <?php } ?>
                           
                             <div class="error">{{ $errors->first('profile_img4') }}</div>
                        </div></div>
                    <div class="col-md-10">
                        <div class="form-group">
						{!! Form::label(trans('front.PRODUCT_IMG_DES1'),null,['class'=>'']) !!}
                            {!! Form::textarea('description4',null,['class'=>'form-control','rows'=>"3",'placeholder'=>trans('front.PRODUCT_IMG_DES1').'4']) !!}
                        </div></div>
                    <div style="clear:both;"></div>

                    <div class="col-md-2">
                        <div class="form-group create-img">
                            {!! Form::label(trans('front.PRODUCT_IMAGE').'5',null,['class'=>'']) !!}
                            {!! Form::file('profile_img5',['id'=>'profile_img5','onChange'=>'readURL(this,5);','style'=>'display:none;']) !!}
                           
                                <?php if (!empty($product->profile_img5)) { ?>
                                    <label for="profile_img5">
                                        <img src="{{ WEBSITE_URL }}public/uploads/{{ $product->profile_img5 }}" id="img5" alt="" class="" width="50" />
                                    </label>
                            <span onclick = "remove_img('{{ $product->profile_img5 }}', {{$product->id}}, 'profile_img5', 5)" class="rem_img">{{ trans('front.REMOVE') }}</span>
                                <?php } else { ?>
                                    <label for="profile_img5">
                                        <img src="{{asset("img/no_image.png")}}" id="img5" alt="" class="" width="50" />
                                    </label>
                            <span id="remove_img5"></span>
                                <?php } ?>
                            
                             <div class="error">{{ $errors->first('profile_img5') }}</div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
						{!! Form::label(trans('front.PRODUCT_IMG_DES1'),null,['class'=>'']) !!}
                            {!! Form::textarea('description5',null,['class'=>'form-control','rows'=>"3",'placeholder'=>trans('front.PRODUCT_IMG_DES1').'5']) !!}
                        </div> </div>
                    <div style="clear:both;"></div>

                    <div class="form-group">
                        {!! Form::label(trans('front.BODY_TYPE'),null,['class'=>'required_label']) !!}
                        {!! Form::select('bodytype', $bodytype, null, ['class' => 'form-control gender']) !!}
                        <div class="error">{{ $errors->first('bodytype') }}</div>
                    </div>
                    {!! Form::label(trans('front.HEIGHT'),null,['class'=>'required_label']) !!}{{UNIT}}
                    <div class="form-group">
                        {!! Form::select('height', $height, null, ['class' => 'form-control gender']) !!}
                        <div class="error">{{ $errors->first('height') }}</div>
                    </div>
                    {!! Form::label(trans('front.BREAST_SIZE'),null,['class'=>'required_label']) !!}{{UNIT}}
                    <div class="form-group">
                        {!! Form::select('breastsize', $breastsize, null, ['class' => 'form-control gender']) !!}
                        <div class="error">{{ $errors->first('breastsize') }}</div>
                    </div>
                    {!! Form::label(trans('front.BREAST_CUP'),null,['class'=>'']) !!}
                    <div class="form-group">
                        {!! Form::text('breast_cup', null, ['class' => 'form-control']) !!}
                        <div class="error">{{ $errors->first('breast_cup') }}</div>
                    </div>
                    {!! Form::label(trans('front.PIERCING'),null,['class'=>'']) !!}
                    <div class="form-group">
                        {!! Form::radio('piercing', 'YES',null, ['class' => '']) !!}&nbsp;{{trans('front.YES')}}&nbsp;&nbsp;
                        {!! Form::radio('piercing', 'NO',null, ['class' => '']) !!}&nbsp;{{trans('front.NO')}}
                        <div class="error">{{ $errors->first('piercing') }}</div>
                    </div>
                    {!! Form::label(trans('front.TATOOS'),null,['class'=>'']) !!}
                    <div class="form-group">
                        {!! Form::radio('tatoos', 'YES',null, ['class' => '']) !!}&nbsp;{{trans('front.YES')}}&nbsp;&nbsp;
                        {!! Form::radio('tatoos', 'NO',null, ['class' => '']) !!}&nbsp;{{trans('front.NO')}}
                        <div class="error">{{ $errors->first('tatoos') }}</div>
                    </div>
                    {!! Form::label(trans('front.STATUS'),null,['class'=>'required_label']) !!}
                    <div class="form-group">
                        <?php $status_list = Config::get('global.status_list'); ?>
                        {!! Form::select('status', $status_list, null, ['class' => 'form-control gender']) !!}
                        <div class="error">{{ $errors->first('status') }}</div>
                    </div>
                    <input type="hidden" name="seller_id" value={!! $product->seller_id !!}>
                    <input type="hidden" name="lat" id="latid">
                    <input type="hidden" name="lng" id="longid">

                    <div class="reg_chose form-group">
                        {!!  Html::decode(Html::link(route('myaccount'),trans('front.CANCEL'),['class'=>'btn btn-primary btn_can btn-center'])) !!}
                        
                        {!! Form::submit(trans('front.UPDATE'),['class'=>'btn form-control login_btn','id'=>'registration_form1'])!!}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function readURL(input, id) {
        if (Math.round(input.files[0].size / (1024 * 1024)) > 10) {
             alert('Please select image size less than 10 MB');
            return false;
        } else {
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img' + id).attr('src', e.target.result);
                $('#remove_img' + id).addClass("rem_img").text('<?=trans('front.REMOVE')?>');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            //$('#img').attr('src', '');
            alert('Invalid Image type format.');
        }
    }
    }
    
    /*$('#remove_img1').on('click', function() { 
    $('#profile_img1').val(''); 
    $('#img1').attr('src', '{{asset("img/no_image.png")}}');
    });*/
    $('#remove_img2').on('click', function() { 
    $('#profile_img2').val(''); 
    $('#img2').attr('src', '{{asset("img/no_image.png")}}');
    });
    $('#remove_img3').on('click', function() { 
    $('#profile_img3').val(''); 
    $('#img3').attr('src', '{{asset("img/no_image.png")}}');
    });
    $('#remove_img4').on('click', function() { 
    $('#profile_img4').val(''); 
    $('#img4').attr('src', '{{asset("img/no_image.png")}}');
    });
    $('#remove_img5').on('click', function() { 
    $('#profile_img5').val(''); 
    $('#img5').attr('src', '{{asset("img/no_image.png")}}');
    });

    $('#profile_img1').change(function () {
        var img1 = $('#profile_img1')[0].files[0];
    });
    $('#profile_img2').change(function () {
        var img1 = $('#profile_img2')[0].files[0];
    });
    $('#profile_img3').change(function () {
        var img1 = $('#profile_img3')[0].files[0];
    });
    $('#profile_img4').change(function () {
        var img1 = $('#profile_img4')[0].files[0];
    });
    $('#profile_img5').change(function () {
        var img1 = $('#profile_img5')[0].files[0];
    });
    
   
    function remove_img(image_name, produt_id, image_field, id){
        
       
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
                data: {image_name: image_name,produt_id: produt_id,image_field: image_field},
                success: function (msg) {
                    console.log(msg);
                    msg1 = JSON.parse(msg);                  
                    $('.success-msg').html(msg1.message);
                    $("#img"+id).attr("src", '{{asset("img/no_image.png")}}');
                    $(".loading-cntant").css("display", "none");
                    
                },
                error: function (data) {
                }
            });
       
    }
    
    google.maps.event.addDomListener(window, 'load', function () {

            var places = new google.maps.places.Autocomplete(document.getElementById('product_location'));
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
</script>
@stop