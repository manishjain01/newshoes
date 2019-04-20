@extends('layouts.home') 
@section('content')
     <?php //pr($latest_products);exit;?>
   
      <section class="slider_dv block animatable moveUp">
         <div class="container-fluid ">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
               <!-- Wrapper for slides -->
               <div class="carousel-inner">
				   
				   @if(!$banners->isEmpty())
				   @foreach ($banners as $key=>$banner) 
					  <div class="item <?if($key==0){?>active<?}?>">
						 <img src="{{ BANNER_IMAGE_URL.$banner->image}}" alt="{{$banner->title}}" style="width:100%;">
						 <div class="carousel-caption">
							<h3>{{$banner->title}}</h3>
							<p>MOVE CITY FAST IN THE AIR ZOOM MARIAH.</p>
						 </div>
					  </div>
                    @endforeach
					@endif 
               </div>
               <!-- Left and right controls -->
               <a class="left carousel-control" href="#myCarousel" data-slide="prev">
               <span class="glyphicon glyphicon-chevron-left"></span>
               <span class="sr-only">Previous</span>
               </a>
               <a class="right carousel-control" href="#myCarousel" data-slide="next">
               <span class="glyphicon glyphicon-chevron-right"></span>
               <span class="sr-only">Next</span>
               </a>
            </div>
         </div>
      </section>
      <section class="serch_row block animatable bounceInLeft">
         <div class="container">
            <div class="row">
                {!! Form::open(array('route' => 'product_search', 'novalidate' => 'novalidate', 'id' => 'form_serch1','class'=>'form-inline form_serch form_serch1')) !!}
                <div class="form-group">
                    <input type="search" class="form-control" id="search" placeholder="Search by product name" name="search">
                    <button type="button" class="btn btn-default" id="serch_btn">Search</button>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </section>
      <section class="category_dv">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-6 block animatable bounceInLeft">
                  <img src="img/women.jpg">  
                  <div class="col-md-12 cat_cl">
                     <h2>{{ $womens_cat->cat_name }}</h2>
                     <p><a href="javascript:void(0)">FOOTWEAR</a><a href="javascript:void(0)">WALLETS</a><a href="javascript:void(0)">BELTS</a></p>
                     <a href="{{URL::to('productCat/'.$womens_cat->slug)}}" class="shop_btn"><span>SHOP NOW</span></a> 
                  </div>
               </div>
               <div class="col-md-6 block animatable bounceInRight">
                  <img src="img/men.jpg">  
                  <div class="col-md-12 cat_cl">
                     <h2>{{ $mens_cat->cat_name }}</h2>
                     <p><a href="javascript:void(0)">FOOTWEAR</a><a href="javascript:void(0)">WALLETS</a><a href="javascript:void(0)">BELTS</a></p>
                     <a href="{{URL::to('productCat/'.$mens_cat->slug)}}" class="shop_btn"><span>SHOP NOW</span></a> 
                  </div>
               </div>
            </div>
         </div>
      </section>
      
    <!--////  new arivel shoes/////-->
        <div class="container-fluid text-center py-5 my-5">
            <h2 class="heading_page block animatable moveUp">New Arivals</h2>
            <div class="row mx-auto my-auto animatable bounceIn">
                <div id="recipeCarousel" class="carousel carousel1 slide w-100" data-ride="carousel">
                    <div class="container carousel-inner carousel-inner1  w-100" role="listbox">
                        
                        
                        @if(!empty($latest_products))
                       
                        @foreach($latest_products as $key=>$latest_product)
                        <?php 
                         if(isset($latest_product->product_image[0]) && !empty($latest_product->product_image[0])) {
                         $colorLists = CommonHelpers::getProductColor($latest_product->product_image[0]['color_id']);
                         }else{
                           $colorLists = "";  
                         }
                         $images = CommonHelpers::getProductImage($latest_product->id, $latest_product->product_image[0]['color_id']);
                        ?>
                        <div class="carousel-item <?php if($key == 0){?>active<?php }?>">
                           <div class="d-block  col-12 col-sm-6 col-md-4 col-lg-3">
                               <div class="d-block w-100">
                                   <div class="container_hv">
                                      
                                      <?php if(isset($latest_product->product_image[0]) && !empty($latest_product->product_image[0])) {?>
                                <img class="image_hv" src="{{PRODUCT_IMAGE_URL.$latest_product->product_image[0]['image_name']}}" alt="Product"/>
                               <?php }else{?>
                                <img class="image_hv" src="{{asset('img/no-image.png')}}" alt="Product"/>
                               <?php }?>
                                
                                      <div class="overlay_hv">
                                         <div class="text_hv">
                                            <p>
                                                @if(Auth::check())
                                                <?php $auth = LoginUser();
                                                   $wishlist = CommonHelpers::wishlist_list($auth->id, $latest_product->id, $latest_product->product_image[0]['color_id']);
                                                   ?>
                                                @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                                <a href="javascript:void(0);" id="wishlist_btn_red" attrId="{{$latest_product->id}}" attrColor ="{{$latest_product->product_image[0]['color_id']}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color slct">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                <a href="javascript:void(0);" id="wishlist_btn" attrId="{{$latest_product->id}}" attrColor ="{{$latest_product->product_image[0]['color_id']}}" class="last_icn wishlist_btn wishBtnManageColor slct">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                                @endif
                                               
                                                @else
                                                <a href="javascript:void(0);" class="slct wishlist_btn" data-toggle="modal" data-target="#myModal" title="Add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                                @endif
                                               <a id="myBtn_view" attId="{{$key}}" proId="{{$latest_product->id}}" colorId ="{{$latest_product->product_image[0]['color_id']}}" class="view_btn_class slct">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a> 
                                               <!--  <a id="myBtn_view" class=" slct">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a> -->
                                                 <!-- <a href="#"  class="slct" data-toggle="modal" data-target="#myModal_view_pro{{$latest_product->id}}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a> -->
                                              <!-- <a href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}" class="slct" data-toggle="modal" data-target="#myModal_view_pro"><i class="fa fa-eye" aria-hidden="true"></i></a>  -->
                                              <!--  <a href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}" class="slct" data-toggle="modal" data-target="#myModal_view_pro"><i class="fa fa-eye" aria-hidden="true"></i></a> -->
                                            </p>
                                            <p class="shop_nw">
                                                <a href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}">SHOP THIS</a>
                                            </p>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="dlt">
                                      <h3 class="prduct_title1">{{ $latest_product->product_title }}</h3>
                                      <?php  $discount = $latest_product->discount;                                        
                                            $discount = ($discount/100)*$latest_product->price;
                                            $discount_price = $latest_product->price-$discount;
                                       
                                        ?>
                                      <p class="price">
                                              @if(isset($latest_product->discount) && !empty($latest_product->discount) && $latest_product->discount != 0.00)
                                              <span><i class="fa fa-inr" aria-hidden="true"></i> {{$latest_product->price}} </span>
                                              @endif
                                          
                                          <i class="fa fa-inr" aria-hidden="true"></i> {{$discount_price}}
                                      </p>
                                      
                                   </div>
                                </div>
                            </div> 
                        </div>
                        
                     
           
                        
                        
                        
                        
                        
                        
                        
                       
                        @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev newAriveleft" href="#recipeCarousel" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left  text-warning fa-3x" aria-hidden="true"></i>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next newAriveright" href="#recipeCarousel" role="button" data-slide="next">
                  <i class="fa fa-arrow-right text-warning fa-3x" aria-hidden="true"></i>
                  <span class="sr-only">Next</span>
                  </a>  
              </div>
           </div>
           
        </div>



