

<ul class="nav nav-tabs">
<li class="<?if($title=='Account Information'){?>active<?}?>"><a href="<?php echo e(URL::to('account_information')); ?>">Account Information</a></li>
    <li class="<?if($title=='Account Address'){?>active<?}?>"><a href="<?php echo e(URL::to('address')); ?>">Address Book</a></li>
    <li class="<?if($title=='Change Password'){?>active<?}?>"><a  href="<?php echo e(URL::to('changePassword')); ?>">Change Password</a></li>
    <li class="<?if($title=='Order List'){?>active<?}?>"><a href="<?php echo e(URL::to('order_list')); ?>">Order Management</a></li>
    <li class="<?if($title=='Wishlist'){?>active<?}?>"><a href="<?php echo e(URL::to('user_wishlist')); ?>">Wish List</a></li>
  </ul>
  
  
