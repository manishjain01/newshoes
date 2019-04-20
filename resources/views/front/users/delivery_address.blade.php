@extends('layouts.inner')
@section('content') 

<style>
 .dash_tab .add_book1 .textarea
    {
        height:80px; !important
    } 
</style>
 <section class="edit_address">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">  
<!--                        <h3 class="add_heading block animated moveUp">
                            <span class="one">Address</span> <span>----- Summary</span> <span>----- Payment </span></h3>-->
                    </div>
                    <div class="col-md-12 edit_home">
                        {!! Form::model($order,['route'=>['updateDeliveryAddress',$order->id,$page],'files'=>true,'id' =>'edit_form','style'=>'display:block']) !!}   
                         {!! csrf_field() !!}
                            <div class="col-md-12">
                                <h3>Delivery Info</h3>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::text('first_name',null,['class'=>'form-control','placeholder'=>'First Name']) !!}
                                <div class="error">{{ $errors->first('first_name') }}</div>                                
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Last Name']) !!}
                                <div class="error">{{ $errors->first('last_name') }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
                                <div class="error">{{ $errors->first('email') }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Phone Number']) !!}
                                <div class="error">{{ $errors->first('phone') }}</div>
                            </div>
                             <div class="form-group col-md-12">
                                {!! Form::text('pincode',null,['class'=>'form-control','placeholder'=>'Pincode']) !!}
                                <div class="error">{{ $errors->first('pincode') }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::textarea('address_1',null,['class'=>'form-control','placeholder'=>'Address 1']) !!}
                               <div class="error">{{ str_replace(' 1', '', $errors->first('address_1')) }}</div>
                            </div>
                         <div class="form-group col-md-6" style="min-height:88px;">
                                {!! Form::textarea('address_2',null,['class'=>'form-control','placeholder'=>'Address 2']) !!}
                                <div class="error">{{ $errors->first('address_2') }}</div>
                            </div>
                            <div class="form-group col-md-6 drp_down">
                                {!! Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']) !!}
                                <div class="error">{{ $errors->first('state') }}</div>
                            </div>  
                            <div class="form-group col-md-6 drp_down">
                                {!! Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']) !!}
                                    <div class="error">{{ $errors->first('city') }}</div>
                            </div>                    
                            <div class="form-group col-md-12">
                                {!! Form::submit('Save Address',['class' => 'btn btn-default'])!!}
                                
                                <?php if($page == 'bynow'){
                                $url = URL::to('bynow/').'/'.$order->order_no;
                                }else if($page == 'order'){
                                   $url = URL::to('checkout/'); 
                                 }else if($page == 'guest'){
                                   $url = URL::to('guest_checkout/');
                                 }else if($page == 'ByNow'){
                                   $url = URL::to('ByNow/').'/'.$order->order_no; 
                                 }?>
                                
                                <button type="button" class="btn btn-default clnc" onClick="location.href ='{{$url}}';">Cancel</button>
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
