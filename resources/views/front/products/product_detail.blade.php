@extends('layouts.inner') 
@section('content')

<section class="product_details">
         <div class="container">
            <div class="row">
               <div class="col-md-7 block animatable bounceInLeft">
                  <script type="text/javascript">
                     var mzOptions = {};
                     mzOptions = {
                         onZoomReady: function() {
                             console.log('onReady', arguments[0]);
                         },
                         onUpdate: function() {
                             console.log('onUpdated', arguments[0], arguments[1], arguments[2]);
                         },
                         onZoomIn: function() {
                             console.log('onZoomIn', arguments[0]);
                         },
                         onZoomOut: function() {
                             console.log('onZoomOut', arguments[0]);
                         },
                         onExpandOpen: function() {
                             console.log('onExpandOpen', arguments[0]);
                         },
                         onExpandClose: function() {
                             console.log('onExpandClosed', arguments[0]);
                         }
                     };
                     var mzMobileOptions = {};
                     
                     function isDefaultOption(o) {
                         return magicJS.$A(magicJS.$(o).byTag('option')).filter(function(opt){
                             return opt.selected && opt.defaultSelected;
                         }).length > 0;
                     }
                     
                     function toOptionValue(v) {
                         if ( /^(true|false)$/.test(v) ) {
                             return 'true' === v;
                         }
                         if ( /^[0-9]{1,}$/i.test(v) ) {
                             return parseInt(v,10);
                         }
                         return v;
                     }
                     
                     function makeOptions(optType) {
                         var  value = null, isDefault = true, newParams = Array(), newParamsS = '', options = {};
                         magicJS.$(magicJS.$A(magicJS.$(optType).getElementsByTagName("INPUT"))
                             .concat(magicJS.$A(magicJS.$(optType).getElementsByTagName('SELECT'))))
                             .forEach(function(param){
                                 value = ('checkbox'==param.type) ? param.checked.toString() : param.value;
                     
                                 isDefault = ('checkbox'==param.type) ? value == param.defaultChecked.toString() :
                                     ('SELECT'==param.tagName) ? isDefaultOption(param) : value == param.defaultValue;
                     
                                 if ( null !== value && !isDefault) {
                                     options[param.name] = toOptionValue(value);
                                 }
                         });
                         return options;
                     }
                     
                     function updateScriptCode() {
                         var code = '&lt;script&gt;\nvar mzOptions = ';
                         code += JSON.stringify(mzOptions, null, 2).replace(/\"(\w+)\":/g,"$1:")+';';
                         code += '\n&lt;/script&gt;';
                     
                         magicJS.$('app-code-sample-script').changeContent(code);
                     }
                     
                     function updateInlineCode() {
                         var code = '&lt;a class="MagicZoom" data-options="';
                         code += JSON.stringify(mzOptions).replace(/\"(\w+)\":(?:\"([^"]+)\"|([^,}]+))(,)?/g, "$1: $2$3; ").replace(/\{([^{}]*)\}/,"$1").replace(/\s*$/,'');
                         code += '"&gt;';
                     
                         magicJS.$('app-code-sample-inline').changeContent(code);
                     }
                     
                     function applySettings() {
                         MagicZoom.stop('Zoom-1');
                         mzOptions = makeOptions('params');
                         mzMobileOptions = makeOptions('mobile-params');
                         MagicZoom.start('Zoom-1');
                         updateScriptCode();
                         updateInlineCode();
                         try {
                             prettyPrint();
                         } catch(e) {}
                     }
                     
                     function copyToClipboard(src) {
                         var
                             copyNode,
                             range, success;
                     
                         if (!isCopySupported()) {
                             disableCopy();
                             return;
                         }
                         copyNode = document.getElementById('code-to-copy');
                         copyNode.innerHTML = document.getElementById(src).innerHTML;
                     
                         range = document.createRange();
                         range.selectNode(copyNode);
                         window.getSelection().addRange(range);
                     
                         try {
                             success = document.execCommand('copy');
                         } catch(err) {
                             success = false;
                         }
                         window.getSelection().removeAllRanges();
                         if (!success) {
                             disableCopy();
                         } else {
                             new magicJS.Message('Settings code copied to clipboard.', 3000,
                                 document.querySelector('.app-code-holder'), 'copy-msg');
                         }
                     }
                     
                     function disableCopy() {
                         magicJS.$A(document.querySelectorAll('.cfg-btn-copy')).forEach(function(node) {
                             node.disabled = true;
                         });
                         new magicJS.Message('Sorry, cannot copy settings code to clipboard. Please select and copy code manually.', 3000,
                             document.querySelector('.app-code-holder'), 'copy-msg copy-msg-failed');
                     }
                     
                     function isCopySupported() {
                         if ( !window.getSelection || !document.createRange || !document.queryCommandSupported ) { return false; }
                         return document.queryCommandSupported('copy');
                     }
                  </script>

                  <?php $productsImage = CommonHelpers::getProductImage($product_id, $colorId); ?>
                 
                  <div class="app-figure " id="zoom-fig">
                     <div class="selectors col-md-2">

                     @foreach($productsImage as $key=>$value)  
                        
                        <a
                           data-zoom-id="Zoom-1"
                           href="{{PRODUCT_IMAGE_URL.$value['image_name']}}"
                           data-image="{{PRODUCT_IMAGE_URL.$value['image_name']}}?scale.height=400"
                           >
                        <img srcset="{{PRODUCT_IMAGE_URL.$value['image_name']}}?scale.width=112 2x" src="{{PRODUCT_IMAGE_URL.$value['image_name']}}?scale.width=56"/>
                        </a>
                     @endforeach
                     </div>
                     <a id="Zoom-1" class="MagicZoom col-md-10" title="Show your product in stunning detail with Magic Zoom Plus."
                        href="{{PRODUCT_IMAGE_URL.$productsImage[0]['image_name']}}"
                        >
                     <img src="{{PRODUCT_IMAGE_URL.$productsImage[0]['image_name']}}?scale.height=400" alt=""/>
                     </a>
                  </div>
               </div>

               


               <div class="col-md-5 block animatable bounceInRight">

               {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'asked_form')) !!}
            
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$productDetail[0]['product_title']}}" id="product_name" />
                        <input type="hidden" value="{{$productDetail[0]['category_id']}}" id="category_id" />
                        <input type="hidden" value="{{$productDetail[0]['sub_category_id']}}" id="sub_category_id" />
                        <input type="hidden" value="{{$productDetail[0]['sub_sub_category_id']}}" id="sub_sub_category_id" />
                  <h2>{{ucfirst($productDetail[0]['product_title'])}}</h2>
                    
                  <?php $discount = $productDetail[0]['discount'];                    
                    $discount = ($discount/100)*$productDetail[0]['price'];
                    $discount_price = $productDetail[0]['price']-$discount;
                    $cart_discount = ($productDetail[0]['discount']/100)*$productDetail[0]['price'];
                    $cart_price = $productDetail[0]['price'] - $cart_discount;
                    ?>
                  <div class="col-md-12 reviww">

                  <?php
                        $reviews_sum = CommonHelpers::productReviews($productDetail[0]['id']);
                        $reviews_count = CommonHelpers::productReviewsCount($productDetail[0]['id']);
                        if (isset($reviews_count) && !empty($reviews_count)) {
                            $avg_rating = ($reviews_sum / $reviews_count);
                        } else {
                            $avg_rating = 0.00;
                        }
                        $number = number_format($avg_rating, 2);
                         $n = $number;

                       $whole = floor($n);
                         $fraction = $n - $whole;
                         $blank_star = 5 - $n;
                        ?>


                     <a href="javascript:void(0)" class="star">
                        <?for($i=0; $i<$whole; $i++){?>
                           <i class="fa fa-star" aria-hidden="true"></i>
                        <? } ?>
                         <?for($i=0; $i<$blank_star; $i++){?>
                           <i class="fa fa-star-o" aria-hidden="true"></i>
                        <? } ?>
                     </a> | 
                     <a href="javascript:void(0)" class="reviews" id="review_scroll">{{$reviews_count}} Reviews</a> | 
                     <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab20f13461ddb54"></script>
                     <div class="addthis_inline_share_toolbox_fyd3"></div>