<!-- 
<div id="myModal_view" attId="0" class="modal_view rah" style="display:none;">
   <span class="close_view">&times;</span>
   <!-- Modal content -->
  <!--  <div class="modal-content_view">
	  <div class="modal-body_view">
		 <div class="slideshow_modal">
			
			<div class="mySlides_modal fade_modal rahImg">
			   
			</div>
			
			
			<a class="prev_modal" onclick="plusSlides_modal(-1)">&#10094;</a>
			<a class="next_modal" onclick="plusSlides_modal(1)">&#10095;</a>
		 </div>
		 <div style="text-align:center; margin-top: -25px;">
			<span class="dot_modal rahDots" onclick="currentSlide_modal(1)"></span> 
		 </div>
	  </div>
   </div> -->
<!-- </div> --> -->

<!-- The Modal -->
<div id="myModal_view" class="modal_view view_pro1 view_pro11">

  <!-- Modal content -->
  <div class="modal-content_view">
   
     
      
    <div class="modal-body_view">
       <span class="close_view">&times;</span>
   <div id="myCarousel2" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel2" data-slide-to="1"></li>
      <li data-target="#myCarousel2" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner mySlides_modal">
<!--      <div class="item active">
        <img src="img/1.png" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="img/2.png" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="img/3.png" alt="New york" style="width:100%;">
      </div>-->
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel2" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

    </div>
  
  </div>

