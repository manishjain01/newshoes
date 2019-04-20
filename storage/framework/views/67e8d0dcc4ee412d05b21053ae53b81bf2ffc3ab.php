<?php $__env->startSection('content'); ?> 

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
                        <?php echo Form::model($user,['route'=>['update_user_Address',$user->id, $order_no, $page],'files'=>true,'id' =>'edit_form','style'=>'display:block']); ?>   
                         <?php echo csrf_field(); ?>

                            <div class="col-md-12">
                                <h3>Delivery Info</h3>
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo Form::text('first_name',null,['class'=>'form-control','placeholder'=>'First Name']); ?>

                                <div class="error"><?php echo e($errors->first('first_name')); ?></div>                                
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Last Name']); ?>

                                <div class="error"><?php echo e($errors->first('last_name')); ?></div>
                            </div>
                            <div class="form-group col-md-12">
                                <?php echo Form::text('email',null,['class'=>'form-control','placeholder'=>'Email','disabled'=>'disabled']); ?>

                                <div class="error"><?php echo e($errors->first('email')); ?></div>
                            </div>
                            <div class="form-group col-md-12">
                                <?php echo Form::text('phone',null,['class'=>'form-control','placeholder'=>'Phone Number']); ?>

                                <div class="error"><?php echo e($errors->first('phone')); ?></div>
                            </div>
                             <div class="form-group col-md-12">
                                <?php echo Form::text('pincode',null,['class'=>'form-control','placeholder'=>'Pincode']); ?>

                                <div class="error"><?php echo e($errors->first('pincode')); ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo Form::textarea('address_1',null,['class'=>'form-control','placeholder'=>'Address 1']); ?>

                                <div class="error"><?php echo e(str_replace(' 1', '', $errors->first('address_1'))); ?></div>
                            </div>
                            <div class="form-group col-md-6" style="min-height:88px;">
                                <?php echo Form::textarea('address_2',null,['class'=>'form-control','placeholder'=>'Address 2']); ?>

                                <div class="error"><?php echo e($errors->first('address_2')); ?></div>
                            </div>
                             <div class="form-group col-md-6 drp_down">
                                <?php echo Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']); ?>

                                <div class="error"><?php echo e($errors->first('state')); ?></div>
                            </div> 
                            <div class="form-group col-md-6 drp_down">
                                <?php echo Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']); ?>

                                    <div class="error"><?php echo e($errors->first('city')); ?></div>
                            </div>                   
                            <div class="form-group col-md-12">
                                <?php echo Form::submit('Save Address',['class' => 'btn btn-default']); ?>

                                <button type="submit" class="btn btn-default clnc" onClick="location.href ='<?php echo e(URL::to('checkout/')); ?>';">Cancel</button>
                            </div>
                          <?php echo Form::close(); ?>

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
       url: '<?php echo SITE_URL; ?>'+'/'+'state_change/' + stateId,
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>