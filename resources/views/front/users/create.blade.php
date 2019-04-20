@extends('layouts.frontend')
@section('content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <!--================Slider Reg Area =================-->
        <section class="slider_area">
            <div class="slider_inner">
                <div class="rev_slider" data-version="5.3.0.2" id="home-slider" style="min-height:796px;    padding-bottom: -400px;margin-bottom: 400px;">
                    <ul> 
                       <li data-slotamount="7" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="600" data-rotate="0" data-saveperformance="off">
                            <!-- MAIN IMAGE -->
                            <img src="{{asset('img/slider-img/slider-1.jpg')}}"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                            <!-- LAYERS -->
                        </li>
                        <li data-slotamount="7" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="600" data-rotate="0" data-saveperformance="off">
                            <!-- MAIN IMAGE -->
                            <img src="{{asset('img/slider-img/slider-2.jpg')}}"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                            <!-- LAYERS -->
                        </li>
                        
                    </ul> 
                </div><!-- END REVOLUTION SLIDER -->
            </div>
            <div class="registration_form_area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="registration_form_s">
                                <h4>Registration</h4>
                               {!! Form::open(['route'=>'front.users.store','files'=>true]) !!} 
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No">
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
										
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                                          
                                    </div>
                                    
                                  
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <div class="search_option">
												<div class="form-group">
													<select class="form-control gender" name="gender" id="gender">
														<option selected disabled>Gender</option>
														<option value="Woman">Woman</option>
														<option value="Man">Man</option>
														<option value="Male">Male</option>
													</select>
												</div>
											</div>
                                        </div>
                                        
                                    </div>
                                    <div class="reg_chose form-group">
                                        {!! Form::button('Register Now',['class'=>'btn form-control login_btn','id'=>'registration_form1'])!!}
                                    </div>
                               {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form_man">
                                <img src="img/registration-man.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Slider Reg Area =================-->
        
        <!--================Welcome Area =================-->
        <section class="welcome_area">
            <div class="container">
                <div class="welcome_title">
                    <h3>Welcome to <span>Vero</span>Date</h3>
                    <img src="img/w-title-b.png" alt="">
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="welcome_item">
                            <img src="img/welcome-icon/w-icon-1.png" alt="">
                            <h4 class="counter">1611</h4>
                            <h6>Total Members</h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="welcome_item">
                            <img src="img/welcome-icon/w-icon-2.png" alt="">
                            <h4 class="counter">500</h4>
                            <h6>Members online</h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="welcome_item">
                            <img src="img/welcome-icon/w-icon-3.png" alt="">
                            <h4 class="counter">300</h4>
                            <h6>Men online</h6>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="welcome_item">
                            <img src="img/welcome-icon/w-icon-4.png" alt="">
                            <h4 class="counter">200</h4>
                            <h6>Women online</h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Welcome Area =================-->
        
        <!--================Download Area =================-->
        <section class="download_area">
            <div class="download_full_slider">
                <div class="container">
                    <div class="row">
                        <div class="item">
                            <div class="col-md-7">
                                <div class="download_app_icon">
                                    <h3>Download <span>Vero</span><span>Date</span> app</h3>
                                    <h5>Free Available in All Store PlayStore, AppStore & Microsoft Store</h5>
                                    <ul>
                                        <li><a href="#"><i class="fa fa-android"></i></a></li>
                                        <li><a href="#"><i class="fa fa-apple"></i></a></li>
                                        <li><a href="#"><i class="fa fa-windows"></i></a></li>
                                    </ul>
                                </div>
                                <div class="download_content">
                                    <div class="item">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.The point of using Lorem Ipsum is that it has a more-or-less normal distribution.</p>
                                        <h4>Amanda Davidson</h4>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="item">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.The point of using Lorem Ipsum is that it has a more-or-less normal distribution.</p>
                                        <h4>Amanda Davidson</h4>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="item">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.The point of using Lorem Ipsum is that it has a more-or-less normal distribution.</p>
                                        <h4>Amanda Davidson</h4>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="download_moblie">
                                    <div class="download_m_slider">
                                        <img src="img/mobile-slider/mobile-1.png" alt="">
                                        <div class="download_moblile_slider">
                                            <div class="item">
                                                <img src="img/mobile-slider/screen-1.png" alt="">
                                            </div>
                                            <div class="item">
                                                <img src="img/mobile-slider/screen-2.png" alt="">
                                            </div>
                                            <div class="item">
                                                <img src="img/mobile-slider/screen-3.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Download Area =================-->    

        
        <!--================Testimonials Area =================-->
        <section class="testimonials_area">
            <div class="container">
                <div class="welcome_title">
                    <h3>Testimonials</h3>
                    <img src="img/w-title-b.png" alt="">
                </div>
                <div class="testimonials_slider">
                    <div class="item">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="test_left_content">
                                    <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, <span>so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</span>  These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="test_man">
                                    <img class="img-circle" src="img/testimonials/testimonials-1.png" alt="">
                                    <h4>David Parkar</h4>
                                    <h5>Graphic Designer </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="test_left_content">
                                    <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, <span>so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</span>  These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="test_man">
                                    <img class="img-circle" src="img/testimonials/testimonials-1.png" alt="">
                                    <h4>David Parkar</h4>
                                    <h5>Graphic Designer </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Testimonials Area =================-->
        
        <!--================Blog slider Area =================-->
        <section class="blog_slider_area">
            <div class="blog_slider_inner">
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-1.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-3.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-4.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-1.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-3.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single_blog_slider">
                        <img src="img/blog/blog_slider/blog_slider-1.jpg" alt="">
                        <div class="blog_item_content">
                            <h4>Your Blog title here</h4>
                            <h5>03 Sep, 2016 <span>|</span> Dating</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Blog slider Area =================-->
        
        <!--================Register Members slider Area =================-->
        <section class="register_members_slider">
            <div class="container">
                <div class="welcome_title">
                    <h3>Latest registered members</h3>
                    <img src="img/w-title-b.png" alt="">
                </div>
                <div class="r_members_inner">
                    <div class="item">
                        <img src="img/members/r_members-1.png" alt="">
                        <h4>Rocky Ahmed</h4>
                        <h5>22 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-2.png" alt="">
                        <h4>Alex Jones</h4>
                        <h5>23 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-3.png" alt="">
                        <h4>Nancy Martin</h4>
                        <h5>25 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-4.png" alt="">
                        <h4>Kavin Smith</h4>
                        <h5>20 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-5.png" alt="">
                        <h4>Lena Adms</h4>
                        <h5>26 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-6.png" alt="">
                        <h4>Peter Nevill</h4>
                        <h5>20 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-2.png" alt="">
                        <h4>Alex Jones</h4>
                        <h5>23 years old</h5>
                    </div>
                    <div class="item">
                        <img src="img/members/r_members-3.png" alt="">
                        <h4>Nancy Martin</h4>
                        <h5>25 years old</h5>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Register Members  slider Area =================-->
<script>
    $(document).ready(function () {
        $('#Login-id').click(function () {
            $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                type: "POST",
                url: 'login_post',
                data: {email: email, password: password},
                success: function (msg) {
                   msg1 = JSON.parse(msg);
                    //alert(msg);
                    $('.error-email').html(msg1.email);
                    $('.error-pwd').html(msg1.password);
                    $('.error').html(msg1.error);
                    $('.success').html(msg1.success);
                },
                error: function (data) {
                }
            });
        });


        $('#registration_form').click(function () {
			
            $.ajaxSetup(
                    {
                        headers:
                                {
                                    'X-CSRF-Token': $('input[name="_token"]').val()
                                }
                    });
            var name = $('#full_name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            var mobile = $('#mobile').val();
            var address = $('#address').val();
            var gender = $('#gender').val();
           
            $.ajax({
                type: "POST",
                url: 'register',
                data: {name:name, email: email, password: password, confirm_password:confirm_password, mobile:mobile, address:address},
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                   
                    console.log(msg1);  
                    $('.error-email').html(msg1.email);
                    $('.error-full_name').html(msg1.full_name);
                },
                error: function (data) {
                }
            });
        });

    });

</script>

