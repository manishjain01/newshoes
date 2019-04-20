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
                {!! Form::open(array('route' => 'product_search', 'novalidate' => 'novalidate', 'id' => 'demo_2','class'=>'form-inline form_serch form_serch1')) !!}
                <div class="form-group">
                    <input type="search" class="form-control" id="" placeholder="Search by product name" name="search">
                     <button type="submit" class="btn btn-default">Search</button>
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
                        <?php $i = 1;?>
                        @foreach($latest_products as $latest_product)
                        <?php 
                         if(isset($latest_product->product_image[0]) && !empty($latest_product->product_image[0])) {
                         $colorLists = CommonHelpers::getProductColor($latest_product->product_image[0]['color_id']);
                         }else{
                           $colorLists = "";  
                         }
                        ?>
                        <div class="carousel-item <?php if($i == 1){?>active<?php }?>">
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
                                               <a href="{{URL::to('productDetail/'.$latest_product->slug.'/'.$colorLists->slug)}}" class="slct"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                        <?php $i++;?>
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

        
    
     <div class="container-fluid text-center py-5 my-5">
            <h2 class="heading_page block animatable moveUp">Featured Products</h2>
            <div class="row mx-auto my-auto animatable bounceIn">
                <div id="recipeCarousel" class="carousel carousel1 slide w-100" data-ride="carousel">
                    <div class="container carousel-inner carousel-inner1  w-100" role="listbox">
                        
                        
                        @if(!empty($featured_products))
                        <?php $i = 1;?>
                        @foreach($featured_products as $featured_product)
                        <?php 
                         if(isset($featured_product->product_image[0]) && !empty($featured_product->product_image[0])) {
                         $colorLists = CommonHelpers::getProductColor($featured_product->product_image[0]['color_id']);
                         }else{
                           $colorLists = "";  
                         }
                        ?>
                        <div class="carousel-item <?php if($i == 1){?>active<?php }?>">
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
                                               <a href="{{URL::to('productDetail/'.$featured_product->slug.'/'.$colorLists->slug)}}" class="slct"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                        <?php $i++;?>
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
  
@stop
