<?php $__env->startSection('content'); ?>  
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
		  
		<?php if(isset($wishlistProduts) && !empty($wishlistProduts)): ?>
                  <?php foreach($wishlistProduts as $key=>$wishlistProdut): ?> 
                  <?php
                  $images = CommonHelpers::getProductImage($wishlistProdut->product_id, $wishlistProdut->color_id);
                  $colors = CommonHelpers::getColor($wishlistProdut->color_id);
                  //pr($colors);exit;
                  ?>
		
		
		  
         <div class="col-md-12 div_show_wish <?php if($wishlistProdut->status == 0){?> wishlist_block <?php }?>">
            <div class="col-md-2">
               <a href="<?php echo e(URL::to('productDetail/'.$wishlistProdut->slug.'/'.$colors['0']['slug'])); ?>"> <img src="<?php echo e(PRODUCT_IMAGE_URL.$images['0']['image_name']); ?>"></a>
            </div>
            <div class="col-md-10">
               <h3><a href="<?php echo e(URL::to('productDetail/'.$wishlistProdut->slug.'/'.$colors['0']['slug'])); ?>"><?php echo e($wishlistProdut->product_title); ?></a></h3>
                <a class="remove_btn right_rmv" href="javascript:void(0);" attrColor = "<?php echo e($wishlistProdut->color_id); ?>" attrId="<?php echo e($wishlistProdut->product_id); ?>" >Remove</a>
              
                <?php    
                        $discount = $wishlistProdut->discount;
                        $discount = ($discount/100)*$wishlistProdut->price;
                        $discount_price = $wishlistProdut->price-$discount;

                        $cart_discount = ($wishlistProdut->discount/100)*$wishlistProdut->price;
                        $cart_price = $wishlistProdut->price - $cart_discount;
			?>
              
               <span><?php echo e($wishlistProdut->product_title); ?></span>
               
               <p>
                   <span style="border-radius: 50%; padding:7px; background: <?php echo e($colors['0']['color_picker']); ?>;"></span>
                   &nbsp;&nbsp;
                   <i class="fa fa-inr" aria-hidden="true">
               </i> <?php echo e($discount_price); ?> 
               <?php if(!empty($discount) && $discount != '0.00'): ?>
               <span><i class="fa fa-inr" aria-hidden="true"></i>
                   <?php echo e($wishlistProdut->price); ?></span>
               <?php endif; ?>
               </p>
				<span class="size_error<?php echo e($wishlistProdut->id); ?>"></span>
                <span class="stock_error<?php echo e($wishlistProdut->id); ?>"></span>
              
                <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'panel_address','style'=>'display:block')); ?>  
                     
			    <?php 
			       $sizeLists = ['' => 'Select Size'] + CommonHelpers::getsizeProductList($wishlistProdut->product_id, $wishlistProdut->color_id);
			    ?>
                  <div class="form-group order_frm_slct col-md-4 form-group order_frm_slct wishlist_size">
                    <?php echo Form::select('size_id', $sizeLists, null, ['class'=>'size_ids'.$wishlistProdut->id]); ?>

                    <input type="hidden" value="<?php echo e($wishlistProdut->product_id); ?>" class="product_id<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($wishlistProdut->color_id); ?>" class="color_id<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($cart_discount); ?>" class="discount<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($cart_price); ?>" class="price<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($wishlistProdut->product_title); ?>" class="product_name<?php echo e($wishlistProdut->id); ?>" />
					
					<input type="hidden" value="<?php echo e($wishlistProdut->category_id); ?>" class="category_id<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($wishlistProdut->sub_category_id); ?>" class="sub_category_id<?php echo e($wishlistProdut->id); ?>" />
					<input type="hidden" value="<?php echo e($wishlistProdut->sub_sub_category_id); ?>" class="sub_sub_category_id<?php echo e($wishlistProdut->id); ?>" />
                    
                  </div>
                  <div class="form-group col-md-4 order_frm_slct" >   
                    
                     <button type="button" class="btn btn-default add_cart" datas = "<?php echo e($wishlistProdut->id); ?>">ADD TO BAG</button>
                  </div>
                  
                   <div class="form-group col-md-4 order_frm_slct"> 
                       <?php echo Form::button('BUY NOW',['class'=>'btn btn-default by_now','datass'=>$wishlistProdut->id]); ?>

                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      
      
		 <?php endforeach; ?>
		  <?php else: ?>
		  <div class="col-md-12"><h3>No items in wishlist</h3></div>
		  <?php endif; ?>
      
      
      
      
      
      </div>
   </div>
</section>