<!--                     <a href="#" class="share">Share 
                         <i class="fa fa-facebook-official" aria-hidden="true"></i>
                     </a>-->
                  </div>


                  <input type="hidden" value="{{$cart_discount}}" id="discount" />
                    <input type="hidden" name="price" value="{{$cart_price}}" id="price"/>
                    <input type="hidden" name="color_id" value="{{$colorId}}" id="color_id"/>


                  <div class="col-md-12 prices">
                     <p><i class="fa fa-inr" aria-hidden="true"></i>
                         {{$discount_price}} 
                         @if(isset($discount) && !empty($discount) && $discount != 0.00)
                         <span><i class="fa fa-inr" aria-hidden="true"></i>  
                             {{number_format($productDetail[0]['price'], 2)}}
                         </span>
                         @endif                         
                     </p>
                      @if(Auth::check())
                     <a href="#" data-toggle="modal" data-target="#myModal_reviewss">Write a Review</a>
                     @else
                     <a href="#" data-toggle="modal" data-target="#myModal">Write a Review</a>
                     @endif
                  </div>
                  <div class="col-md-12 prices1">
                      
                     <p>Avaiability
                      @if($check_stock == 0)
                    <span class="stock" >Out Of Stock</span>
                    @else
                    <span>In stock</span>
                    @endif     
                     </p>
                  </div>
                  <div class="col-md-12 prices2">
                     <form action="/action_page.php">
                        <div class="form-group col-md-12">
                        <div class="col-md-12 color_gg">
                    <h4>Color</h4>
                    <?php $ss = array_unique(array_column($productDetail[0]['product_color'], 'color_id'));
                    //pr(array_intersect_key($productDetail[0]['product_color'], $ss));?>
                    @foreach(array_intersect_key($productDetail[0]['product_color'], $ss) as $color)
                    <?php 
                    $colorLists = CommonHelpers::getProductColor_image($color['color_id'],$productDetail[0]['id']);                   
                    ?>
                    @if(!empty($colorLists))
                    @if($colorId == $colorLists->color_id)
                        <span  class="" style="background: {{ $colorLists->color_picker }}; border: 1px solid;"></span>
                    @else
                        <span onClick="location.href = '{{WEBSITE_URL}}productDetail/{{ $slug }}/{{ strtolower($colorLists->slug)}}';" class="" style="background: {{ $colorLists->color_picker }}"></span>
                    @endif
                    @endif
                    @endforeach
                     </div>
                        </div>
                        <div class="form-group col-md-12">
                        <div class="col-md-12 size_gg">
                    <h4>Size</h4>                 
                    <ul>
                        @foreach($productDetail[0]['product_color'] as $sizes)
                        @if($sizes['color_id'] == $colorId)
                        <?php $size = CommonHelpers::getSize($sizes['size_id']); ?>
                        @if($sizes['quantity'] == 0)
                        <div class="radiowrapper"><a href="javascript::void(0);" ><label for="size{{$size[0]['id']}}"><strike>{{$size[0]['size']}}</strike></label></a></div>
                        @else
                        <div class="radiowrapper">
                        <input type="radio" class="size_ids" value="{{$size[0]['id']}}" id="size{{$size[0]['id']}}" name="size" />
                        <label for="size{{$size[0]['id']}}">{{$size[0]['size']}}</label>
                        </div>
                        
                       <!-- <li for = "size{{$size[0]['id']}}">
                            <a href="javascript::void(0)"  class="sizeids" data-ids = "{{$size[0]['id']}}">
                                {{$size[0]['size']}}
                            </a>
                        </li>-->
                        @endif
                        @endif
                        @endforeach
                    </ul>
                    
                </div>
                <div class="size_error"></div>
                <span class="product-cart error"></span><br/>
                        </div>
                        <div class="form-group qty col-md-12">
                           <div class="col-md-6">
                              <label for="email" class="">QTY </label>
                              <input type="number" name="qty" id="qty" min="1" value="1" placeholder="1"> 
                           </div>
                           
                           <div class="col-md-6">
                               {!! Form::button('BUY NOW',['class'=>'btn btn-default by_now','attrId'=>$productDetail[0]['id']])!!}
