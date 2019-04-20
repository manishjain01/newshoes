<nav class="navbar navbar-inverse">
    <div class="container-fluid top_br">
        <ul>
            <li class="dropdown_wish_new">
                <div class="dropbtn_wish_new">
                    <div class="sonar-wrapper">
                        <a href="javascript:void(0);" class="btn_wish sonar-emitter">

                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <?php if(Auth::check()): ?>
                            <?php
                            $auth = LoginUser();
                            $count = CommonHelpers::count_wishlist($auth->id);
                            ?>
                            <sup class="count_wish" <?php if (empty($count) && $count == 0) { ?> style="display:none;" <?php } ?>>
                                <?php echo e($count); ?> 
                            </sup>
                            <?php endif; ?> 
                        </a>
                    </div>
                </div>

                <div class="dropdown-content_wish_new">
                    <?php if(Auth::check()): ?>
                    <?php
                    $auth = LoginUser();
                    $count = CommonHelpers::count_wishlist($auth->id);
                    ?>

                    <h3>YOUR WISHLIST (<?php echo e($count); ?>)</h3>


            <?php $wishlistProducts = CommonHelpers::allWishlistProducts($auth->id); ?>
                    <ul id="wishlist_dropdown">

                        <?php foreach($wishlistProducts as $key=>$value): ?> 
                        <?php
                        $discount = ($value->discount/100)*$value->price;
                        $discount_price = $value->price-$discount;
                        $images = CommonHelpers::getProductImage($value->product_id, $value->color_id);
                        $colorLists = CommonHelpers::getProductColor($value->color_id);
                        ?>
                        <li <?php if($value->status == 0){?>class="wishlist_block"<?php }?>>
                            <a href="<?php echo e(URL::to('productDetail/'.$value->slug.'/'.$colorLists->slug)); ?>">
                                <img src="<?php echo e(PRODUCT_IMAGE_URL.$images['0']['image_name']); ?>">
                                <h4><?php echo e($value->product_title); ?></h4>
                                <span class="wishlist_price"><i class="fa fa-inr" aria-hidden="true"></i> <b><?php echo e($value->price); ?></b></span>
                                <span class="price"><i class="fa fa-inr" aria-hidden="true"></i> <b><?php echo e($discount_price); ?></b></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo e(URL::to('user_wishlist')); ?>" class="goto">GO TO WISHLIST</a>
                    <?php else: ?>
                    YOUR WISHLIST (0)
                    <?php endif; ?>
                </div>
            </li>


            <?php
            if (Auth::check()) {
                $auth = LoginUser();
                $userId = $auth->id;
            } else {
                $userId = 0;
            }
            $session_id = session()->getId();
            $countCart = CommonHelpers::count_cartlist($session_id, $userId);
            ?>
            <li>

                <a href="<?php echo e(URL::to('cartDetail/')); ?>" class="btn_wish">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <?php if($countCart !=0): ?>

                    <sup class="shopping-cart"><?php echo e($countCart); ?></sup>
                    <?php endif; ?>

                </a>
            </li>
        </ul>
    </div>
    <div class="container-fluid mid_nav">
        <div class="navbar-header col-md-4 col-xs-10">
            <a class="navbar-brand" href="<?php echo e(URL::to('/')); ?>"><img src="img/logo.png"></a>
        </div>
        <div class="collapse navbar-collapse col-md-8 col-xs-2" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">

                <?php
                if (Auth::check()) {
                    $auth = LoginUser();
                    $userId = $auth->id;
                } else {
                    $userId = 0;
                }
                $session_id = session()->getId();
                $countCart = CommonHelpers::count_cartlist($session_id, $userId);
                ?>


                <?php if(Auth::check()): ?>
                <?php if($auth): ?>
                <li>
                    <?php echo HTML::link(route('account_info'), ucfirst($auth->first_name), array('class' => '')); ?>

                </li>

                <li>
                    <?php echo HTML::link(route('web.logout'), 'Logout', array('class' => '')); ?>

                </li>
                <?php endif; ?>
                <?php else: ?>
                <li>
                    <a href="#" class="login_btn" data-toggle="modal" data-target="#myModal">Login <i class="fa fa-user" aria-hidden="true"></i></a>
                </li>

                <?php endif; ?>


                <li>
                    <div id="mySidenav" class="sidenav side_navn">
                        <a href="javascript:void(0)" class="closebtn " onclick="closeNav()">&times;</a>
                        <ul>

                            <?php $catLists = CommonHelpers::getcatlist(); ?>	
                            <?php foreach($catLists as $key=> $catList): ?>
                            <?php $catSubLists = CommonHelpers::getsubCatlist($catList->id);
                            ?>

                            <li><a href="<?php echo e(URL::to('productCat/'.$catList->slug)); ?>"><?php echo e(strtoupper($catList->cat_name)); ?> </a><i class="fa fa-chevron-down" aria-hidden="true" id="menu<?php echo e($key); ?>"></i>

                                <ul id="submenu<?php echo e($key); ?>" class="submenuss" style="display: none;">
                                    <?php foreach($catSubLists as $catSubList): ?>
                                    <li><a href="<?php echo e(URL::to('productCat/'.$catList->slug.'/'.$catSubList->slug)); ?>"><?php echo e(ucfirst($catSubList->cat_name)); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>

                            <script>
                                $(document).ready(function () {
                                    $("#menu<?php echo e($key); ?>").click(function () {
                                        $("#submenu<?php echo e($key); ?>").slideToggle("slow");
                                    });
                                });
                            </script>
                            <?php endforeach; ?>
                        </ul>
                    </div>



                    <span class="block animatable bounceInRight" style="font-size:45px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true" style="border:none;"></i></span>
                    <script>
                        function openNav() {
                            document.getElementById("mySidenav").style.width = "300px";
                        }

                        function closeNav() {
                            document.getElementById("mySidenav").style.width = "0";
                        }
                    </script>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php $cmslist = CommonHelpers::getcmslist();