<script>
 $(document).on("click",".add_cart",function() {
	
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });

        var id = $(this).attr("datas");
        productId = $('.product_id'+id).val();
        
        var qty = 1;      
        var size = $('.size_ids'+id).val();
        //alert(id);
        if(size == '') {
            $('.size_error'+id).text('Please Select Size.').css('color','red');
        }else{      
        var color_id = $('.color_id'+id).val();
        var price = $('.price'+id).val();
        var product_name = $('.product_name'+id).val();
        var category_id = $('.category_id'+id).val();
        var sub_cat_id = $('.sub_category_id'+id).val();
        var sub_sub_cat_id = $('.sub_sub_category_id'+id).val();
        var discount = $('.discount'+id).val();
        
        var html = [];
        //alert(price);
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/addtocart',
            cache: false,
            data: {
                product_id: productId,
                qty: qty,
                size: size,
                color_id: color_id,
                price: price,
                
                product_name: product_name,
                cat_id: category_id,
                sub_cat_id: sub_cat_id,
                sub_sub_cat_id: sub_sub_cat_id,
                discount: discount,
                wishlist: 1
            },
				success: function (msg) {                
                msg1 = JSON.parse(msg);
                console.log(msg1.message);
                console.log("adf", msg1.wishlist);
                $('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                $('.size_error'+id).html(msg1.message).css('color','red');
                if(msg1.status == 'success'){
                   location.reload();                   
                }
            },
            error: function (data) {
            }
        });
        return false;
};   
	
});
 
 $(document).on("click", ".by_now", function () {
     
     
        var url = '<?php echo e(PRODUCT_IMAGE_URL); ?>';
        var detail_url = '<?php echo e(URL::to("productDetail")); ?>';
        
        var self = this;
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });


       var id = $(this).attr("datass");
        productId = $('.product_id'+id).val();
        
        var qty = 1;      
        var size = $('.size_ids'+id).val();
        //alert(id);
        if(size == '') {
            $('.size_error'+id).text('Please Select Size.').css('color','red');
            return false;
        }else{      
        var color_id = $('.color_id'+id).val();
        var price = $('.price'+id).val();
        var price_usd = $('.price_usd'+id).val();
        var product_name = $('.product_name'+id).val();
        var category_id = $('.category_id'+id).val();
        var sub_cat_id = $('.sub_category_id'+id).val();
        var sub_sub_cat_id = $('.sub_sub_category_id'+id).val();
        var discount = $('.discount'+id).val();
        var discount_usd = $('.discount_usd'+id).val();
        
        var html = [];
        $.ajax({
            type: "POST",
            url: '<?php echo e(URL::to("/")); ?>/by_now',
            cache: false,
            data: {
                product_id: productId,
                qty: qty,
                size: size,
                color_id: color_id,
                price: price,
                price_usd: price_usd,
                product_name: product_name,
                cat_id: category_id,
                sub_cat_id: sub_cat_id,
                sub_sub_cat_id: sub_sub_cat_id,
                discount: discount,
                discount_usd: discount_usd,
                wishlist: true},
            success: function (msg) {                
               msg1 = JSON.parse(msg);
                console.log(msg1.order);
                //$('.size_error'+id).html(msg1.message).css('color','red');
                //$('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                //$('.size_error').text('');
               if(msg1.message != 'This product is out of stock'){
                setTimeout(function () {
                    <?php if(Auth::check()): ?>
                        window.location.assign("<?php echo e(URL::to('ByNow')); ?>/"+msg1.order);
                    <?php else: ?>
                window.location.assign("<?php echo e(URL::to('bynow')); ?>/"+msg1.order);
            <?php endif; ?>
                }, 2000);
            }else{
                console.log("size", msg1.message);
                $('.stock_error'+id).html('This product is out of stock.').css('color','red');
            }
                //$('.cart_btn').text('ADDED TO CART');
                //$('.cart_btn').prop('disabled', true);
            },
            error: function (data) {
            }
        });
        return false;
};
    });
     
    
 $(document).on("click",".remove_btn",function() {
		$.ajaxSetup(
                {
                    headers:
                        {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                        }
                });
		
		productId = $(this).attr("attrId");
		var color_id = $(this).attr("attrColor");
		var html = [];
		$.ajax({
                    type: "POST",
                    url: '<?php echo e(URL::to("/")); ?>/removewishlist',
                    cache: false,
                    data: { product_id: productId,
                            color_id: color_id},
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        
                        $(".count_wish").html(msg1.count);
                        
						location.reload();
                    },
                    error: function (data) {
                    }
                });
	return false;
	
});
 </script>   

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.inner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>