<!--                              <button class="btn btn-default by_now" attrId="$productDetail[0]['id']">BUY NOW</button>-->
                           </div>
                        </div>
                     </form>
                      
                  </div>

                  
                  <div class="col-md-6 btn_dtl btn_dtl1">
                          <a href="javascript:void(0)" attrId="{{$productDetail[0]['id']}}" class="btn_continue1 cart_btn"><span>Add to Cart</span></a>
                  </div>
                  <div class="col-md-6 btn_dtl">
                      @if(Auth::check())
                    <?php
                    $auth = LoginUser();
                    $wishlist = CommonHelpers::wishlist_list($auth->id, $productDetail[0]['id'], $colorId);
                    ?>                    
                    @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                     <a href="javascript::void(0);" attrId="{{$productDetail[0]['id']}}" attrColor ="{{$colorId}}" class="btn_continue1 btn_continue2 wish_deail wishBtnManageColor wishlist_btn_red wishlist-btn-color"><span>Add to Wish List</span></a>
                    @else
                     <a href="javascript::void(0);" attrId="{{$productDetail[0]['id']}}" attrColor ="{{$colorId}}" class="btn_continue1 btn_continue2 wish_deail wishlist_btn wishBtnManageColor"  style="color:black;"><span>Add to Wish List</span></a>
                     @endif
                     @else
                     <a href="javascript::void(0);" attrId="{{$productDetail[0]['id']}}" attrColor ="{{$colorId}}" class="btn_continue1 btn_continue2 wish_deail wishlist_btn wishBtnManageColor login_wishlist" name="wishlist_btn"  title="Add to wishlist" data-toggle="modal" data-target="#myModal">
                         <span>Add to Wish Cart</span>
                     </a>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="des">
         <div class="container">
            <div class="row block animatable bounceIn">
               <div class="tab">
                  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">DESCRIPTION</button>
                  <button class="tablinks" onclick="openCity(event, 'Paris')">SPECIFICATION</button>
                  <button class="tablinks lstt" onclick="openCity(event, 'Tokyo')">REVIEWS({{$reviews_count}})</button>
               </div>
               <div id="London" class="tabcontent">
                  <p>{{strip_tags($productDetail[0]['product_description'])}}
                  </p>
               </div>
               <div id="Paris" class="tabcontent">
                  <table class="speci_p">
                    
                     @if($productDetail[0]['occasion'])
                     <tr>
                        <td>Occasion</td>
                        <td>{{$productDetail[0]['occasion']}}</td>
                     </tr>
                     @endif

                     <tr>
                        <td>Size</td>
                        <td> 
                            <?php //$ss = array_unique(array_column($productDetail[0]['product_color'], 'size_id'));?>
                    @foreach($productDetail[0]['product_color'] as $value)
                    @if($value['color_id'] == $colorId)
                     <?php $sizes = CommonHelpers::getSize($value['size_id']); //pr($size);?>
                    @if($value['quantity'] == 0)
                        <strike>{{$sizes[0]['size'].', '}}</strike>
                        @else
                        {{$sizes[0]['size'].', '}}
                        @endif
                        @endif
                     @endforeach
                        </td>
                     </tr>

                     <tr>
                        <td>Color</td>
                        <td>
                             <?php $ss = array_unique(array_column($productDetail[0]['product_color'], 'color_id'));
                    //pr(array_intersect_key($productDetail[0]['product_color'], $ss));?>
                    @foreach(array_intersect_key($productDetail[0]['product_color'], $ss) as $color)
                    <?php 
                    $colorLists = CommonHelpers::getProductColor_image($color['color_id'],$productDetail[0]['id']);                   
                    ?>
                    @if(!empty($colorLists))
                        
                    <?php $colorsName[] = $colorLists->color_name;?>
                    @endif
                    @endforeach
                                    <?php //pr(array_unique($colorsName));?>
                                    {{ implode(", ", array_unique($colorsName)) }}
                        </td>
                     </tr>
                  </table>
               </div>
              
                <div id="Tokyo" class="tabcontent ratingss">
                     @if(isset($productReviews) && !empty($productReviews))
                  <div class="col-md-12 rating_review_slider">
                     <div class="">
                        @foreach($productReviews as $key=>$productReview)
                           <div class="col-md-12 review_dvc">
                              <div class="col-md-1 col-xs-2">
                                  @if(isset($productReview->profile_img) && !empty($productReview->profile_img))
                                 <img src="{{USER_IMAGE_URL.$productReview->profile_img}}">
                                 @else
                                 <img src="{{asset('img/user.png')}}">
                              @endif
                              </div>
                              <div class="col-md-11 col-xs-10">
                                 <h4>{{$productReview->first_name}} {{$productReview->last_name}}</h4>
                                 <p><a href="#" class="star">
                                         <?php $blank_star = 5 - $productReview->rating;
                                         for($i=1; $i <= $productReview->rating; $i++){?>
                                          <i class="fa fa-star" aria-hidden="true"></i>
                                       <? } ?>
                                       <?for($i=0; $i<$blank_star; $i++){?>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                         <? } ?>
