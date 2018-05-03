<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(asset('backend/dist/img/user1-128x128.jpg')); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->

      <ul class="sidebar-menu" data-widget="tree">
       
        <!-- <li class="<?php echo e((Route::currentRouteName() == 'admin_dashboard')?'active':''); ?>">
          <a href="<?php echo e(URL::Route('admin_dashboard')); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>      
          </a>
         
        </li> -->
       <!--  <li class="treeview <?php echo e(isActiveRoute(['countries','states','cities','grouptypes'])); ?>">
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(isActiveRoute(['countries'])); ?>"><a href="<?php echo e(URL::Route('country_list')); ?>"><i class="fa fa-angle-right"></i> Country</a></li>
            <li class="<?php echo e(isActiveRoute(['states'])); ?>"><a href="<?php echo e(URL::Route('state_list')); ?>"><i class="fa fa-angle-right"></i> State</a></li>
            <li class="<?php echo e(isActiveRoute(['cities'])); ?>"><a href="<?php echo e(URL::Route('city_list')); ?>"><i class="fa fa-angle-right"></i> City</a></li> 
           
            
            <li class="<?php echo e(isActiveRoute(['grouptypes'])); ?>"><a href="<?php echo e(URL::Route('grouptype_list')); ?>"><i class="fa fa-angle-right"></i> Group Type</a></li>
                       
          </ul>
        </li> -->

        <li class="treeview <?php echo e(isActiveRoute(['companies','departments','users','roles'])); ?>">
          <a href="#">
            <i class="fa fa-user"></i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <li class="<?php echo e(isActiveRoute(['companies'])); ?>"><a href="<?php echo e(URL::Route('company_list')); ?>"><i class="fa fa-angle-right"></i> Company</a></li>
            <li class="<?php echo e(isActiveRoute(['departments'])); ?>"><a href="<?php echo e(URL::Route('department_list')); ?>"><i class="fa fa-angle-right"></i> Department</a></li>
            <li class="<?php echo e(isActiveRoute(['users'])); ?>"><a href="<?php echo e(URL::Route('user_list')); ?>"><i class="fa fa-angle-right"></i> <span>List</span></a></li>
            <li class="<?php echo e(isActiveRoute(['roles'])); ?>"><a href="<?php echo e(URL::Route('role_list')); ?>"><i class="fa fa-angle-right"></i> <span>Role</span></a></li>
                       
          </ul>
        </li>

        <li class="treeview <?php echo e(isActiveRoute(['eventtypes','events'])); ?>">
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Event</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <!-- <li class="<?php echo e(isActiveRoute(['eventtypes'])); ?>"><a href="<?php echo e(URL::Route('eventtype_list')); ?>"><i class="fa fa-angle-right"></i>  Type</a></li> -->
              <li class="<?php echo e(isActiveRoute(['events'])); ?>"> <a href="<?php echo e(URL::Route('event_list')); ?>"> <i class="fa fa-angle-right"></i> <span>List</span>      
          </a>         
        </li>
            
                       
          </ul>
        </li>

        

       <!-- <li class="<?php echo e(isActiveRoute(['tickets'])); ?>">
          <a href="<?php echo e(URL::Route('admin_ticket_list')); ?>">
            <i class="fa fa-ticket"></i> <span>Ticket</span>            
          </a>
        </li>-->
        <!-- <li class="<?php echo e(isActiveRoute(['cms'])); ?>">
          <a href="<?php echo e(URL::Route('cms_list')); ?>">
            <i class="fa fa-sticky-note"></i> <span>CMS</span>            
          </a>
        </li> -->

        <!--<li class="treeview <?php echo e(isActiveRoute(['faqs','helparticles','howtos'])); ?>">
          <a href="#">
            <i class="fa fa-cube"></i> <span>Knowledge Base</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(isActiveRoute(['faqs'])); ?>"><a href="<?php echo e(URL::Route('faq_list')); ?>"><i class="fa fa-angle-right"></i> FAQ</a></li>
            <li class="<?php echo e(isActiveRoute(['helparticles'])); ?>"><a href="<?php echo e(URL::Route('helparticle_list')); ?>"><i class="fa fa-angle-right"></i> Help Articles</a></li>
            <li class="<?php echo e(isActiveRoute(['howtos'])); ?>"><a href="<?php echo e(URL::Route('howto_list')); ?>"><i class="fa fa-angle-right"></i> <span>Howto</span></a></li>                       
          </ul>
        </li>-->
        <li class="treeview <?php echo e(isActiveRoute(['groups'])); ?>">
          <a href="#">
            <i class="fa fa-group"></i> <span>Group</span>
            <span class="pull-right-container">
              <i class="fa fa-caret-down pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <!--<li class="<?php echo e(isActiveRoute(['eventtypes'])); ?>"><a href="<?php echo e(URL::Route('eventtype_list')); ?>"><i class="fa fa-angle-right"></i>  Type</a></li>-->
              <li class="<?php echo e(isActiveRoute(['groups'])); ?>"> <a href="<?php echo e(URL::Route('group_list')); ?>"> <i class="fa fa-angle-right"></i> <span>List</span>      
          </a>         
        </li>
            
                       
          </ul>
        </li>        

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