</div>







<script>
// Get the modal
var modal_view = document.getElementById('myModal_view');

// Get the button that opens the modal
var btn_view = document.getElementById("myBtn_view");

// Get the <span> element that closes the modal
var span_view = document.getElementsByClassName("close_view")[0];

// When the user clicks the button, open the modal 
btn_view.onclick = function() {
    modal_view.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span_view.onclick = function() {
    modal_view.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_view) {
        modal_view.style.display = "none";
    }
}
</script>         
              








                        





















        
    
     <div class="container-fluid text-center py-5 my-5">
            <h2 class="heading_page block animatable moveUp">Featured Products</h2>
            <div class="row mx-auto my-auto animatable bounceIn">
                <div id="recipeCarousel1" class="carousel carousel1 slide w-100" data-ride="carousel">
                    <div class="container carousel-inner carousel-inner1  w-100" role="listbox">
                        @if($featured_products_count > 4 )
                        
                        @if(!empty($featured_products))
                       
                        @foreach($featured_products as $key=> $featured_product)
                        <?php 
                         if(isset($featured_product->product_image[0]) && !empty($featured_product->product_image[0])) {
                         $colorLists = CommonHelpers::getProductColor($featured_product->product_image[0]['color_id']);
                         }else{
                           $colorLists = "";  
                         }
                        ?>
                        <div class="carousel-item <?php if($key == 0){?>active<?php }?>">
                           <div class="d-block  col-12 col-sm-6 col-md-4 col-lg-3">
                               <div class="d-block w-100">
                                   <div class="container_hv">
                                      
                                      <?php if(isset($featured_product->product_image[0]) && !empty($featured_product->product_image[0])) {?>
                                <img class="image_hv" src="{{PRODUCT_IMAGE_URL.$featured_product->product_image[0]['image_name']}}" alt="Product"/>
                               <?php }else{?>
                                <img class="image_hv" src="{{asset('img/no-image.png')}}" alt="Product"/>
                               <?php }?>
                                
                                      <div class="overlay_hv">
                                         <div class="text_hv">
                                            <p>
                                                @if(Auth::check())
                                                <?php $auth = LoginUser();
                                                   $wishlist = CommonHelpers::wishlist_list($auth->id, $featured_product->id, $featured_product->product_image[0]['color_id']);
                                                   ?>
                                                @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                                <a href="javascript:void(0);" id="wishlist_btn_red" attrId="{{$featured_product->id}}" attrColor ="{{$featured_product->product_image[0]['color_id']}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color slct">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                <a href="javascript:void(0);" id="wishlist_btn" attrId="{{$featured_product->id}}" attrColor ="{{$featured_product->product_image[0]['color_id']}}" class="last_icn wishlist_btn wishBtnManageColor slct">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                                @endif
                                               
                                                @else
                                                <a href="javascript:void(0);" class="slct wishlist_btn" data-toggle="modal" data-target="#myModal" title="Add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                                @endif
                                                 <a id="myBtn_view" attId="{{$key}}"  proId="{{$featured_product->id}}" colorId ="{{$featured_product->product_image[0]['color_id']}}" class="view_btn_class2 slct">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a> 