<!--                                         <i class="fa fa-star" aria-hidden="true"></i>
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                         <i class="fa fa-star-o" aria-hidden="true"></i>
                                         <i class="fa fa-star-o" aria-hidden="true"></i>
                                         <i class="fa fa-star-o" aria-hidden="true"></i>-->
                                     </a>
                                 </p>
                              </div>
                              <p>{{str_limit($productReview->comment, $limit = 100, $end = '...')}}
                              </p>
                           </div>
                          @endforeach 
                          @if(isset($productReview) && !empty($productReview))
                      <div class="col-md-12 read_mrs">
                       <a href="{{URL::to('allReviews/'.$productDetail[0]['id'].'/'.$productDetail[0]['slug'])}}"> Read More</a>
                      </div>
                          @endif
                     </div>                    
                  </div>
                    @else
                  <h2>No Reviews Found</h2>
                  @endif
               </div>
                
               
                
                

              
            
               <script>
                  function openCity(evt, cityName) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                      tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                      tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                  }
                  
                  // Get the element with id="defaultOpen" and click on it
                  document.getElementById("defaultOpen").click();
               </script>
            </div>
         </div>
      </section>

<div class="modal fade review_write_popup " id="myModal_reviewss" role="dialog">
    <div class="modal-dialog">
       <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">Review & Rating</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        <div class="stars">
            <p class="success-msg login-error" style="color:green; font-size: 15px;"></p>
 {!! Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'review_form')) !!}
    <div class="form-group str_po">
