 <div class="loading-cntant" >
		<div class="loader"></div>
	</div>
<header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin.dashboard.index')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{config('settings.CONFIG_SITE_TITLE')}}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{config('settings.CONFIG_SITE_TITLE')}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
           <?php $admin = adminUser();

            
             ?>
          <li class="">
           {!! HTML::link(route('admin.profile'), ucfirst($admin->first_name.' '.$admin->last_name), array('class' => '')) !!}
          </li>
            <li class="">
           {!! HTML::link(route('admin.logout'), 'Sign out', array('class' => '')) !!}
          </li>
          <li class="dropdown user user-menu">
           {!! HTML::link(WEBSITE_URL, 'Preview', array('class' => '','target'=>'_blank')) !!}
          </li>
         
        </ul>
      </div>
    </nav>
  </header>