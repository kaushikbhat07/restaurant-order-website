<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Orders</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">ORDER DETAILS</h5>
            <div class="form-input-info text-center">
                View payment and delivery details below.
            </div>
        </div>
        <div class="border-top-primary border-table-top"></div>

        <?php $admin->view_items_payment_details(); ?>

          <div class="table-responsive">
          	<h5 class="text-gray-800 text-center text-uppercase mb-4">Payment Information</h5>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr data-toggle="tooltip" data-placement="top" data-original-title="Click on the column names to sort accordingly.">
                    <th>Transaction ID</th>
                    <th>Txn status</th>
                    <th>Bank Txn ID</th>
                    <th>Bank Name</th>
                    <th>Checksumhash</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>Transaction ID</th>
                    <th>Txn status</th>
                    <th>Bank Txn ID</th>
                    <th>Bank Name</th>
                    <th>Checksumhash</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $admin->view_payment_details(); ?>
              </tbody>
            </table>
          </div>
          <br><br>

          <h5 class="text-gray-800 text-center text-uppercase mb-4">Delivery Information</h5>

		<?php $admin->display_delivery_info(); ?>     
          <div class="border-bottom-primary border-table-bottom"></div>             
    </div>
</div>