<label>Rating:</label>

    <input class="star star-5" id="star-5" type="radio" value="5" name="rating"/>
    <label class="star star-5" for="star-5"></label>
    <input class="star star-4" id="star-4" type="radio" value="4" name="rating"/>
    <label class="star star-4" for="star-4"></label>
    <input class="star star-3" id="star-3" type="radio" value="3" name="rating"/>
    <label class="star star-3" for="star-3"></label>
    <input class="star star-2" id="star-2" type="radio" value="2"name="rating"/>
    <label class="star star-2" for="star-2"></label>
    <input class="star star-1" id="star-1" type="radio" value="1" name="rating"/>
    <label class="star star-1" for="star-1"></label>
</div>

     <div class="form-group rvw">
         @if(Auth::check())
        <input type="hidden" class="inputText" value="{{$auth->id}}" name="user_id"/>
        @endif
        <input type="hidden" class="inputText" value="{{$productDetail[0]['id']}}" name="product_id"/>
      <label for="comment">Review:</label>
      {!! Form::textarea('comment',null,['class'=>'form-control','placeholder'=>'Comment','id' =>'comment']) !!}
<!--      <textarea class="form-control" rows="5" id="comment"></textarea>-->
    </div>
<!--    <button type="button" class="btn btn-default">Submit</button>-->
    {!! Form::submit('Submit',['class' => 'btn btn-default','id' =>'review'])!!}
   {!! Form::close() !!}
