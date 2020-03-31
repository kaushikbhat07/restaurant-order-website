<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index?view_orders">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-laugh-wink"></i>
				</div>
				<div class="sidebar-brand-text mx-3">Swadesh</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<!--       <li class="nav-item active">
				<a class="nav-link" href="index?view_orders">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Orders</span></a>
			</li> -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseFour" aria-expanded="true" aria-controls="collpaseFour">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Orders</span>
				</a>
				<div id="collpaseFour" class="collapse <?php echo ORD_DROPDOWN_SHOW ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Orders:</h6>
						<a class="collapse-item <?php echo NEW_ORD ?>" href="index?view_orders&new=1">New Orders</a>
						<a class="collapse-item <?php echo DEL_ORD ?>" href="index?view_orders&delivered=1">Delivered Orders</a>
					</div>
				</div>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				Content
			</div>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<i class="fas fa-fw fa-beer"></i>
					<span>Categories</span>
				</a>
				<div id="collapseOne" class="collapse <?php echo CAT_DROPDOWN_SHOW ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Modify Categories:</h6>
						<a class="collapse-item <?php echo VIEW_CAT ?>" href="index?cat&view_cat">View</a>
						<a class="collapse-item <?php echo ADD_CAT ?>" href="index?cat&add_cat">Add</a>
						<a class="collapse-item <?php echo MODIFY_CAT ?>" href="index?cat&modify_cat">Modify</a>
					</div>
				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					<i class="fas fa-fw fa-pizza-slice"></i>
					<span>Items</span>
				</a>
				<div id="collapseTwo" class="collapse <?php echo PROD_DROPDOWN_SHOW; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Add/Modify Items:</h6>
						<a class="collapse-item <?php echo VIEW_PROD; ?>" href="index?prod&view_prod">View/Modify</a>
						<a class="collapse-item <?php echo ADD_PROD; ?>" href="index?prod&add_prod=1">Add</a>
					</div>
				</div>
			</li>

			<!-- Nav Item - Utilities Collapse Menu -->
			<!--       <li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
					<i class="fas fa-fw fa-wrench"></i>
					<span>Utilities</span>
				</a>
				<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Custom Utilities:</h6>
						<a class="collapse-item" href="utilities-color.html">Colors</a>
						<a class="collapse-item" href="utilities-border.html">Borders</a>
						<a class="collapse-item" href="utilities-animation.html">Animations</a>
						<a class="collapse-item" href="utilities-other.html">Other</a>
					</div>
				</div>
			</li> -->

			<!--       Divider
			<hr class="sidebar-divider">

			Heading
			<div class="sidebar-heading">
				Interface
			</div>

			Nav Item - Pages Collapse Menu
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					<i class="fas fa-fw fa-cog"></i>
					<span>Components</span>
				</a>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Custom Components:</h6>
						<a class="collapse-item" href="buttons.html">Buttons</a>
						<a class="collapse-item" href="cards.html">Cards</a>
					</div>
				</div>
			</li>

			Nav Item - Utilities Collapse Menu
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
					<i class="fas fa-fw fa-wrench"></i>
					<span>Utilities</span>
				</a>
				<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Custom Utilities:</h6>
						<a class="collapse-item" href="utilities-color.html">Colors</a>
						<a class="collapse-item" href="utilities-border.html">Borders</a>
						<a class="collapse-item" href="utilities-animation.html">Animations</a>
						<a class="collapse-item" href="utilities-other.html">Other</a>
					</div>
				</div>
			</li> -->

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				Logins
			</div>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseLogin" aria-expanded="true" aria-controls="collpaseLogin">
					<i class="fas fa-globe"></i>
					<span>View / Modify Logins</span>
				</a>
				<div id="collpaseLogin" class="collapse <?php echo LOGIN_DROPDOWN_SHOW ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Modify Logins:</h6>
						<a class="collapse-item <?php echo CUST_LOGIN ?>" href="index?logins&cust">Customer</a>
						<a class="collapse-item <?php echo ADMIN_LOGIN ?>" href="index?logins&admin">Admin</a>
						<a class="collapse-item <?php echo STAFF_LOGIN ?>" href="index?logins&staff">Staff</a>
					</div>
				</div>
			</li>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseAddLogin" aria-expanded="true" aria-controls="collpaseAddLogin">
					<i class="fas fa-user-plus"></i>
					<span>Add Logins</span>
				</a>
				<div id="collpaseAddLogin" class="collapse <?php echo ADD_LOGIN_DROPDOWN_SHOW ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Add New Logins:</h6>
						<a class="collapse-item <?php echo ADD_ADMIN_LOGIN ?>" href="index?add_logins&admin">Admin</a>
						<a class="collapse-item <?php echo ADD_STAFF_LOGIN ?>" href="index?add_logins&staff">Staff</a>
					</div>
				</div>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				Delivery Zipcodes
			</div>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseZipCode" aria-expanded="true" aria-controls="collapseZipCode">
					<i class="fas fa-truck"></i>
					<span>Zip Codes</span>
				</a>
				<div id="collapseZipCode" class="collapse <?php echo ZIP_DROPDOWN_SHOW ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Modify Zip Codes:</h6>
						<a class="collapse-item <?php echo VIEW_ZIP ?>" href="index?zip&modify">View/Remove/Modify</a>
						<a class="collapse-item <?php echo ADD_ZIP ?>" href="index?zip&add">Add New</a>
					</div>
				</div>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<!--       <div class="sidebar-heading">
				Addons
			</div> -->

			<!-- Nav Item - Pages Collapse Menu -->
			<!--       <li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
					<i class="fas fa-fw fa-folder"></i>
					<span>Pages</span>
				</a>
				<div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Login Screens:</h6>
						<a class="collapse-item" href="login.html">Login</a>
						<a class="collapse-item" href="register.html">Register</a>
						<a class="collapse-item" href="forgot-password.html">Forgot Password</a>
						<div class="collapse-divider"></div>
						<h6 class="collapse-header">Other Pages:</h6>
						<a class="collapse-item" href="404.html">404 Page</a>
						<a class="collapse-item" href="blank.html">Blank Page</a>
					</div>
				</div>
			</li>  -->

			<!-- Nav Item - Charts -->
			<!--       <li class="nav-item">
				<a class="nav-link" href="charts.html">
					<i class="fas fa-fw fa-chart-area"></i>
					<span>Charts</span></a>
			</li> -->

			<!-- Nav Item - Tables -->
			<!--       <li class="nav-item">
				<a class="nav-link" href="tables.html">
					<i class="fas fa-fw fa-table"></i>
					<span>Tables</span></a>
			</li> -->

			<!-- Divider -->
			<!-- <hr class="sidebar-divider d-none d-md-block"> -->

			<!-- Sidebar Toggler (Sidebar) -->
			<!--       <div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div> -->

		</ul>
		<!-- End of Sidebar -->