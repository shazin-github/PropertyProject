<style type="text/css">
/*   .skin-black .main-sidebar, .skin-black .left-side, .skin-black .wrapper{
      background: rgb(8, 22, 49);
   }

   .skin-black .sidebar>.sidebar-menu>li>a:hover, .skin-black .sidebar>.sidebar-menu>li.active>a {
      color: #FFF;
      background: rgb(0, 150, 136);
      border-left-color: #009688;
   }

   .skin-black .sidebar>.sidebar-menu>li>.treeview-menu {
      background: rgba(0, 188, 212, 0.28);
   }

   .skin-black .sidebar>.sidebar-menu>li.header {
      background: rgb(8, 16, 31);
      color: #FF5722;
      font-size: 16px;
      font-weight: bold;
   }*/
</style>
		<header class="main-header">
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
		</header>

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
         <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- <div class="user-panel">
               <div class="pull-left image"><img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" id="user-pic"/></div>
               <div class="pull-left info"><p style="text-transform: uppercase;">{{ Session::get('username') }}</p><a href="#"><i class="fa fa-circle text-success"></i> Online</a></div>
            </div> -->
            
            <!-- search form -->
            <!-- <form action="#" method="get" class="sidebar-form">
               <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search..."/>
                  <span class="input-group-btn">
                     <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
               </div>
            </form> -->
            <!-- /.search form -->

          <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" >
               <li><a href="adminpanel/home" class="nav home"><i class="fa fa-circle-o text-danger"></i><span>Home</span></li></a>
               <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-default"></i> <span>Events</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                     <li><a href="#" class="nav" data-link="adminpanel/not-mapped-events"><i class="fa fa-circle-o"></i> Approve Events</a></li>
                  </ul>
               </li>

               
               <li class="treeview">
                  <a href="#"><i class="fa fa-user text-default"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                     <li><a href="#" class="nav" data-link="adminpanel/users-stats"><i class="fa fa-circle-o"></i> Users Stats</a></li>
                     <li><a href="#" class="nav" data-link="adminpanel/users-details"><i class="fa fa-circle-o"></i> Users Details</a></li>
                     <li><a href="#" class="nav" data-link="adminpanel/add-pos-user"><i class="fa fa-circle-o"></i> Add POS User</a></li>
                     <li><a href="#" class="nav" data-link="adminpanel/add-user-seller-id"><i class="fa fa-circle-o"></i> Add Seller ID</a></li>
                  </ul>
               </li>               
               
              <li class="header">Others</li>
              <li><a href="adminpanel/signout" class="nav signout"><i class="fa fa-circle-o text-danger"></i><span>Signout</span></li></a>
            </ul>
         </section>
         <!-- /.sidebar -->
        </aside>