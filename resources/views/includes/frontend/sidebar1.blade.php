  <div class="col-md-3 chnages_list">
                  <h2>My Dashboard</h2>
                  <ul>
					 <li class="<?if($title=='My dashboard'){?>active<?}?>">
                        <a href="{{URL::to('myaccount')}}">My Dashboard</a>
                     </li>
					  
                     <li class="<?if($title=='Account Information'){?>active<?}?>">
                        <a href="{{URL::to('account_information')}}">Account Information</a>
                     </li>
                     <li class="<?if($title=='Account Address'){?>active<?}?>">
                        <a href="{{URL::to('address')}}">Address Book</a>
                     </li>
                     <li class="<?if($title=='Change Password'){?>active<?}?>">
                        <a href="{{URL::to('changePassword')}}">Change Password</a>
                     </li>
                     <li id="flip_mngg" class="<?if($title=='Order List'){?>active<?}?>">
                            Order Management <i class="fa fa-caret-down" aria-hidden="true"></i>
                     </li>
					  
                     <div id="panel_mngg" style="display: none;">
                         <ul>
                             <li><a href="{{URL::to('order_list')}}">Your Order</a></li>
<!--                             <li><a href="#">Return Order</a></li>-->
                         </ul>
                     </div>
                     <script> 
						 $(document).ready(function(){
						   $("#flip_mngg").click(function(){
							 $("#panel_mngg").slideToggle("slow");
						   });
						 });
					  </script>
                     <li class="<?if($title=='Wishlist'){?>active<?}?>">
                        <a href="{{URL::to('user_wishlist')}}">Wishlist</a>
                     </li>
                  </ul>
               </div>