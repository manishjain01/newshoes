@extends('layouts.home') 
@section('content')
<style>
	#myModal_view{
		top:0px!important;
	}
	
	#myModal_view2{
		top:0px!important;
	}
</style>	
<div class="container-fluid slider_main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!--<ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>-->
    <div class="carousel-inner">
		
	@if(!$banners->isEmpty())
	@foreach ($banners as $key=>$banner)
      <div class="item <?if($key==0){?>active<? } ?>">
        <img src="{{ BANNER_IMAGE_URL.$banner->image}}" alt="{{$banner->title}}" style="width:100%;">
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

<div class="special-category-banner layout-two">
    <div class="container p-0">
        <div class="special-category-banner-content">
            <div class="row no-gutters">
                <div class="col-md-6">
                    <div class="single-special-banner animated fadeInLeft">
                        <figure class="banner-thumbnail">
								<a href="{{URL::to('productCat/men')}}"><img src="{{asset('img/s2.jpg')}}" class="banner-thumb"  alt="Category Banner"/></a>
                            <figcaption class="banner-cate-name text-center">
                                <a href="{{URL::to('productCat/men')}}" class="category-name">MEN</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="col-md-6 ">
                    <div class="single-special-banner animated fadeInRight">
                        <figure class="banner-thumbnail">
							<a href="{{URL::to('productCat/women')}}"><img src="{{asset('img/s1.jpg')}}" class="banner-thumb" alt="Category Banner"/></a>
                            <figcaption class="banner-cate-name text-center">
                            <a href="{{URL::to('productCat/women')}}" class="category-name">WOMEN</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50">

    <div class="container p-0">
        <div class="row no-gutters">
            <div class="col-lg-8 m-auto text-center animated fadeInDown data-aos="fade-up"">
                <div class="section-title-wrap">
                    <h2>New Arrivals</h2>
                </div>
            </div>
        </div>

        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="products-wrapper">
                    <div class="product-category-filter-wrap">
                        @if(!empty($latest_products))
                        @foreach($latest_products as $key=> $latest_product) <?php //pr($latest_product);echo "adfa";exit;?>
                         <?php $colorLists = CommonHelpers::getProductColor($latest_product->color_id);
                         
                               $images = CommonHelpers::getProductImage($latest_product->id, $latest_product->color_id); 
                               //pr($images);?>
                        
                        <div class="col-md-4 single-product-wrap men kid bagshoes">
                            <figure class="product-thumbnail">
                                <a href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}" class="d-block">
                                <?php if(isset($images[1]) && !empty($images[1])) {?>
                                <img class="secondary-thumb" src="{{PRODUCT_IMAGE_URL.$images[1]['image_name']}}" alt="Product"/>
                               <?php }else{?>
                                <img class="primary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
                               <?php }?>
                               
                                <?php if(isset($images[0]) && !empty($images[0])) {?>
                                    <img class="primary-thumb" src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" alt="Product"/>
                                <?php }else{?>
                                    <img class="primary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
                                <?php }?>
                                </a>
                                <figcaption class="product-hvr-content">
                                    <div class="btn-black btn-addToCart">

                                    <a id="myBtn_view" attId="{{$key}}" class="view_btn_class" title="Quick view"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <!--<a href="#" class="cart_btn" attrId="{{$latest_product->id}}"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>-->
                                    	@if(Auth::check())
										<?php $auth = LoginUser();
                                        $wishlist = CommonHelpers::wishlist_list($auth->id, $latest_product->id, $latest_product->color_id);
                                        ?>
                                    @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                    <a name="wishlist_btn"  id="wishlist_btn_red" attrColor = "{{ $latest_product->color_id }}" attrId="{{$latest_product->id}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @else
                                    <a name="wishlist_btn" id="wishlist_btn" attrColor = "{{ $latest_product->color_id }}" attrId="{{$latest_product->id}}" title="Add to wishlist" class="last_icn wishlist_btn wishBtnManageColor">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @else
                                    <a name="wishlist_btn" title="Add to wishlist" class="last_icn wishlist_btn wishBtnManageColor login_wishlist">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    </div>
                                   
                                    <div class="prod-btn-group">
                                        <a class="pro_title1" href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}"><span data-toggle="tooltip" data-placement="top"><p>{{$latest_product->product_title}}</p>
                                        <?php  $discount = $latest_product->discount;
                                        if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                                            $discount = ($discount/100)*$latest_product->price_usd;
                                            $discount_price = $latest_product->price_usd-$discount;
                                        }else{
                                            $discount = ($discount/100)*$latest_product->price;
                                            $discount_price = $latest_product->price-$discount; 
                                        }
                                        ?>
                                         <p class="prc">{!! CURRENCY !!}&nbsp;<b>{{$discount_price}}</b> <sub>
                                                 {!! CURRENCY !!}&nbsp; 
                                                 @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                                                 {{$latest_product->price_usd}}
                                                 @else
                                                 {{$latest_product->price}}
                                                 @endif
                                             </sub></p></span></a>
                                    </div>
                                    
                                    @if($latest_product->discount)
										 <span class="product-badge sale">-{{round($latest_product->discount)}}%</span>
									@else
										  <span class="product-badge">New</span>
									@endif
                                </figcaption>
                            </figure>
                        </div>
                        
                        
                        
                        <!-- The Modal Product Image Popup-->
						<div id="myModal_view" attId="{{$key}}" class="modal_view rah{{$key}}">
						   <span class="close_view">&times;</span>
						   <!-- Modal content -->
						   <div class="modal-content_view">
							  <div class="modal-body_view">
								 <div class="slideshow_modal">
									@if(isset($images) &&  !empty($images)) 
									@foreach($images as $key1=>$val)
									<div class="mySlides_modal fade_modal rahImg{{$key}}">
									   <img src="{{PRODUCT_IMAGE_URL.$val['image_name']}}" style="width:100%">
									</div>
									@endforeach
									@endif
									<a class="prev_modal" onclick="plusSlides_modal(-1)">&#10094;</a>
									<a class="next_modal" onclick="plusSlides_modal(1)">&#10095;</a>
								 </div>
								 <div style="text-align:center; margin-top: -25px;">
									<span class="dot_modal rahDots{{$key}}" onclick="currentSlide_modal(1)"></span> 
								 </div>
							  </div>
						   </div>
						</div>
                        
                        @endforeach
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="mid_slider">
 <div class="container-fluid"> 
 <div class="row"> 
	 
	 