<!--                                               <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}" class="slct">
                                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                               </a>-->
                                            </p>
                                            <p class="shop_nw">
                                                <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}">SHOP THIS</a>
                                            </p>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="dlt">
                                      <h3 class="prduct_title1">{{ $featured_product->product_title }}</h3>
                                      <?php  $discount = $featured_product->discount;                                        
                                            $discount = ($discount/100)*$featured_product->price;
                                            $discount_price = $featured_product->price-$discount;
                                       
                                        ?>
                                      <p class="price">
                                              @if(isset($featured_product->discount) && !empty($featured_product->discount) && $featured_product->discount != 0.00)
                                              <span><i class="fa fa-inr" aria-hidden="true"></i> {{$featured_product->price}} </span>
                                              @endif
                                          
                                          <i class="fa fa-inr" aria-hidden="true"></i> {{$discount_price}}
                                      </p>
                                      
                                   </div>
                                </div>
                            </div> 
                        </div>
                       
                        @endforeach
                        @endif
                        @else
                         @foreach($featured_products as $key=> $featured_product)
                        <?php 
                         if(isset($featured_product->product_image[0]) && !empty($featured_product->product_image[0])) {
                         $colorLists = CommonHelpers::getProductColor($featured_product->product_image[0]['color_id']);
                         }else{
                           $colorLists = "";  
                         }
                        ?>
                        <div>
                           <div class="d-block  col-12 col-sm-6 col-md-4 col-lg-3">
                               <div class="d-block w-100">
                                   <div class="container_hv">
                                      
                                      <?php if(isset($featured_product->product_image[0]) && !empty($featured_product->product_image[0])) {?>
                                <img class="image_hv" src="{{PRODUCT_IMAGE_URL.$featured_product->product_image[0]['image_name']}}" alt="Product"/>
                               <?php }else{?>
                                <img class="image_hv" src="{{asset('img/no-image.png')}}" alt="Product"/>
                               <?php }?>
                                
                                      <div class="overlay_hv">
                                         <div class="text_hv">
                                            <p>
                                                @if(Auth::check())
                                                <?php $auth = LoginUser();
                                                   $wishlist = CommonHelpers::wishlist_list($auth->id, $featured_product->id, $featured_product->product_image[0]['color_id']);
                                                   ?>
                                                @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                                <a href="javascript:void(0);" id="wishlist_btn_red" attrId="{{$featured_product->id}}" attrColor ="{{$featured_product->product_image[0]['color_id']}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color slct">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                <a href="javascript:void(0);" id="wishlist_btn" attrId="{{$featured_product->id}}" attrColor ="{{$featured_product->product_image[0]['color_id']}}" class="last_icn wishlist_btn wishBtnManageColor slct">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                                @endif
                                               
                                                @else
                                                <a href="javascript:void(0);" class="slct wishlist_btn" data-toggle="modal" data-target="#myModal" title="Add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                                @endif
                                                <a id="myBtn_view" attId="{{$key}}"  proId="{{$featured_product->id}}" colorId ="{{$featured_product->product_image[0]['color_id']}}" class="view_btn_class2 slct">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
