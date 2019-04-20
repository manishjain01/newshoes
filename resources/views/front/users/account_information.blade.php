@extends('layouts.inner')
@section('content')  
<section class="banner_dash">
    <div class="container-fluid">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <h2 class="heading_page dsh_hrading">My Dashboard</h2>
        </div>
    </div>
</section>
<section class="dash_tab">
    <div class="container">
        <span class="msg1" style="color:#38B861;">
            @if(Session::has('alert-sucess'))
            {!! Session::get('alert-sucess') !!}
            @endif
            @if(Session::has('alert-error'))
            {!! Session::get('alert-error') !!}
            @endif
        </span>

        @include('includes.frontend.sidebar')




        <div class="tab-content col-md-12">
            <div id="account_info" class="tab-pane fade in active">

                {!! Form::model($user,['route'=>['updateProfile',$user[0]->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']) !!}
                {!! csrf_field() !!}
                <div class="form-group  col-md-12">
                    {!! Form::text('first_name',$user[0]->first_name,['class'=>'form-control input-group-lg','placeholder'=>'First Name','required' => 'required']) !!}
                </div>
                <div class="error">{{ $errors->first('first_name') }}</div>  


                <div class="form-group  col-md-12">
                    {!! Form::text('last_name',$user[0]->last_name,['class'=>'form-control input-group-lg','placeholder'=>'Last Name']) !!}
                </div>
                <div class="error">{{ $errors->first('last_name') }}</div>  



                <div class="form-group col-md-12">
                    {!! Form::text('email',$user[0]->email,['class'=>'form-control input-group-lg','placeholder'=>'Email','readonly','required' => 'required']) !!}
                </div>
                <div class="form-group  col-md-12">
                    {!! Form::text('phone',$user[0]->phone,['class'=>'form-control input-group-lg','placeholder'=>'Phone','required' => 'required']) !!}
                <div class="error">{{ str_replace('The phone format is invalid.', 'Phone number is invalid.', $errors->first('phone')) }}</div> 
                </div>
                
                <div class="form-group col-md-12">
                    <div data-provides="fileupload" class="fileupload fileupload-new">
                        <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail">
                            @if(isset($user[0]->profile_img) && !empty($user[0]->profile_img)) 
                            @if(substr($user[0]->profile_img, 0, 4) == 'http')
                            <img alt="" src="{{$user[0]->profile_img}}">
                            @else    
                            <img alt="" src="{{USER_IMAGE_URL.$user[0]->profile_img}}">
                            @endif
                            @else
                            <img alt="" src="{{asset('img/no-image.png')}}">   
                            @endif
                        </div>
                        <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"> </div>
                        <div class="btn_file_uploadss"> <span class="btn btn-alt btn-primary btn-file"> <span class="fileupload-new"> <i class="fa fa-paper-clip"></i> Select image </span> <span class="fileupload-exists"> <i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" name="profile_img" />
                            </span>
                            <label for="required" generated="true" class="error"></label>
                        </div>
                    </div>
                     <div class="error">{{ $errors->first('profile_img') }}</div>
                </div>

                
                
                <div class="col-md-4"></div>
                <div class="form-group  col-md-4">
                    {!! Form::submit('Submit',['class' => 'btn btn-default btn-submit'])!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@stop