</div>

        </div>
 
      </div>
      
    </div>
  </div>

      @if(isset($relatedProducts)  && !empty($relatedProducts))
      <section class="ariv_slider">
         <div class="container">
            <h2 class="heading_page block animatable moveUp">Related Products</h2>
            <div class="row block animatable bounceIn">
               <div id="carouselPlus" class="carousel slide multi-carousel" data-ride="carousel">
                  <div class="carousel-inner">



                  @foreach($relatedProducts as $key=>$relatedProduct)
                  @if(($relatedProduct['color_id'] != $colorId) || ($relatedProduct['id'] != $productDetail[0]['id']))
                  <?php $colorLists = CommonHelpers::getProductColor($relatedProduct['color_id']);
                    $productsImage = CommonHelpers::getProductImage($relatedProduct['id'], $relatedProduct['color_id']);?>
                     <div class="carousel-grid col-lg-3 col-md-4 col-sm-12 ">
                        <div class="d-block w-100">
                           <div class="container_hv">
                              <img class="image_hv" src="{{PRODUCT_IMAGE_URL.$productsImage[0]['image_name']}}" alt="First slide">
                              <div class="overlay_hv">
                                 <div class="text_hv">
                                    <p>
                                        @if(Auth::check())
                           <?php $auth = LoginUser();
                              $wishlist = CommonHelpers::wishlist_list($auth->id, $relatedProduct['id'], $relatedProduct['color_id']);
                              ?>
                           @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                           <a href="javascript:void(0);" id="wishlist_btn_red" attrId="{{$relatedProduct['id']}}" attrColor ="{{$relatedProduct['color_id']}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color slct">
                           <i class="fa fa-heart" aria-hidden="true"></i>
                           </a>
                           @else 
                           <a href="javascript:void(0);" id="wishlist_btn" attrId="{{$relatedProduct['id']}}" attrColor ="{{$relatedProduct['color_id']}}" class="last_icn wishlist_btn wishBtnManageColor slct">
                           <i class="fa fa-heart" aria-hidden="true"></i>
                           </a>
                           @endif
                           @else
                           <!--<a name="wishlist_btn" title="Add to wishlist" class="last_icn wishlist_btn slct login_wishlist">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                              </a>-->
                           <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" title="Add to wishlist" class="slct wishlist_btn"><i class="fa fa-heart" aria-hidden="true"></i></a>
                           @endif