<!--                                               <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}" class="slct">
                                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                               </a>-->
                                            </p>
                                            <p class="shop_nw">
                                                <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}">SHOP THIS</a>
                                            </p>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="dlt">
                                      <h3 class="prduct_title1">{{ $featured_product->product_title }}</h3>
                                      <?php  $discount = $featured_product->discount;                                        
                                            $discount = ($discount/100)*$featured_product->price;
                                            $discount_price = $featured_product->price-$discount;
                                       
                                        ?>
                                      <p class="price">
                                              @if(isset($featured_product->discount) && !empty($featured_product->discount) && $featured_product->discount != 0.00)
                                              <span><i class="fa fa-inr" aria-hidden="true"></i> {{$featured_product->price}} </span>
                                              @endif
                                          
                                          <i class="fa fa-inr" aria-hidden="true"></i> {{$discount_price}}
                                      </p>
                                      
                                   </div>
                                </div>
                            </div> 
                        </div>
                       
                        @endforeach
                        @endif
                        
                    </div>
                    <a class="carousel-control-prev newAriveleft" href="#recipeCarousel1" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left  text-warning fa-3x" aria-hidden="true"></i>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next newAriveright" href="#recipeCarousel1" role="button" data-slide="next">
                  <i class="fa fa-arrow-right text-warning fa-3x" aria-hidden="true"></i>
                  <span class="sr-only">Next</span>
                  </a>  
              </div>
           </div>
           
        </div>
        
        
        
    <script>
var slideIndex = 1;

// Get the modal
var modal_view; 
var attId;

// Get the button that opens the modal
//~ var btn_view = document.getElementById("myBtn_view");




$(document).ready(function(){
 $('.view_btn_class').click(function($event){
	slideIndex = 1
	attId = $(this).attr("attId");
	productId = $(this).attr("proId");
        colorId = $(this).attr("colorId");
	
        $('.mySlides_modal').empty();
	
	// var html = '<div id="myModal_view" attId="'+attId+'" class="modal_view rah'+attId+'"><span class="close_view">&times;</span><div class="modal-content_view"><div class="modal-body_view"><div class="slideshow_modal"><div class="mySlides_modal fade_modal rahImg'+attId+'"><img src="img/1.png" style="width:100%"></div><a class="prev_modal" onclick="plusSlides_modal(-1)">&#10094;</a><a class="next_modal" onclick="plusSlides_modal(1)">&#10095;</a></div><div style="text-align:center; margin-top: -25px;"><span class="dot_modal rahDots1" onclick="currentSlide_modal(1)"></span> </div></div></div></div>';
	
	console.log($(this).attr("attId"));
	
	$('#myModal_view').switchClass('rah','rah'+attId);
	$('.mySlides_modal').switchClass('rahImg','rahImg'+attId);
	$('.dot_modal').switchClass('rahDots','rahDots'+attId);
	var html = []; 
	var url = '{{PRODUCT_IMAGE_URL}}';
	//var images = '<?//=$latest_product->product_image?>';
	//images 	  = JSON.parse(images);
        $.ajaxSetup(
                   {
                       headers:
                               {
                                   'X-CSRF-Token': $('input[name="_token"]').val()
                               }
                   });
        $.ajax({
               type: "POST",
               url: '{{URL::to("/")}}/image_prew',
               cache: false,
               data: {product_id: productId,
                      color_id: colorId
                     },
               success: function (msg) {
                   msg1 = JSON.parse(msg);
                   console.log(msg1.data);
                   $.each(msg1.data, function (key, value) {
                       console.log("ad", value);
                       var image = value.image_name;		
                    //$(".rahImg"+attId).attr("src",url+image);
                        if(key == 0){
                       html.push('<div class="item active"><img src="' + url + value.image_name + '" class = "rahImg'+attId+'"></div>');
                   }else{
                       html.push('<div class="item"><img src="' + url + value.image_name + '" class = "rahImg'+attId+'"></div>');
                       }

                   });
                   $('.mySlides_modal').html(html);
                  
               },
               error: function (data) {
               }
           });
           
	
    
    
     /*$.each(images, function (key, value) {
		var image = value.image_name;
		
		$(".rahImg"+attId).attr("src",image);
	
		

	});*/
	
	
	
	modal_view = $(".rah"+attId)[0];
	modal_view.style.display = "block";
	showSlides_modal(slideIndex)
	
});


$('.view_btn_class2').click(function($event){
	slideIndex = 1
	attId = $(this).attr("attId");
	productId = $(this).attr("proId");
        colorId = $(this).attr("colorId");
	$('.mySlides_modal').empty();

	
	// var html = '<div id="myModal_view" attId="'+attId+'" class="modal_view rah'+attId+'"><span class="close_view">&times;</span><div class="modal-content_view"><div class="modal-body_view"><div class="slideshow_modal"><div class="mySlides_modal fade_modal rahImg'+attId+'"><img src="img/1.png" style="width:100%"></div><a class="prev_modal" onclick="plusSlides_modal(-1)">&#10094;</a><a class="next_modal" onclick="plusSlides_modal(1)">&#10095;</a></div><div style="text-align:center; margin-top: -25px;"><span class="dot_modal rahDots1" onclick="currentSlide_modal(1)"></span> </div></div></div></div>';
	
	console.log($(this).attr("attId"));
	
	$('#myModal_view').switchClass('rah','rah'+attId);
	$('.mySlides_modal').switchClass('rahImg','rahImg'+attId);
	$('.dot_modal').switchClass('rahDots','rahDots'+attId);
	var html = []; 
	var url = '{{PRODUCT_IMAGE_URL}}';
	//var images = '<?//=$latest_product->product_image?>';
	//images 	  = JSON.parse(images);
        $.ajaxSetup(
                   {
                       headers:
                               {
                                   'X-CSRF-Token': $('input[name="_token"]').val()
                               }
                   });
        $.ajax({
               type: "POST",
               url: '{{URL::to("/")}}/image_prew',
               cache: false,
               data: {product_id: productId,
                      color_id: colorId
                     },
               success: function (msg) {
                   msg1 = JSON.parse(msg);
                   console.log(msg1.data);
                   $.each(msg1.data, function (key, value) {
                       console.log("ad", value);
                       var image = value.image_name;		
                    //$(".rahImg"+attId).attr("src",url+image);
                        if(key == 0){
                       html.push('<div class="item active"><img src="' + url + value.image_name + '" class = "rahImg'+attId+'"></div>');
                   }else{
                       html.push('<div class="item"><img src="' + url + value.image_name + '" class = "rahImg'+attId+'"></div>');
                       }

                   });
                   $('.mySlides_modal').html(html);
                  
               },
               error: function (data) {
               }
           });
           
	
    
    
     /*$.each(images, function (key, value) {
		var image = value.image_name;
		
		$(".rahImg"+attId).attr("src",image);
	
		

	});*/
	
	
	
	modal_view = $(".rah"+attId)[0];
	modal_view.style.display = "block";
	showSlides_modal(slideIndex)
	
});


});

