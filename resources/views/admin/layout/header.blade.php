   <!-- Logo -->
    <a href="{{ route('admin_dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ asset('backend/dist/img/logo-small.png')}}" alt=""/></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ asset('backend/dist/img/logo.png') }}" alt=""/></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

<nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class=""><!--{{ \Auth::guard('admin')->user()->first_name }}--> <i class="fa fa-user-circle" aria-hidden="true"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              
              
              <li class="user-footer">
                  <a href="{{ URL::Route('admin_change_password') }}" class="btn"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
                  <a href="{{ URL::Route('sitesetting_list') }}" class="btn"><i class="fa fa-cogs" aria-hidden="true"></i> Site Settings</a>
                  <a href="{{ URL::Route('logout') }}" class="btn"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign out</a>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>