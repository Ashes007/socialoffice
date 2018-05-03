<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('backend/dist/img/user1-128x128.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->

      <ul class="sidebar-menu" data-widget="tree">
       
        <!-- <li class="{{ (Route::currentRouteName() == 'admin_dashboard')?'active':''  }}">
          <a href="{{ URL::Route('admin_dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>      
          </a>
         
        </li> -->
       <!--  <li class="treeview {{ isActiveRoute(['countries','states','cities','grouptypes']) }}">
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ isActiveRoute(['countries']) }}"><a href="{{ URL::Route('country_list') }}"><i class="fa fa-angle-right"></i> Country</a></li>
            <li class="{{ isActiveRoute(['states']) }}"><a href="{{ URL::Route('state_list') }}"><i class="fa fa-angle-right"></i> State</a></li>
            <li class="{{ isActiveRoute(['cities']) }}"><a href="{{ URL::Route('city_list') }}"><i class="fa fa-angle-right"></i> City</a></li> 
           
            
            <li class="{{ isActiveRoute(['grouptypes']) }}"><a href="{{ URL::Route('grouptype_list') }}"><i class="fa fa-angle-right"></i> Group Type</a></li>
                       
          </ul>
        </li> -->

        <li class="treeview {{ isActiveRoute(['companies','departments','users','roles']) }}">
          <a href="#">
            <i class="fa fa-user"></i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <li class="{{ isActiveRoute(['companies']) }}"><a href="{{ URL::Route('company_list') }}"><i class="fa fa-angle-right"></i> Company</a></li>
            <li class="{{ isActiveRoute(['departments']) }}"><a href="{{ URL::Route('department_list') }}"><i class="fa fa-angle-right"></i> Department</a></li>
            <li class="{{ isActiveRoute(['users']) }}"><a href="{{ URL::Route('user_list') }}"><i class="fa fa-angle-right"></i> <span>List</span></a></li>
            <li class="{{ isActiveRoute(['roles']) }}"><a href="{{ URL::Route('role_list') }}"><i class="fa fa-angle-right"></i> <span>Role</span></a></li>
                       
          </ul>
        </li>

        <li class="treeview {{ isActiveRoute(['eventtypes','events']) }}">
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Event</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <!-- <li class="{{ isActiveRoute(['eventtypes']) }}"><a href="{{ URL::Route('eventtype_list') }}"><i class="fa fa-angle-right"></i>  Type</a></li> -->
              <li class="{{ isActiveRoute(['events']) }}"> <a href="{{ URL::Route('event_list') }}"> <i class="fa fa-angle-right"></i> <span>List</span>      
          </a>         
        </li>
            
                       
          </ul>
        </li>

        

       <!-- <li class="{{ isActiveRoute(['tickets']) }}">
          <a href="{{ URL::Route('admin_ticket_list') }}">
            <i class="fa fa-ticket"></i> <span>Ticket</span>            
          </a>
        </li>-->
        <!-- <li class="{{ isActiveRoute(['cms']) }}">
          <a href="{{ URL::Route('cms_list') }}">
            <i class="fa fa-sticky-note"></i> <span>CMS</span>            
          </a>
        </li> -->

        <!--<li class="treeview {{ isActiveRoute(['faqs','helparticles','howtos']) }}">
          <a href="#">
            <i class="fa fa-cube"></i> <span>Knowledge Base</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ isActiveRoute(['faqs']) }}"><a href="{{ URL::Route('faq_list') }}"><i class="fa fa-angle-right"></i> FAQ</a></li>
            <li class="{{ isActiveRoute(['helparticles']) }}"><a href="{{ URL::Route('helparticle_list') }}"><i class="fa fa-angle-right"></i> Help Articles</a></li>
            <li class="{{ isActiveRoute(['howtos']) }}"><a href="{{ URL::Route('howto_list') }}"><i class="fa fa-angle-right"></i> <span>Howto</span></a></li>                       
          </ul>
        </li>-->
        <li class="treeview {{ isActiveRoute(['groups']) }}">
          <a href="#">
            <i class="fa fa-group"></i> <span>Group</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <!--<li class="{{ isActiveRoute(['eventtypes']) }}"><a href="{{ URL::Route('eventtype_list') }}"><i class="fa fa-angle-right"></i>  Type</a></li>-->
              <li class="{{ isActiveRoute(['groups']) }}"> <a href="{{ URL::Route('group_list') }}"> <i class="fa fa-angle-right"></i> <span>List</span>      
          </a>         
        </li>
            
                       
          </ul>
        </li>        

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
