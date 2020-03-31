<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Add Logins</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<?php 
if(isset($_GET['add_logins']) && isset($_GET['admin'])) {
?>

<div class="main-card mb-4 card shadow">
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">
                Add New Admin
            </h5>
            <div class="form-input-info text-center">
               Fill up the details in the form below to add a new admin, who can manage the website, lookup new orders, add items & categories and much more.
            </div>              
        </div> 
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="" novalidate>
            <?php $admin->insert_admin(); ?>
            <div class="row">
            <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" name="fname" id="validationCustom01" placeholder="John" pattern="([A-z]){2,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 characters & No whitespaces. " title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>
                    <div class="form-row insert-content">
                            <label for="validationCustom02">New admin's Email ID</label>
                            <input type="email" class="form-control" name="email" id="validationCustom02" placeholder="johndoe@web.com" pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" required="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Email" title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                            <div class="form-input-info">
                                <!-- Please enter atleast 4 characters. -->
                            </div>
                    </div>
                </div>

            </div>      <!-- col-md-4 first -->

            <div class="col-md-2"></div>   <!--  for space -->

            <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="validationCustom01" placeholder="Doe" pattern="([A-z]){2,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 characters & No whitespaces." title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>
                    <div class="form-row insert-content">
                        <label for="validationCustom01">Password</label>
                        <input type="password" class="form-control" name="password" id="validationCustom01" pattern="^.{6,}$" data-toggle="tooltip" data-placement="top" title="" data-original-title="Minimum 6 characters. " title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>                   
                </div>
            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->
            <div class="insert-content text-center">
                <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="add_admin" type="submit">
                    <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Next</span>
                </button> 
                <button href="#" class="btn btn-danger btn-icon-split delete-btn btn-padding" type="reset">
                    <span class="icon text-white-50">
                    <i class="fas fa-times"></i>
                    </span>
                    <span class="text">Clear</span>
                </button> 
            </div>
        </form>
    </div>
</div>

<?php
} else if(isset($_GET['add_logins']) && isset($_GET['staff'])) {
?>

<div class="main-card mb-4 card shadow">
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">
                Add New Staff
            </h5>
            <div class="form-input-info text-center">
               Fill up the details in the form below to add a new staff, who can view the orders received and the order details.
            </div>              
        </div> 
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="" novalidate>
            <?php $admin->insert_staff(); ?>
            <div class="row">
            <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" name="fname" id="validationCustom01" placeholder="John" pattern="([A-z]){2,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 characters & No whitespaces. " title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>
                    <div class="form-row insert-content">
                            <label for="validationCustom02">New staff's Email ID</label>
                            <input type="email" class="form-control" name="email" id="validationCustom02" placeholder="johndoe@web.com" pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" required="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Email" title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                            <div class="form-input-info">
                                <!-- Please enter atleast 4 characters. -->
                            </div>
                    </div>
                </div>

            </div>      <!-- col-md-4 first -->

            <div class="col-md-2"></div>   <!--  for space -->

            <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="validationCustom01" placeholder="Doe" pattern="([A-z]){2,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 characters & No whitespaces. " title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>
                    <div class="form-row insert-content">
                        <label for="validationCustom01">Password</label>
                        <input type="password" class="form-control" name="password" id="validationCustom01" pattern="^.{6,}$" data-toggle="tooltip" data-placement="top" title="" data-original-title="Minimum 6 characters. " title="" required="">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format!
                        </div>
                    </div>                   
                </div>
            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->
            <div class="insert-content text-center">
                <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="add_staff" type="submit">
                    <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Next</span>
                </button> 
                <button href="#" class="btn btn-danger btn-icon-split delete-btn btn-padding" type="reset">
                    <span class="icon text-white-50">
                    <i class="fas fa-times"></i>
                    </span>
                    <span class="text">Clear</span>
                </button> 
            </div>
        </form>
    </div>
</div>

<?php
}
?>