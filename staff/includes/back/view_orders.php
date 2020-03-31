<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Orders</h1>
	<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow">
	<!-- here -->
	<div class="card-body form-add">
		<div class="card-title">
			<h5 class="text-gray-800 text-center text-uppercase"><?php echo isset($_GET['delivered']) ? "DELIVERED ORDERS" : "NEW ORDERS" ?></h5>
			<div class="form-input-info text-center">
				Click on the item to view delivery and payment details.
			</div>
		</div>
		<div class="border-top-primary border-table-top"></div>
		<?php
		//$admin->delete_product_view_page(); 
		//$admin->hide_product_view_page();
		?>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr data-toggle="tooltip" data-placement="top" data-original-title="Click on the column names to sort accordingly.">
						<th>Order #</th>
						<th>Item Title</th>
						<th>Price</th>
						<th>Order Date</th>
						<th>Payment Mode</th>
						<th>Order Status</th>
						<th>Change Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>#</th>
						<th>Item Title</th>
						<th>Price</th>
						<th>Order Date</th>
						<th>Payment Mode</th>
						<th>Order Status</th>
						<th>Change Status</th>
					</tr>
				</tfoot>
				<tbody>
					<?php $staff->view_orders(); ?>
				</tbody>
			</table>
		</div>
		<div class="border-bottom-primary border-table-bottom"></div>
	</div>
</div>