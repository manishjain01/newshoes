<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <?php foreach($admin_menus as $admin_menu): ?>
        <?php if(empty($admin_menu['child_list'])): ?>
          <li class="active treeview">
            <a href="<?php echo e(($admin_menu['route']!='')?route($admin_menu['route']):'#'); ?>">
              <i class="fa <?php echo e($admin_menu['icon']); ?>"></i> <span><?php echo e($admin_menu['name']); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li class="treeview <?php if($breadcrumb['active'] == $admin_menu['child_list']['0']['route']){?> active <?php }?>">
            <a href="#">
              <i class="fa <?php echo e($admin_menu['icon']); ?>"></i>
              <span><?php echo e($admin_menu['name']); ?></span>
              <i class="fa fa-angle-left pull-right"></i><?php //pr($admin_menu);?>
              <ul class="treeview-menu" <?php if($breadcrumb['active'] == $admin_menu['child_list']['0']['route']){?> style="display: block;" <?php }?>>
                <?php foreach($admin_menu['child_list'] as $child_list): ?>
                  <li>
                    <a href="<?php echo e(($child_list['route']!='')?route($child_list['route']):'#'); ?>">
                      <i class="fa <?php echo e($child_list['icon']); ?>"></i><?php echo e($child_list['name']); ?> 
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?> 
    </ul>
  </section>
</aside>
