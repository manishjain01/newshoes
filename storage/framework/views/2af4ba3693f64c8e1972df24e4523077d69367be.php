<?php $__env->startSection('content'); ?> 

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
   <?php if(Session::has('alert-sucess')): ?>
   <?php echo Session::get('alert-sucess'); ?>

   <?php endif; ?>
   <?php if(Session::has('alert-error')): ?>
   <?php echo Session::get('alert-error'); ?>

   <?php endif; ?>
   </span>


      <?php echo $__env->make('includes.frontend.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <div class="tab-content col-md-12 add_book1">
         <div id="addres" class="tab-pane fade in active">
          <?php echo Form::model($user,['route'=>['updateAddress',$user->id],'files'=>true,'id' =>'edit_form','style'=>'display:block']); ?>   
                <?php echo csrf_field(); ?>

               <div class="form-group col-md-12">
                  <?php echo Form::textarea('address_1',null,['class'=>'form-control input-group-lg textarea frm_area','placeholder'=>'Address line 1']); ?>

				  <div class="error"><?php echo e(str_replace(' 1', '', $errors->first('address_1'))); ?></div>
               </div>
                
                
                
               <div class="form-group col-md-12">
                   <?php echo Form::textarea('address_2',null,['class'=>'form-control input-group-lg textarea frm_area','placeholder'=>'Address line 2']); ?>

               </div>
               
               
               
               <div class="form-group col-md-12">
                  <?php echo Form::text('pincode',null,['class'=>'form-control input-group-lg','placeholder'=>'Pincode']); ?>

                    <div class="error"><?php echo e($errors->first('pincode')); ?></div>
               </div>
               
               
               
               <div class="form-group col-md-12 drp_down">
                   <?php echo Form::select('state', $state, null, ['id'=>'state','class' => 'form-control']); ?>

                    <div class="error"><?php echo e($errors->first('state')); ?></div>
               </div>
               
               
               
               <div class="form-group col-md-12 drp_down">
                 <?php echo Form::select('city', $city, null, ['id'=>'city','class' => 'form-control']); ?>

                    <div class="error"><?php echo e($errors->first('city')); ?></div>
               </div>
              
               <div class="col-md-4"></div>
               <div class="col-md-4">
                   <?php echo Form::submit('Submit',['class' => 'btn btn-default btn-submit']); ?>

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