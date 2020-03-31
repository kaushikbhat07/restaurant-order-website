<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Zip Codes</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<?php 
if(isset($_GET['add'])) {
?>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">
                Add New Zip Code
            </h5>
            <div class="form-input-info text-center">
               Enter a new Pin Code below to be able to deliver to that location. You can remove any Pin Codes <a href="index?zip&modify">here</a>.
            </div>              
        </div>      

        <div class="border-top-primary border-table-top"></div>
        
        <form class="needs-validation" novalidate="" method="POST">
            <?php $admin->add_zipcode(); ?>
            <!-- <div class="row"> -->
            <div class="form-row insert-content">
                <label for="validationCustom01">Enter Pin Code</label>
                <input type="text" pattern="([0-9]){6}" class="form-control" id="validationCustom01" placeholder="575001" name="pincode" data-toggle="tooltip" data-placement="top" data-original-title="Enter 6 digits" maxlength="6" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please follow the requested format.
                </div>
                <div class="form-input-info">
                    Please enter a 6 digit pin code.
                </div>
            </div>
            <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_zipcode" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
            </button>  
            <!-- </div> -->
        </form>


        <div class="border-bottom-primary border-table-bottom"></div>             
    </div>
</div>

<?php
} else if(isset($_GET['modify'])) {
?>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">
                Modify/Remove Zip Code
            </h5>
            <div class="form-input-info text-center">
               Decided to stop delivering to a location? Remove any pincode from the list below. Click <a href="index?zip&add">here</a> to add new pincodes.
            </div>              
        </div>      

        <div class="border-top-primary border-table-top"></div>
        
        <?php 
        $admin->remove_zip_code();
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr data-toggle="tooltip" data-placement="top" data-original-title="Click on the column names to sort accordingly.">
                    <th>Pincode</th>
                    <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>Pincode</th>
                    <th></th>
                </tr>
              </tfoot>
              <tbody>
                <?php $admin->display_zip_code(); ?>
              </tbody>
            </table>
        </div>

        <div class="border-bottom-primary border-table-bottom"></div>             
    </div>
</div>  

<?php
}
?>