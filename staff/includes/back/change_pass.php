<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Account Settings</h1>
    <a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow">
    <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">Change Password</h5>
            <div class="form-input-info text-center">
                Enter the current password and your desired password below to update your account password.
            </div>
        </div>
        <div class="border-top-primary border-table-top"></div>
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="index?changePassword" novalidate="">
            <?php
            $staff->changePassword();
            ?>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="insert-content">
                        <div class="form-row insert-content">
                            <label for="validationCustom01">Current Password</label>
                            <input type="password" class="form-control" name="current_pass" id="validationCustom01" pattern=".{6,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter your current password." required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                        </div>
                        <div class="form-row insert-content">
                            <label for="validationCustom02">New Password</label>
                            <input type="password" class="form-control" name="new_pass" id="validationCustom02" required="" pattern=".{6,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 6 characters. Can include alphabets, numbers & special characters.">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                        </div>
                        <div class="form-row insert-content">
                            <label for="validationCustom03">Re-enter Password</label>
                            <input type="password" class="form-control" name="new_pass_repeat" id="validationCustom03" required="" pattern=".{6,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 6 characters. Can include alphabets, numbers & special characters.">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                        </div>
                    </div>

                </div> <!-- col-md-12 first -->
            </div> <!-- row -->
            <div class="insert-content text-center">
                <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="change_pass" type="submit">
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
        <div class="border-bottom-primary border-table-bottom"></div>
    </div>
</div>