<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      @foreach ($admin_menus as $admin_menu)
        @if(empty($admin_menu['child_list']))
          <li class="active treeview">
            <a href="{{ ($admin_menu['route']!='')?route($admin_menu['route']):'#' }}">
              <i class="fa {{ $admin_menu['icon'] }}"></i> <span>{{ $admin_menu['name'] }}</span>
            </a>
          </li>
        @else
          <li class="treeview <?php if($breadcrumb['active'] == $admin_menu['child_list']['0']['route']){?> active <?php }?>">
            <a href="#">
              <i class="fa {{ $admin_menu['icon'] }}"></i>
              <span>{{ $admin_menu['name'] }}</span>
              <i class="fa fa-angle-left pull-right"></i><?php //pr($admin_menu);?>
              <ul class="treeview-menu" <?php if($breadcrumb['active'] == $admin_menu['child_list']['0']['route']){?> style="display: block;" <?php }?>>
                @foreach ($admin_menu['child_list'] as $child_list)
                  <li>
                    <a href="{{ ($child_list['route']!='')?route($child_list['route']):'#' }}">
                      <i class="fa {{ $child_list['icon'] }}"></i>{{ $child_list['name'] }} 
                    </a>
                  </li>
                @endforeach
              </ul>
            </a>
          </li>
        @endif
      @endforeach 
    </ul>
  </section>
</aside>