//pr($cmslist);exit
?>
<!-- Modal -->
<div class="modal fade loginn" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 login_form">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="home1">LOGIN</a></li>
                        <li><a data-toggle="tab" href="#sign_m1" id="sign_m11">SIGNUP</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <p class="success-msg1 login-error" style="color:#EED638;"></p>

                            <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'login_form','class' =>'log_fm')); ?>

                            <div class="form-group col-md-12">
                                <label for="email">Email:</label>
                                <?php echo Form::email('email',null,['class'=>'form-control', 'id'=>'email','required' => '']); ?>

                            </div>
                            <div class="form-group col-md-12">
                                <label for="pwd">Password:</label>
                                <?php echo Form::password('password',['class'=>'form-control', 'id'=>'password','required' => '']); ?>

                                <a href="javascript:void(0)" class="forgot_pas" id="show_forgot">Forgot password</a>
                            </div>
                            <div class="form-group col-md-12">
                                <button id="login" class="btn btn-default">Login Securely</button>
                                <?php /*?><p class="trm_condi">By creating this account, you agree to our 
                                    <a href="{{URL::to('page/'.$cmslist['2']['slug'])}}">Terms & Conditions </a>
                                    &<a href="{{URL::to('page/'.$cmslist['1']['slug'])}}"> Privacy Policy</a> .</p><?php */?>
                            </div>
                            <?php echo Form::close(); ?>




                            <p class="success-msg login-error" style="color:#EED638;"></p>
                            <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'forgot_password','style'=>'display:none;','id'=>'forgot')); ?>

                            <div class="form-group col-md-12">
                                <label for="email">Email:</label>
                                <?php echo Form::email('username',null,['class'=>'form-control', 'id'=>'username','placeholder'=>'Your email address','required' => '']); ?>


                                <a href="javascript:void(0)" class="forgot_pas" id="hide_forgot">Login</a>
                            </div>
                            <div class="form-group col-md-12">
                                <?php echo Form::button('Email Reset Link',['class'=>'cs reset btn btn-default', 'id'=>'forgot_id']); ?>  
                            </div>
                            <?php echo Form::close(); ?>






                        </div>
                        <div id="sign_m1" class="tab-pane fade">
                            <?php echo Form::open(array('novalidate' => 'novalidate','files'=>true,'id'=>'reg_form')); ?>

                            <input type="hidden" name="_Token" value="<?php echo e(csrf_token()); ?>">
                            <p class="success-msg login-error" style="color:#EED638;"></p>
                            <div class="form-group col-md-6">
                                <label for="email">First Name:</label>
                                <?php echo Form::text('first_name',null,['class'=>'form-control', 'id'=>'first_name', 'placeholder'=>'Enter First Name','required' => '']); ?>

                           <span class="first_name_er error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Last Name:</label>
                                <?php echo Form::text('last_name',null,['class'=>'form-control', 'id'=>'last_name','placeholder'=>'Enter Last Name','required' => '']); ?>

                            <span class="last_name_er error"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email:</label>
                                <?php echo Form::text('email',null,['class'=>'form-control', 'id'=>'email_register','placeholder'=>'Enter Email','required' => '']); ?>

                            <span class="email_register_er error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pwd">Password:</label>
                                <?php echo Form::password('password',['class'=>'form-control', 'placeholder'=>'Enter Password','id'=>'password_register','required' => '']); ?>

                            <span class="password_register_er error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pwd">Confirm Password:</label>
                                <?php echo Form::password('confirm_password',['class'=>'form-control', 'placeholder'=>'Enter Confirm Password','id'=>'confirm_password','required' => '']); ?>

                            <span class="floating-label confirm_password_er error"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Contact Number:</label>
                                <?php echo Form::text('phone',null,['class'=>'form-control', 'placeholder'=>'Enter Mobile No','id'=>'phone','required' => '']); ?>

                                <span class="phone_er error"></span>
                                <p class="trm_condi">By creating this account, you agree to our 
                                    <a href="<?php echo e(URL::to('page/'.$cmslist['2']['slug'])); ?>">Terms & Conditions </a>
                                    &<a href="<?php echo e(URL::to('page/'.$cmslist['1']['slug'])); ?>"> Privacy Policy</a> .</p>
                            </div>
                            <div class="form-group col-md-12">
                                <button id="register" class="btn btn-default">Proceed</button>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $("#register").click(function () {
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email = $("#email_register").val();
        var phone = $("#phone").val();
        var password = $("#password_register").val();
        var confirm_password = $("#confirm_password").val();

        if ($.trim(first_name) == "") {
            $('.first_name_er').text('please enter first name');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if ($.trim(last_name) == "") {
            $('.first_name_er').text('');
            $('.last_name_er').text('please enter last name');
            $('.email_register_er').text('');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if ($.trim(email) == "") {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('please enter email');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if (!validateEmail(email)) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('Invalid Email Format');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if (!validateEmail(email)) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('please enter phone');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if ((password.length) < 6) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('');
            $('.password_register_er').text('password must be at least 6 characters long.');
            $('.confirm_password_er').text('');
            return false;
        } else if ($.trim(confirm_password) == "") {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('please enter confirm password.');
            return false;
        }else if (($.trim(password)) != ($.trim(confirm_password))) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('');
            $('.password_register_er').text('');
            $('.confirm_password_er').text("Password and Confirm password don't match.");            
            return false;

        }else if (phone.length != 10) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('Please enter 10 digit mobile number');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if (!$('#phone').val().match('[0-9]{10}')) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('Please enter 10 digit mobile number');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        } else if (!$('#phone').val().match('[0-9]{10}')) {
            $('.first_name_er').text('');
            $('.last_name_er').text('');
            $('.email_register_er').text('');
            $('.phone_er').text('Please put 10 digit mobile number');
            $('.password_register_er').text('');
            $('.confirm_password_er').text('');
            return false;
        }  else {
            $.ajax({
                type: "POST",
                url: '<?php echo e(URL::to("/")); ?>/register',
                cache: false,
                processData: false,
                contentType: false,
                data: new FormData($("#reg_form")[0]),
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    $('.success').addClass('su').html(msg1.message);
                    $('.success-msg').html(msg1.message);
                    $(".loading-cntant").css("display", "none");
                    $('.first_name_er').text('');
                    $('.last_name_er').text('');
                    $('.email_register_er').text('');
                    $('.phone_er').text('');
                    $('.password_register_er').text('');
                    $('.confirm_password_er').text('');
                    if (msg1.message == 'Activate the link on email for registration complete.')
                    {
                        $("#reg_form")[0].reset();
                    }
                },
                error: function (data) {
                }
            });
            return false;
        }
    });


    $("#login").click(function () {

        var url = window.location.pathname;
        var email = $("#email").val();
        var password = $("#password").val();

        if (!validateEmail(email)) {
            $('.success-msg1').html("Invalid Email Format");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo e(URL::to("/")); ?>/login_post',
                cache: false,
                processData: false,
                contentType: false,
                data: new FormData($("#login_form")[0]),
                success: function (msg) {
                    msg1 = JSON.parse(msg);
                    console.log(msg1);
                    $('.success').addClass('su').html(msg1.message);
                    $('.success-msg1').html(msg1.message);
                    $(".loading-cntant").css("display", "none");

                    if (msg1.message == "Login Successfully") {
<?php if (Request::is('payment')) { ?>
                            window.location.assign("<?php echo e(URL::to('/')); ?>")
<?php } else if (Request::is('success')) { ?>
                            window.location.assign("<?php echo e(URL::to('/')); ?>")
<?php } else if (Request::is('guest_checkout')) { ?>
                            window.location.assign("<?php echo e(URL::to('/')); ?>")
<?php } ?>

                        setTimeout(function () {// wait for 5 secs(2)
                            // window.location.assign("<?php echo e(URL::to('/')); ?>")
                            window.location.assign(url)
                        }, 2000);
                    }
                    //window.location.href = <?php echo e(URL::to('/')); ?>;					

                },
                error: function (data) {
                }
            });
            return false;

        }
    });


    $('#forgot_id').click(function () {

        var forgot_token = $('#forgot_token').val();

        $.ajaxSetup(
                {
                    headers:
                            {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            }
                });
        var user_name = $('#username').val();

        if (user_name == "") {
            $('.success-msg').html('Email Field Required.');
            return false;
        } else if (!validateEmail(user_name)) {
            $('.success-msg').html('Invalid Email Format');
            return false;
        } else {
            $(".loading-cntant").css("display", "block");
            $.ajax({
                type: "POST",
                url: '<?php echo e(URL::to("/")); ?>/forgotPassword',
                data: {username: user_name, forgot_token: forgot_token},
                success: function (msg) {
                    console.log(msg);
                    msg1 = JSON.parse(msg);
                    $('.success-msg').html(msg1.message);
                    $(".loading-cntant").css("display", "none");
                    $("#forgot")[0].reset();

                },
                error: function (data) {
                }
            });
        }
    });


    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {
            return false;
        } else {
            return true;
        }
    }



</script> 

<script>
    $(document).ready(function () {
        $("#show_forgot").click(function () {
            $("#forgot").show();
            $(".log_fm").hide();
            $('.success-msg').text('');
            $('.success-msg1').text('');

        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#hide_forgot").click(function () {
            $('.success-msg').text('');
            $('.success-msg1').text('');
            $(".log_fm").show();
            $("#forgot").hide();

        });

        $("#sign_m11").click(function () {
            $('.success-msg').text('');
            $('.success-msg1').text('');

        });
        $("#home1").click(function () {
            $('.success-msg').text('');
            $('.success-msg1').text('');

        });
    });
    
</script>
