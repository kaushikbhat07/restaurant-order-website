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
						<h6 class="collapse-header">View Categories:</h6>
						<a class="collapse-item <?php echo VIEW_CAT ?>" href="index?cat&view_cat">View</a>
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
						<h6 class="collapse-header">View Items:</h6>
						<a class="collapse-item <?php echo VIEW_PROD; ?>" href="index?prod&view_prod">View</a>
					</div>
				</div>
			</li>			

		</ul>
		<!-- End of Sidebar -->