<div class="col-md-9 slideshow-container">
	
	
	@foreach($featured_products as $key=>$featured_product)
	<?php $colorLists = CommonHelpers::getProductColor($featured_product->color_id);
                $images = CommonHelpers::getProductImage($featured_product->id, $featured_product->color_id);?>
	
	<div class="col-lg-12 mySlides_mid fade_mid">
	   <div class="col-md-1">
		<a class="next" onclick="plusSlides(1)"><img src="{{asset('img/arrow.png')}}" class="left-arrow"></a>
	<a class="prev" onclick="plusSlides(-1)"><img src="{{asset('img/arrow.png')}}"></a>

	</div>   
	   <div class="col-md-5 text_p">
		<span>FOR {{ucfirst($featured_product->product_category->cat_name)}}</span> 
	<h3>{{ucfirst($featured_product->product_subcategory->cat_name)}}</h3>
	<p><span><a class="feture_pro" href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}">{{$featured_product->product_title}}</a></span></p>
	
	<?php $discount = $featured_product->discount;
        if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
	$discount = ($discount/100)*$featured_product->price_usd;
	$discount_price = $featured_product->price_usd-$discount;
        }else{
        $discount = ($discount/100)*$featured_product->price;
	$discount_price = $featured_product->price-$discount; 
        }
