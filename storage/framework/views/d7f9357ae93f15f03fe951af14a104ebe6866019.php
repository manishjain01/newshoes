<?php $__env->startSection('content'); ?>
<style>
.input-group[class*=col-]{
padding-top:24px!important;
}

.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group 
{
    margin-left: 0px !important;
    margin-top: 22px !important;
	
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box-header with-border">
            <h3 class="pull-right">  
                <?php echo Html::decode(Html::link(route('admin.products.index'),"<i class='fa  fa-arrow-left'></i>".trans('admin.BACK'),['class'=>'btn btn-block btn-primary'])); ?>

            </h3>
        </div>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
            <?php echo Form::open(['route'=>['web.update_image',$id],'files'=>true]); ?>  
            <div class="box-body">
                        <div class="col-md-12">
                            <?php if(!empty($attachment)): ?>
                            <?php foreach($attachment as $attachments): ?>                        
                            <div class="col-md-1 text18" id = "attach<?php echo e($attachments->id); ?>">                                          
                               <img class="image1" src="<?php echo e(PRODUCT_IMAGE_URL.$attachments->image_name); ?>"  width="80"/>
                               <p onclick = "remove_attachment(<?php echo e($attachments->id); ?>, <?php echo e($attachments->product_id); ?>)" class="text20"><i class="fa fa-trash"></i></p>
                            <?php echo e($attachments->product_image_color->color_name); ?>

                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <div class="control-group" id="fields">
                                <label class="control-label" for="field1">
                                    Media
                                </label>
                                <div class="controls">
                                    <div class="entry input-group col-md-12">
                                        <input class="upload-button image" name="image_attr[][image_name]" type="file" value="Upload Your Fille" accept="image/*" onChange = readURL(this);>                                        
                                         <?php echo Form::select('image_attr[][color_id]', $color_List, null, ['selected'=>'selected','class' => 'form-control']); ?>

                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
</div><!-- /.box-body -->

            
            <div class="box-footer">
                <div class="pull-right">
                    <?php echo Html::decode(Html::link(route('admin.products.index'),trans('admin.CANCEL'),['class'=>'btn btn-default'])); ?>

                    <?php echo Form::submit(trans('admin.SAVE'),['class' => 'btn btn-info', 'id' => 'submit']); ?>

                </div>
            </div>
            <!-- /.box-footer -->
            <?php echo Form::close(); ?>

        </div><!-- /.box -->
    </section><!-- /.content -->
</div>
<script> 
	
	
	
	$('#submit').click(function(e){
		var image = $('.image').val();
		
		if(image=='')
		{
			alert('please select image file');
			return false;
		}
		});
	
	   
    function readURL(input) { 
		
	var _URL = window.URL || window.webkitURL;
	 var file, img;

    if ((file = input.files[0])) {
		
		
        img = new Image();
        img.onload = function() {
			
			height = this.height;
			width = this.width;
					
			if ((height > 450 && height < 1500) && (width > 400 && width < 1500)) {
				alert("Uploaded image has valid Height and Width.");
				return true;
			}
			else {
				alert("Width must have between 500 to 600 And Height must have between 650 to 750 ");
				$(input).closest(".image").val(null);
				return false;
			}
        };
        img.src = _URL.createObjectURL(file);
    }
	
	
        if (Math.round(input.files[0].size / (1024 * 1024)) > 10) {
			           //console.log(input);
             alert('Please select image size less than 10 MB');
            return false;
        } else {
            console.log("width", input.files[0].width);
            var image = new Image();
            image.src = input.files[0];
                    
            console.log(input.files[0]);
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
            $(input).closest(".image").val(null);
            return false;
        }
    }
    }
    
    /*$('#remove_img1').on('click', function() { 
    $('#profile_img').val(''); 
    $('#img').attr('src', '<?php echo e(asset("img/no_image.png")); ?>');
    //$('#remove_img1').text('');
    });
    $('#profile_img').change(function () {
        var img1 = $('#profile_img')[0].files[0];
    });*/
    
    
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
                url: '/<?php echo WEBSITE_ADMIN_URL ?>remove_userimg',
                data: {},
                success: function (msg) {
                    console.log(msg);
                    msg1 = JSON.parse(msg);                  
                    $('.success-msg').html(msg1.message);
                    $("#img").attr("src", '<?php echo e(asset("img/no_image.png")); ?>');
                    $(".loading-cntant").css("display", "none");
                    
                },
                error: function (data) {
                }
            });
       
    }
</script>
<script>
            $(document).on('show', '.accordion', function(e) {
    //$('.accordion-heading i').toggleClass(' ');
    $(e.target).prev('.accordion-heading').addClass('accordion-opened');
    });
            $(document).on('hide', '.accordion', function(e) {
    $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
            //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
    });</script>
<script>
            $(function() {
            $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
                    var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find('input').val('');
                    controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove', function(e) {
            $(this).parents('.entry:first').remove();
                    e.preventDefault();
                    return false;
            });
            });
            
           
        
        function remove_attachment(id, product_id){
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
                            url: '<?php echo WEBSITE_ADMIN_URL ?>remove_attachment',
                            data: {id:id, product_id:product_id},
                            success: function (msg) {
                            console.log(msg);
                                    msg1 = JSON.parse(msg);
                                    $('.success-msg').html(msg1.message);
                                    //$("#attach"+id).attr("src", '<?php echo e(asset("img/no_image.png")); ?>');
                                    $("#attach" + id).text('');
                                    $(".loading-cntant").css("display", "none");
                            },
                            error: function (data) {
                            }
                    });
            }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>