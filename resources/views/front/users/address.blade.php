@extends('layouts.inner')
@section('content') 

<style>
 .dash_tab .add_book1 .textarea
    {
        height:80px; !important
    } 
</style>
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
         <div id="addres" class="tab-pane fade in active">
          {!! Form::model($user,['route'=>['updateAddress',$user->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']) !!}   
                {!! csrf_field() !!}
               <div class="form-group col-md-12">
                  {!! Form::textarea('address_1',null,['class'=>'form-control input-group-lg textarea frm_area','placeholder'=>'Address line 1']) !!}
				  <div class="error">{{ str_replace(' 1', '', $errors->first('address_1')) }}</div>
               </div>
                
                
                
               <div class="form-group col-md-12">
                   {!! Form::textarea('address_2',null,['class'=>'form-control input-group-lg textarea frm_area','placeholder'=>'Address line 2']) !!}
               </div>
               
               
               
               <div class="form-group col-md-12">
                  {!! Form::text('pincode',null,['class'=>'form-control input-group-lg','placeholder'=>'Pincode']) !!}
                    <div class="error">{{ $errors->first('pincode') }}</div>
               </div>
               
               
               
               <div class="form-group col-md-12 drp_down">
                   {!! Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']) !!}
                    <div class="error">{{ $errors->first('state') }}</div>
               </div>
               
               
               
               <div class="form-group col-md-12 drp_down">
                 {!! Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']) !!}
                    <div class="error">{{ $errors->first('city') }}</div>
               </div>
              
               <div class="col-md-4"></div>
               <div class="col-md-4">
                   {!! Form::submit('Submit',['class' => 'btn btn-default btn-submit'])!!}
               </div>
            {!! Form::close() !!}
         </div>
      </div>
   </div>
</section>
<script>
   $('select[id="state"]').on('change', function() {
   	
       $.ajaxSetup(
       {
       headers:
       {
       'X-CSRF-Token': $('input[name="_token"]').val()
       }
       });
               var stateId = $(this).val();
               
              
               if (stateId) {
       $.ajax({
       url: '{!! SITE_URL !!}'+'/'+'state_change/' + stateId,
               type: "POST",
               dataType: "json",
               success:function(data) {
   				
   				
               $('select[id="city"]').empty();
                       $.each(data, function(key, value) {
                       $('select[name="city"]').append('<option value="' + key + '">' + value + '</option>');
                       });
               }
       });
       } else{
       //$('select[name="city"]').empty();
       }
       });   
   
</script>
@stop