<!--                                       <a href="javascript:void(0);" class="slct">
                                           <i class="fa fa-heart" aria-hidden="true"></i>
                                       </a>-->
                           
                                       <a href="{{URL::to('productDetail/'.$relatedProduct['slug'].'/'.$colorLists->slug)}}" class="slct"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </p>
                                    <p class="shop_nw">
                                        <a href="{{URL::to('productDetail/'.$relatedProduct['slug'].'/'.$colorLists->slug)}}">SHOP THIS</a></p>
                                 </div>
                              </div>
                           </div>
                           <div class="dlt">
                              <h3 class="prduct_title1"><a href="{{URL::to('productDetail/'.$relatedProduct['slug'].'/'.$colorLists->slug)}}">{{$relatedProduct['product_title']}}</a></h3>

                              <?php  $discount = $relatedProduct['discount'];
                                    $discount = ($discount/100)*$relatedProduct['price'];
                                    $discount_price = $relatedProduct['price']-$discount;
                              ?>


                              <p class="price">                                  
                                  @if(!empty($discount) && $discount != '0.00')
                                  <span><i class="fa fa-inr" aria-hidden="true"></i> 
                                      {{$relatedProduct['price']}} 
                                  </span> 
                                  @endif
                                  <i class="fa fa-inr" aria-hidden="true"></i> {{$discount_price}}
                              </p>
                              
                           </div>
                        </div>
                     </div>
                  @endif
                  @endforeach

                  </div>
                  <a class="carousel-control-prev" href="#carouselPlus" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselPlus" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                  <span class="sr-only">Next</span>
                  </a>      
               </div>
            </div>
         </div>
         <div id="lg" class="d-none d-lg-block"></div>
         <div id="md" class="d-none d-md-block d-lg-none"></div>
         <div id="sm" class="d-none d-sm-block d-md-none"></div>
         <script type="text/javascript">
            var $origin = $("#carouselPlus .carousel-inner").prop("outerHTML");
            function multiCarousel(){
            if ( $( "#lg" ).is( ":visible" ) ) {
              do {
                $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid:lt(4)" ).wrapAll( "<div class=\"carousel-item\"><div class=\"row\"></div></div>" );
                $( "#carouselPlus .carousel-inner .carousel-item:first" ).addClass("active");
              } while ( $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid" ).length );
            } else if ( $( "#md" ).is( ":visible" ) ) {
              do {
                $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid:lt(3)" ).wrapAll( "<div class=\"carousel-item\"><div class=\"row\"></div></div>" );
                $( "#carouselPlus .carousel-inner .carousel-item:first" ).addClass("active");
              } while ( $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid" ).length );
            } else {
              do {
                $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid:lt(1)" ).wrapAll( "<div class=\"carousel-item\"><div class=\"row\"></div></div>" );
                $( "#carouselPlus .carousel-inner .carousel-item:first" ).addClass("active");
              } while ( $( "#carouselPlus .carousel-inner" ).children( ".carousel-grid" ).length);
            }
            }
            $(window).on( "load resize", function() {
            $.when(
              $( "#carouselPlus .carousel-inner" ).replaceWith( $origin ),
              multiCarousel()
            ).done(function() {
              $( ".multi-carousel" ).animate({opacity: "1"}, 1000);
            });
            });
         </script>
      </section>
      @endif
<!-------Size Modal End----------->


<script>
        $(document).ready(function (){
            $("#review_scroll").click(function (){
                //$(".tabcontent ratingss").css("display", "block");
                $('html, body').animate({
                    scrollTop: $(".bounceIn").offset().top
                }, 2000);
            });
        });
    </script>
<script>
$("#review").click(function() {
		
	var comment = $("#comment").val();
	var rating = $("input[name='rating']:checked").val();
	
	/*if (comment == '' || rating == '') {
	alert("Please fill all fields...!!!!");
	return false;
	}
	else {*/
		$.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/review_post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#review_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
                        if(msg1.message=='Review submitted successfully'){
                            
							$("#review_form")[0].reset();
                                                        setTimeout(function(){                            
                                  location.reload();
                        }, 500); 
						}
						//window.location.href = {{URL::to('/')}};
                    },
                    error: function (data) {
                    }
                });
	return false;
	
	//}
});

//==========Pincode Check===================//