?>

	<h4>{!! CURRENCY !!}&nbsp; {{$discount_price}} &nbsp;</h4>&nbsp;<h4 class="sale">{!! CURRENCY !!}&nbsp;
            @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
            {{$featured_product->price_usd}}
            @else
            {{$featured_product->price}}
            @endif
        </h4></div>

	<div class="col-md-6">
	  <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}"><img src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" style="width: 100%;"></a>
	</div>
	</div>
	@endforeach


<script>


var slideIndex = 1;
showSlides(slideIndex);
function plusSlides(n) {
  showSlides(slideIndex += n);
}
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {

  var i;
  var slides = document.getElementsByClassName("mySlides_mid");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}   
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }

  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }

  slides[slideIndex-1].style.display = "block";  
  //dots[slideIndex-1].className += " active";
}

</script>
</div>
	<div class="col-md-3 feature_p">
		<h2>Featured<br> Products</h2>    
	</div>
</div>
</div>


</section>


<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50">
    <div class="container p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="products-wrapper">
                    <div class="product-category-filter-wrap">

                        @foreach($random_products as $key=> $random_product)
			 <?php $colorLists = CommonHelpers::getProductColor($random_product->color_id);
                                $images = CommonHelpers::getProductImage($random_product->id, $random_product->color_id); //pr($colorLists);exit;?>		
                        <div class="col-md-4 single-product-wrap men kid bagshoes">
                            <figure class="product-thumbnail">
                                <a href="{{URL::to('productDetail/'.$random_product->slug.'/'.$colorLists->slug)}}" class="d-block">
                                         <?php if(isset($images[1]) && !empty($images[1])) {?>
                                        <img class="secondary-thumb" src="{{PRODUCT_IMAGE_URL.$images[1]['image_name']}}" alt="Product"/>
                                       <?php }else{?>
                                        <img class="primary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
                                         <?php } 
                                         if(isset($images[0]) && !empty($images[0])) {?>
                                    <img class="primary-thumb" src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" alt="Product"/>
                                    <?php }else{?>
                                    <img class="primary-thumb" src="{{asset('img/no-image.png')}}" alt="Product"/>
                                   <?php }?>
                                    
                                </a>
                                <figcaption class="product-hvr-content">
                                     <div class="btn-black btn-addToCart">

                                    <a id="myBtn_view2" attId2="{{$key}}" class="view_btn_class2" title="Quick view"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <!--<a href="javascript::void(0);" class="cart_btn" attrId="{{$random_product->id}}"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>-->
                                    
                                    @if(Auth::check())
                                     <?php $auth = LoginUser();
                                        $wishlist = CommonHelpers::wishlist_list($auth->id, $random_product->id, $random_product->color_id);
                                        ?>
                                    
                                    @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                                    <a name="wishlist_btn"  id="wishlist_btn_red" attrColor = "{{ $random_product->color_id }}" attrId="{{$random_product->id}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @else
                                    <a name="wishlist_btn" id="wishlist_btn" attrColor = "{{ $random_product->color_id }}" attrId="{{$random_product->id}}" title="Add to wishlist" class="last_icn wishlist_btn wishBtnManageColor">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    @else
                                    <a name="wishlist_btn"  title="Add to wishlist" class="last_icn wishlist_btn wishBtnManageColor login_wishlist">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                    </div>
                                    <div class="prod-btn-group">
                                        <a class="pro_title1" href="{{URL::to('productDetail/'.$random_product->slug.'/'.$colorLists->slug)}}"><span data-toggle="tooltip" data-placement="top"><p>{{$random_product->product_title}}</p>
                                        <?php $discount = $random_product->discount;
                                        if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>'){
                                            $discount = ($discount/100)*$random_product->price_usd;
                                            $discount_price = $random_product->price_usd-$discount;
                                        }else{
                                           $discount = ($discount/100)*$random_product->price;
                                            $discount_price = $random_product->price-$discount; 
                                        }   
                                        ?>
                                         <p class="prc">{!! CURRENCY !!}&nbsp;<b>{{$discount_price}}</b> <sub>{!! CURRENCY !!}&nbsp; 
                                                @if(CURRENCY == '<i class="fa fa-usd" aria-hidden="true"></i>')
                                                 {{$random_product->price_usd}}
                                                 @else
                                                  {{$random_product->price}}
                                                  @endif
                                             </sub></p></span></a>
                                    </div>
                                    
                                    @if($random_product->discount)
										 <span class="product-badge sale">-{{round($random_product->discount)}}%</span>
									@else
										  <span class="product-badge">New</span>
									@endif
                                </figcaption>
                            </figure>
                        </div>
								<!-- The Modal Product Image Popup-->
						<div id="myModal_view2" attId2="{{$key}}" class="modal_view rah2{{$key}}">
						   <span class="close_view2">&times;</span>
						   <!-- Modal content -->
						   <div class="modal-content_view">
							  <div class="modal-body_view">
								 <div class="slideshow_modal2 margin-img">
									 @if(isset($images) &&  !empty($images))
									@foreach($images as $key1=>$val)
									<div class="mySlides_modal2 fade_modal rahImg2{{$key}}">
									   <img src="{{PRODUCT_IMAGE_URL.$val['image_name']}}" style="width:100%">
									</div>
									@endforeach
                                                                        @endif
									<a class="prev_modal" onclick="plusSlides_modal2(-1)">&#10094;</a>
									<a class="next_modal" onclick="plusSlides_modal2(1)">&#10095;</a>
								 </div>
								 <div style="text-align:center; margin-top: -25px;">
									<span class="dot_modal2 rahDots2{{$key}}" onclick="currentSlide_modal2(1)"></span> 
								 </div>
							  </div>
						   </div>
						</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
