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
      <div class="tab-content col-md-12 add_book1">
         <div id="chng_pass" class="tab-pane fade in active">
            {!! Form::open(array('id'=>'education', 'method'=>'post','route'=>['update_password'])) !!}
			{!! csrf_field() !!}
               <div class="form-group col-md-12">
                  {!! Form::password('old_password',['class'=>'form-control','placeholder'=>'Old Password']) !!}
                  <div class="error">{{ $errors->first('old_password') }}</div>
               </div>
               <div class="form-group col-md-12">
                   {!! Form::password('new_password',['class'=>'form-control input-group-lg','placeholder'=>'New Password']) !!}
                    <div class="error">{{ $errors->first('new_password') }}</div>
               </div>
               <div class="form-group col-md-12">
                  {!! Form::password('confirm_password',['class'=>'form-control input-group-lg','placeholder'=>'Confirm New Password']) !!}
                  <div class="error">{{ $errors->first('confirm_password') }}</div>
               </div>
               <div class="col-md-2"></div>
               <div class="form-group btn_chng1 col-md-4">
                  <button type="submit" class="btn btn-default chng_p" id="cancel_btn">Cancel</button>
               </div>
               <div class="form-group  col-md-4">
                  {!! Form::submit('Update',['class' => 'btn btn-default btn-submit'])!!}
               </div>
             {!! Form::close() !!}
         </div>
      </div>
   </div>
</section>

 <script>
 $("#cancel_btn").on('click', function(event){
	 
	window.location.href = '{{URL::to("/")}}/account_information';
    return false;
});
 </script>
@stop