$("#check").click(function() {
		
	var pincode = $("#pincode").val();
	if (pincode == '' ) {
	alert("Please enter pincode...!!!!");
	return false;
	}else if(pincode.length != 6){
		
	alert("Please enter correct pincode...!!!!");
	return false;
	} 
	else {
		
		$.ajax({
                    type: "POST",
                    url: '{{URL::to("/")}}/pincode_post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData($("#pincode_form")[0]),
                    success: function (msg) {
                        msg1 = JSON.parse(msg);
                        console.log(msg1);
                        $('.success').addClass('su').html(msg1.message);
                        $('.success-msg1').html(msg1.message);
                        $(".loading-cntant").css("display", "none");
						//window.location.href = {{URL::to('/')}};	
                    },
                    error: function (data) {
                    }
                });
	return false;
	}
});

    $(document).on("click", ".cart_btn", function () {

        var url = '{{PRODUCT_IMAGE_URL}}';
        var detail_url = '{{URL::to("productDetail")}}';
        
        var self = this;
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });


        productId = $(this).attr("attrId");
        
        var qty = $('#qty').val();
      
        var size = $('input[name=size]:checked').val();

      
        
        if(size == undefined) {
            $('.size_error').text('Please Select Size.').css('color','red').css("font-size", "15px");
        }else{      
        var color_id = $('#color_id').val();
        var price = $('#price').val();
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        var sub_cat_id = $('#sub_category_id').val();
        var sub_sub_cat_id = $('#sub_sub_category_id').val();
        var discount = $('#discount').val();
        

        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/addtocart',
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
                wishlist: false},
            success: function (msg) {                
                msg1 = JSON.parse(msg);
                console.log(msg1.message);
                if(msg1.message == 'Successfully added in cart'){
                $('.shopping-cart').html(msg1.count);
                $('.shopping-cart').removeAttr("style"); 
                
            }
                
                $('.product-cart').html(msg1.message);
                $('.product-cart').css('font-size','15px');
                $('.size_error').text('');
                //$('.cart_btn').text('ADDED TO CART');
                //$('.cart_btn').prop('disabled', true);
            },
            error: function (data) {
            }
        });
        return false;
};
    });
    
    
    $(document).on("click", ".by_now", function () { 
        var url = '{{PRODUCT_IMAGE_URL}}';
        var detail_url = '{{URL::to("productDetail")}}';
        
        var self = this;
        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });


        productId = $(this).attr("attrId");
        var qty = $('#qty').val();
      
        var size = $('input[name=size]:checked').val();
        
        if(size == undefined) {
            $('.size_error').text('Please Select Size.').css('color','red').css("font-size", "15px");
        }else{      
        var color_id = $('#color_id').val();
        var price = $('#price').val();
        var product_name = $('#product_name').val();
        var category_id = $('#category_id').val();
        var sub_cat_id = $('#sub_category_id').val();
        var sub_sub_cat_id = $('#sub_sub_category_id').val();
        var discount = $('#discount').val();
        var html = [];
        $.ajax({
            type: "POST",
            url: '{{URL::to("/")}}/by_now',
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
            },
            success: function (msg) {                
               msg1 = JSON.parse(msg);
                console.log(msg1.order);
                //$('.shopping-cart').html(msg1.count);
                //$('.product-cart').html(msg1.message);
                //$('.size_error').text('');
               if(msg1.order != ''){
                setTimeout(function () {
                    @if (Auth::check())
                        $('.size_error').text('');
                        $('.product-cart').text('');
                        window.location.assign("{{URL::to('ByNow')}}/"+msg1.order);
                    @else
                        $('.size_error').text('');
                        $('.product-cart').text('');
                window.location.assign("{{URL::to('bynow')}}/"+msg1.order);
            @endif
                }, 2000);
            }else{
                $('.product-cart').html(msg1.message);
                $('.size_error').text('');
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
    
</script>
@stop
