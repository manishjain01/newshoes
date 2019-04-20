@extends('layouts.inner') 
@section('content')

<section class="item_found">
   <div class="container">
      <div class="col-md-3"></div>
      <div class="col-md-9">
          <div class="row show_rslt block animatable bounceInRight">
               <ul class="col-md-8">
                     <li class="active_sort"><a href="javascript::void(0);">Sort By</a></li>
                     <li><a href="#">@sortablelink('price', 'Price')</a></li>
                     <li><a href="#">@sortablelink('created_at', 'Newest First')</a></li>
                  </ul>
                    <?php $i = $products2->perPage() * ($products2->currentPage() - 1);
                   //echo $i.'dd'.$products2->perPage().'fff'.$products2->currentPage().'ssfff'.$products2->count();
                   ?>                 
<!--              <p class="cl-md-4">Showing {{$i+1}}–{{$products2->count()}} of {{$products2->total()}} results</p>-->
               
            </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-3 filter_showw">
            <h3 class="filter_heaidng block animatable bounceInLeft">Filter By</h3>
            {!! Form::open(array('novalidate' => 'novalidate','method' => 'GET','id'=>'search_form','name'=>'search_form')) !!}
          @if(!empty($main_lists))
            <div class="col-md-12 block animatable moveUp">
               <h4 onclick="myFunction_in()" id="flip_gndr"><i class="fa fa-plus" aria-hidden="true"></i> Gender</h4>
               <div class="value1" id="panel_gndr" style="display: none;">
                  <span id="dots_in"></span>                    
                      @foreach($main_lists as $key=>$catList)
                     <div class="form-group">
                        <label class="container_check1">{{ ucfirst($catList->cat_name) }}
                            <input   type="checkbox" name="man_cats[]" value="{{$catList->id}}" <?php if(in_array($catList->id,$mancatArr)){?> checked="checked" <?php }?>>
                        <span style="display:none;" class="checkmark_check1"></span>
                        </label>
                     </div>
                      @endforeach                     
               </div>
            </div>
             @endif
            <script> 
               $(document).ready(function(){
                 $("#flip_gndr").click(function(){
                   $("#panel_gndr").slideToggle("slow");
                 });
               });
            </script>
            <script>
               function myFunction_in() {
                 var dots_in = document.getElementById("dots_in");
                 var moreText_in = document.getElementById("panel_gndr");
                 var btnText_in = document.getElementById("flip_gndr");
               
                 if (dots_in.style.display === "none") {
                   dots_in.style.display = "inline";
                   btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Gender'; 
                   
                 } else {
                   dots_in.style.display = "none";
                   btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Gender'; 
                  
                 }
               }
            </script> 
            @if(!empty($category_lists))
            <div class="col-md-12 block animatable moveUp">
               <h4 id="flip_cat" onclick="myFunction_cat()"><i class="fa fa-plus" aria-hidden="true"></i> Category</h4>
               <div class="value1" id="panel_cat" style="display: none;">
                  <span id="dots_in1"></span>
                      @foreach($category_lists as $key=>$catList)
                     <div class="form-group">
                        <label class="container_check1">{{ ucfirst($catList->cat_name) }}
                            <input type="checkbox" name="cats[]" value="{{$catList->id}}" <?php if(in_array($catList->id,$catArr)){?> checked="checked" <?php }?>>
                        <span class="checkmark_check1"></span>
                        </label>
                     </div>
                      @endforeach   
                     
               </div>
            </div>
            @endif
            <script> 
               $(document).ready(function(){
                 $("#flip_cat").click(function(){
                   $("#panel_cat").slideToggle("slow");
                 });
               });
            </script>
            <script>
               function myFunction_cat() {
                 var dots_in = document.getElementById("dots_in1");
                 var moreText_in = document.getElementById("panel_cat");
                 var btnText_in = document.getElementById("flip_cat");
               
                 if (dots_in.style.display === "none") {
                   dots_in.style.display = "inline";
                   btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Category'; 
                   
                 } else {
                   dots_in.style.display = "none";
                   btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Category'; 
                  
                 }
               }
            </script>
           @if(!empty($brands))
            <div class="col-md-12 block animatable moveUp">
               <h4 id="flip_brand" onclick="myFunction_brand()"><i class="fa fa-plus" aria-hidden="true"></i> Brands</h4>
               <div class="value1" id="panel_brand" style="display: none;">
                  <span id="dots_in3"></span>
                 @foreach($brands as $key=>$brand)
                     <div class="form-group">
                        <label class="container_check1">{{ ucfirst($brand->brand_name) }}
                        <input type="checkbox" name="brands[]" value="{{$brand->id}}" <?php if(in_array($brand->id,$brandArr)){?> checked="checked" <?php }?> />
                
                        <span class="checkmark_check1"></span>
                        </label>
                     </div>
                 @endforeach   
                 
               </div>
            </div>
            @endif
            <script> 
               $(document).ready(function(){
                 $("#flip_brand").click(function(){
                   $("#panel_brand").slideToggle("slow");
                 });
               });
            </script>
            <script>
               function myFunction_brand() {
                 var dots_in = document.getElementById("dots_in3");
                 var moreText_in = document.getElementById("panel_brand");
                 var btnText_in = document.getElementById("flip_brand");
               
                 if (dots_in.style.display === "none") {
                   dots_in.style.display = "inline";
                   btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Brands'; 
                   
                 } else {
                   dots_in.style.display = "none";
                   btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Brands'; 
                  
                 }
               }
            </script>
           
            <div class="col-md-12 block animatable moveUp">
                <h4 id="flip_price" onclick="myFunction_price()"><i class="fa fa-plus" aria-hidden="true"></i> Price</h4>
                <div class="value1 price_dvs" id="panel_price" style="display: none;">
                    <span id="dots_in2"></span>
                    <script>
                        $(document).ready(function() {
                                  var minprice = '<?=$minArr?>' || 0;
                                  var maxprice = '<?=$maxArr?>' || 10000;
                              $( "#mySlider" ).slider({
                                range: true,
                                min: 0,
                                max: 10000,
                                values: [ minprice, maxprice ],
                                stop: function( event, ui ) { console.log(ui.values[ 0 ])
                                    var firstVal = 0;
                                     var secondVal = 0;
                                    if(ui.values[ 0 ] < 1000){
                                        $( "#min_price" ).val(0);
                                           firstVal = 0;
                                    }else if(ui.values[ 0 ] < 2000 ){
                                        $( "#min_price" ).val(1000);
                                        firstVal = 1000;
                                    }else if(ui.values[ 0 ] < 3000 ){
                                        $( "#min_price" ).val(2000);
                                        firstVal = 2000;
                                    }else{
                                        $( "#min_price" ).val(3000);
                                        firstVal = 3000;
                                    }
                                    
                                    
                                    if(ui.values[ 1 ] <= 4000){
                                        $( "#max_price" ).val(0);
                                        secondVal = 4000;
                                        
                                    }else if(ui.values[ 1 ] <= 8000 ){                                        
                                        $( "#max_price" ).val(8000);
                                        secondVal = 8000;
                                    }else{
                                        $( "#max_price" ).val(10000);
                                        secondVal = 10000;
                                    }
                                    //console.log("a", $( "#mySlider" ).slider( "values", [firstVal,secondVal] ));
                                    if($( "#mySlider" ).slider( "values", [firstVal,secondVal] )){
                                    $("#search_form").submit();
                                }
                               }
                              });
                              
                                
                              });
                          
                    </script>
                    <p class="rng_p">

                        <input type="text" id="price" style="border:0; color:#fa4b2a; font-weight:bold;">
                    </p>

                    <div id="mySlider"></div>



                    <div class="slct1 col-md-12">
                         <?php  $minPrice = array('0'=>'Min','1000'=>'1000','2000'=>'2000','3000'=>'3000');
                                $maxPrice = array('4000'=>'4000','8000'=>'8000','10000'=>'10000');
                               ?>
                              {!! Form::select('min_price', $minPrice, $minArr, ['id'=>'min_price','class' => 'col-md-4 col-xs-4']) !!}

                              <p class="col-md-4 col-xs-4">To</p>
                              {!! Form::select('max_price', $maxPrice, $maxArr, ['id'=>'max_price','class' => 'col-md-4 col-xs-4']) !!}


                    </div>
                </div>
            </div>
            <script> 
                     $(document).ready(function(){
                       $("#flip_price").click(function(){
                         $("#panel_price").slideToggle("slow");
                       });
                     });
                  </script>
                  <script>
                     function myFunction_price() {
                       var dots_in = document.getElementById("dots_in2");
                       var moreText_in = document.getElementById("panel_price");
                       var btnText_in = document.getElementById("flip_price");
                     
                       if (dots_in.style.display === "none") {
                         dots_in.style.display = "inline";
                         btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Price'; 
                         
                       } else {
                         dots_in.style.display = "none";
                         btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Price'; 
                        
                       }
                     }
                  </script>
             <div class="col-md-12 block animatable moveUp">
               <h4 id="flip_color" onclick="myFunction_color()"><i class="fa fa-plus" aria-hidden="true"></i> Colors</h4>
               <div class="value1" id="panel_color" style="display: none;">
                  <span id="dots_in4"></span>
                  <div class="p">
                     <?php $colorLists = CommonHelpers::getcolorlist();?>
                     @foreach($colorLists as $key=>$colorList)
                     <div class="form-group">
                        <label class="container_check1"><span class="colors clr1" style="background:{{$colorList->color_picker}};"></span> {{ucfirst($colorList->color_name)}}
                        <input type="checkbox" name="colors[]" value="{{$colorList->id}}" <?php if(in_array($colorList->id,$colorArr)){?> checked="checked" <?php }?> />
                        <span class="checkmark_check1"></span>
                        </label>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            <script> 
               $(document).ready(function(){
                 $("#flip_color").click(function(){
                   $("#panel_color").slideToggle("slow");
                 });
               });
            </script>
            <script>
               function myFunction_color() {
                 var dots_in = document.getElementById("dots_in4");
                 var moreText_in = document.getElementById("panel_color");
                 var btnText_in = document.getElementById("flip_color");
               
                 if (dots_in.style.display === "none") {
                   dots_in.style.display = "inline";
                   btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Colors'; 
                   
                 } else {
                   dots_in.style.display = "none";
                   btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Colors'; 
                  
                 }
               }
            </script>
            <div class="col-md-12 block animatable moveUp">
               <h4 id="flip_size" onclick="myFunction_size()"><i class="fa fa-plus" aria-hidden="true"></i> Size & Fit</h4>
               <div class="value1" id="panel_size" style="display: none;">
                  <span id="dots_in5"></span>
                
                     <div class="p">
                        @foreach($sizeLists as $key=>$value)
                        <div class="form-group">
                           <label class="container_check1">{{$value->size}}
                           <input type="checkbox" name="sizes[]" value="{{$value->id}}" <?php if(in_array($value->id,$sizeArr)){?> checked="checked" <?php }?>>
                           <span class="checkmark_check1"></span>
                           </label>
                        </div>
                        @endforeach
                     </div>
                 
               </div>
            </div>
            <script> 
               $(document).ready(function(){
                 $("#flip_size").click(function(){
                   $("#panel_size").slideToggle("slow");
                 });
               });
            </script>
            <script>
               function myFunction_size() {
                 var dots_in = document.getElementById("dots_in5");
                 var moreText_in = document.getElementById("panel_size");
                 var btnText_in = document.getElementById("flip_size");
               
                 if (dots_in.style.display === "none") {
                   dots_in.style.display = "inline";
                   btnText_in.innerHTML = '<i class="fa fa-plus" aria-hidden="true"></i> Size & Fit'; 
                   
                 } else {
                   dots_in.style.display = "none";
                   btnText_in.innerHTML = '<i class="fa fa-minus " aria-hidden="true"></i> Size & Fit'; 
                  
                 }
               }
            </script>
            {!! Form::close() !!}
         </div>
         <!--category--->
         <div class="col-md-9 list_produ">
            @if(!$products2->isEmpty())
            @foreach($products2 as $key=> $product)
            <?php $colorLists = CommonHelpers::getProductColor_image($product->color_id, $product->id);
                  //$colorLists = CommonHelpers::getProductColor($product->color_id);
                     $images = CommonHelpers::getProductImage($product->id, $product->color_id);
                     //pr($colorLists);
                     ?>
            @if(isset($images) && !empty($images) && !empty($colorLists))
            <div class="col-md-4 block animatable moveUp">
               <div class="container_hv">
                  
                  @if(!empty($images[0]))  
                  <img class="image_hv" src="{{PRODUCT_IMAGE_URL.$images[0]['image_name']}}" alt="{{$product->product_title}}"/>
                  @else
                  <img class="image_hv" src="{{asset('img/no-image.png')}}" alt="{{$product->product_title}}"/>
                  @endif
                  <div class="overlay_hv">
                     <div class="text_hv">
                        <p>
                           @if(Auth::check())
                           <?php $auth = LoginUser();
                              $wishlist = CommonHelpers::wishlist_list($auth->id, $product->id, $product->color_id);
                              ?>
                           @if(isset($wishlist['0']['id']) && !empty($wishlist['0']['id']))
                           <a href="javascript:void(0);" id="wishlist_btn_red" attrId="{{$product->id}}" attrColor ="{{$product->color_id}}" class="last_icn wishBtnManageColor wishlist_btn_red wishlist-btn-color slct">
                           <i class="fa fa-heart" aria-hidden="true"></i>
                           </a>
                           @else 
                           <a href="javascript:void(0);" id="wishlist_btn" attrId="{{$product->id}}" attrColor ="{{$product->color_id}}" class="last_icn wishlist_btn wishBtnManageColor slct">
                           <i class="fa fa-heart" aria-hidden="true"></i>
                           </a>
                           @endif
                           @else
                           <!--<a name="wishlist_btn" title="Add to wishlist" class="last_icn wishlist_btn slct login_wishlist">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                              </a>-->
                           <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" title="Add to wishlist" class="slct wishlist_btn"><i class="fa fa-heart" aria-hidden="true"></i></a>
                           @endif