// Get the <span> element that closes the modal
var span_view = document.getElementsByClassName("close_view")[0];


function plusSlides_modal(n) {
  showSlides_modal(slideIndex += n);
}

function currentSlide_modal(n) {
  showSlides_modal(slideIndex = n);
}

function showSlides_modal(n) {
  var i;
  var slides_modal = document.getElementsByClassName("rahImg"+attId);
  var dots_modal = document.getElementsByClassName("rahDots"+attId);
  if (n > slides_modal.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides_modal.length}
  for (i = 0; i < slides_modal.length; i++) {
      slides_modal[i].style.display = "none";  
  }
  for (i = 0; i < dots_modal.length; i++) {
      dots_modal[i].className = dots_modal[i].className.replace(" active_modal", "");
  }
  slides_modal[slideIndex-1].style.display = "block";  
  dots_modal[slideIndex-1].className += " active";
}


// When the user clicks on <span> (x), close the modal
span_view.onclick = function() {
    modal_view.style.display = "none";
}

$(".close_view").click(function(){
	modal_view.style.display = "none";
})


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_view) {
        modal_view.style.display = "none";
    }
}
</script>

  
  
  
  
  
  <script>

  $(document.body).on('click',"#serch_btn",function (e) {
         var search = $('#search').val();
         if(search == ""){
         alert("Please Enter the search value.");
          return false;
        }else{
         $("#form_serch1").submit();
        }
 });
  </script>
@stop
