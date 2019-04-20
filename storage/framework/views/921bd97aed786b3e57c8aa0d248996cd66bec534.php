<section class="footer">
         <div class="container">
            <div class="col-md-3 block animatable bounceInLeft">
               <h3>Quick Link</h3>
               <ul>
                  <li><a href="<?php echo e(URL::to('/')); ?>">Home</a></li>
                  <?php $cmslist = CommonHelpers::getcmslist(); //pr($cmslist);   ?>
                  <?php foreach($cmslist as $list): ?>
                  <li><a href="<?php echo e(URL::to('page/'.$list['slug'])); ?>" ><?php echo e($list['title']); ?></a></li>
                  <?php endforeach; ?> 
                  <li><a href="<?php echo e(URL::to('contact')); ?>">Contact Us</a></li>
               </ul>
            </div>
            <div class="col-md-4 block animatable moveUp">
               <h3>Contact Us</h3>
               <p><?php echo Configure('CONFIG_POSTAL_ADDRESS'); ?></p>
               <p><?php echo e(Configure('CONFIG_PHONE')); ?></p>
               <p><?php echo e(Configure('CONFIG_FROMEMAIL')); ?></p>
            </div>
            <div class="col-md-5 block animatable bounceInRight">
                <h3>Subscribe For Newsletter</h3>
            <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'newsletter_form' ,'class' =>'form-inline')); ?>

                  <div class="form-group">
                     <input type="text" name="news_email" id="news_email" placeholder="Enter your e-mail">
                     <button id="subscribe" class="btn btn-default">SUBSCRIBE</button>
                  </div>
                  <?php echo Form::close(); ?>

                  <p class="success-msg3 login-error" style="color:red;"></p>
               <div class="col-md-12 social_f">
                  <p>
                     <a href="<?php echo e(Configure('CONFIG_FACEBOOK')); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> 
                     <a href="<?php echo e(Configure('CONFIG_LINKEDIN')); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a> 
                     <a href="<?php echo e(Configure('CONFIG_INSTAGRAM')); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </p>
               </div>
            </div>
         </div>
      </section>

      <script>


         $("#subscribe").click(function () {
            var email = $("#news_email").val();

            if (email == '') {
                $('.success-msg3').html("Please Enter Email");
                return false;
            } else if (!validateEmail($.trim(email))) {
                $('.success-msg3').html("Invalid Email Format");
                return false;
            }
            else {
                $.ajax({
                    type: "POST",
                    url: '<?php echo e(URL::to("/")); ?>/newsletter',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#newsletter_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);

                        $('.success-msg3').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
                        //$("#reg_form")[0].reset();
                    },
                    error: function (data) {
                    }
                });
                return false;

            }
        });
      </script>
      
      
      <script type="text/javascript">
         // Trigger CSS animations on scroll.
         // Detailed explanation can be found at http://www.bram.us/2013/11/20/scroll-animations/
         
         // Looking for a version that also reverses the animation when
         // elements scroll below the fold again?
         // --> Check https://codepen.io/bramus/pen/vKpjNP
         
         jQuery(function($) {
         
         // Function which adds the 'animated' class to any '.animatable' in view
         var doAnimations = function() {
         
         // Calc current offset and get all animatables
         var offset = $(window).scrollTop() + $(window).height(),
             $animatables = $('.animatable');
         
         // Unbind scroll handler if we have no animatables
         if ($animatables.length == 0) {
           $(window).off('scroll', doAnimations);
         }
         
         // Check all animatables and animate them if necessary
         $animatables.each(function(i) {
            var $animatable = $(this);
           if (($animatable.offset().top + $animatable.height() - 20) < offset) {
             $animatable.removeClass('animatable').addClass('animated');
           }
         });
         
         };
         
         // Hook doAnimations on scroll, and trigger a scroll
         $(window).on('scroll', doAnimations);
         $(window).trigger('scroll');
         
         });


         $(document).on("click", ".wishlist_btn", function () {

          
           
           var url = '<?php echo e(PRODUCT_IMAGE_URL); ?>';
           var detail_url = '<?php echo e(URL::to("productDetail")); ?>';
           var self = this;
           console.log(self)
           $.ajaxSetup(
                   {
                       headers:
                               {
                                   'X-CSRF-Token': $('input[name="_token"]').val()
                               }
                   });
           var color_id = $(this).attr("attrColor");      
           productId = $(this).attr("attrId");

           var html = [];
           $.ajax({
               type: "POST",
               url: '<?php echo e(URL::to("/")); ?>/addwishlist',
               cache: false,
               data: {product_id: productId,
                      color_id: color_id
                     },
               success: function (msg) {
                   msg1 = JSON.parse(msg);
                   console.log(msg1.count);
                   $(".count_wish").html(msg1.count);
                   $(".count_wish").removeAttr("style");
                   
                   var productlist = msg1.data;

                   $.each(msg1.data, function (key, value) {
                       console.log(value);
                       //console.log('hello',value.id);
                       html.push('<li><a href="' + detail_url + '/' + value.slug  + '/'+value.color_slug+ '"><img src="' + url + value.image_name + '"><h4>' + value.product_title + '</h4> <span class="wishlist_price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<b>' + value.price + '</b></span> <span class="price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<b>' + value.discount_price + '</b></span></a></li>');

                   });
                   $('#wishlist_dropdown').html(html);
                   /*for (var i = 0; productlist.length > i; i++) {
                    console.log('hello',productlist.id);
                    }*/
                   setTimeout(function () {
                       $(self).addClass('wishlist-btn-color');
                       $(self).addClass('wishlist_btn_red');

                   }, 0)
                   $(self).removeClass('wishlist_btn');
               },
               error: function (data) {
               }
           });
           return false;
       });

       $(document).on("click", ".wishlist_btn_red", function () {

           var url = '<?php echo e(PRODUCT_IMAGE_URL); ?>';
           var detail_url = '<?php echo e(URL::to("productDetail")); ?>';

           var self = this;
           console.log(self)
           $.ajaxSetup(
                   {
                       headers:
                               {
                                   'X-CSRF-Token': $('input[name="_token"]').val()
                               }
                   });

           productId = $(this).attr("attrId");
           var color_id = $(this).attr("attrColor");
           //alert(color_id);
           var html = [];
           $.ajax({
               type: "POST",
               url: '<?php echo e(URL::to("/")); ?>/removewishlist',
               cache: false,
               data: {product_id: productId,
                      color_id: color_id},
               success: function (msg) {
                   msg1 = JSON.parse(msg);
                   console.log(msg1);

                   $(".count_wish").html(msg1.count);
                   $.each(msg1.data, function (key, value) {
                       //console.log('hello',value.id);
                       html.push('<li><a href="' + detail_url + '/' + value.slug + '"><img src="' + url + value.image_name + '"><h4>' + value.product_title + '</h4> <span><?php echo CURRENCY; ?>&nbsp;<b>' + value.price + '</b></span></a></li>');
                   });
                   $('#wishlist_dropdown').html(html);

                   setTimeout(function () {
                       $(self).removeClass('wishlist-btn-color');
                       $(self).removeClass('wishlist_btn_red');
                       $(self).addClass('wishlist_btn');
                   }, 0)
               },
               error: function (data) {
               }
           });
           return false;
       });






        
	
      </script>