var slideIndex = 1;

// Get the modal
var modal_view; 
var attId;

// Get the button that opens the modal
//~ var btn_view = document.getElementById("myBtn_view");

$('.view_btn_class').click(function($event){
	slideIndex = 1
	attId = $(this).attr("attId");
	console.log($(this).attr("attId"));
	modal_view = $(".rah"+attId)[0]
	modal_view.style.display = "block";
	showSlides_modal(slideIndex)
	
})

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
var slideIndex2 = 1;

// Get the modal
var modal_view2; 
var attId2;

// Get the button that opens the modal
//~ var btn_view = document.getElementById("myBtn_view");

$('.view_btn_class2').click(function($event){
	slideIndex2 = 1
	attId2 = $(this).attr("attId2");
	console.log($(this).attr("attId2"));
	modal_view2 = $(".rah2"+attId2)[0]
	modal_view2.style.display = "block";
	showSlides_modal2(slideIndex2)
	
})

// Get the <span> element that closes the modal
var span_view2 = document.getElementsByClassName("close_view2")[0];


function plusSlides_modal2(n) {
  showSlides_modal2(slideIndex2 += n);
}

function currentSlide_modal2(n) {
  showSlides_modal2(slideIndex2 = n);
}

function showSlides_modal2(n) {
  var i;
  var slides_modal2 = document.getElementsByClassName("rahImg2"+attId2);
  var dots_modal2 = document.getElementsByClassName("rahDots2"+attId2);
  if (n > slides_modal2.length) {slideIndex2 = 1}    
  if (n < 1) {slideIndex2 = slides_modal2.length}
  for (i = 0; i < slides_modal2.length; i++) {
      slides_modal2[i].style.display = "none";  
  }
  for (i = 0; i < dots_modal2.length; i++) {
      dots_modal2[i].className = dots_modal2[i].className.replace(" active_modal", "");
  }
  slides_modal2[slideIndex2-1].style.display = "block";  
  dots_modal2[slideIndex2-1].className += " active";
}


// When the user clicks on <span> (x), close the modal
span_view2.onclick = function() {
    modal_view2.style.display = "none";
}

$(".close_view2").click(function(){
	modal_view2.style.display = "none";
})


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_view2) {
        modal_view2.style.display = "none";
    }
}
</script>

@stop