<!--                           <a href="#" class="slct"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>-->
                           <a href="{{URL::to('productDetail/'.$product->slug.'/'.$colorLists->slug)}}" class="slct"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </p>
                        <p class="shop_nw"><a href="{{URL::to('productDetail/'.$product->slug.'/'.$colorLists->slug)}}">SHOP THIS</a></p>
                     </div>
                  </div>
               </div>
               <div class="dlt">
                  <h3 class="prduct_title1"><a class="pro_title_new" href="{{URL::to('productDetail/'.$product->slug.'/'.$colorLists->slug)}}">{{$product->product_title}}</a></h3>
                  <?php $discount = $product->discount;
                     $discount = ($discount/100)*$product->price;
                     $discount_price = $product->price-$discount; 
                                    ?>
                  <p class="price">
                      @if(!empty($discount) && $discount != '0.00')
                      <span><i class="fa fa-inr" aria-hidden="true"></i> {{$product->price}} </span>
                      @endif
                      <i class="fa fa-inr" aria-hidden="true"></i> {{$discount_price}}
                  </p>
<!--                  <p class="size"><a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a></p>-->
               </div>
            </div>
            @endif
            @endforeach
            <div class="col-md-12 pg_ni">
                     
                <ul>
            {!! $products2->appends(Input::all('page'))->render() !!}</ul></div>
            @else
            <div><h2>&nbsp;Sorry, We couldn't Find any matches!</h2></div>
            @endif
         </div>
      </div>
   </div>
</section>
<script>
    $("input[type=checkbox]").on("change", function() {
                        $("#search_form").submit(); 
                    });
                    $("#min_price").on("change", function() {
                        $("#search_form").submit(); 
                    });
                    $("#max_price").on("change", function() {
                        $("#search_form").submit(); 
                    });
</script>
@stop
