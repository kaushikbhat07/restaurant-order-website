<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Categories</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Goto Dashboard</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800">ADD NEW CATEGORY</h5>
        <form class="needs-validation" method="POST" action="" novalidate>
            <div class="row">
            <div class="col-md-4 mb-3">
                <div class="insert-content">
                    <label>Select an image for the category</label><br>
                    <?php $admin->display_category_icons(); ?>
                </div>

<!--                 <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_category" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
                </button>  --> 
            </div>      <!-- col-md-4 first -->

            <div class="col-md-3"></div>   <!--  for space -->

            <div class="col-md-4 mb-3">

                <div class="form-row insert-content">
                    
                     <?php $admin->add_category(); ?>
                        <label for="validationCustom01">Category Title</label>
                        <input type="text" <?php echo DISABLED; ?> class="form-control" id="validationCustom01" placeholder="Fries" name="cat_title" pattern="([A-Za-z ]){4,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="4 characters minimum" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format.
                        </div>
                        <div class="form-input-info">
                            Please enter atleast 4 characters.
                        </div>
                </div>
                <div class="form-row insert-content">
                    <label for="exampleFormControlTextarea1">Category Description</label>
                    <textarea <?php echo DISABLED; ?> class="form-control" name="cat_desc" id="exampleFormControlTextarea1" rows="2"></textarea>
                </div>
                <button <?php echo DISABLED; ?> href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_category" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
                </button>  
            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->
        </form>

        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </div>
</div>



<!-- SUB CATEGORIES -->
<div id="subcat" class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Sub Categories</h1>
<!-- <a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Goto Dashboard</a> -->
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800">ADD NEW SUB-CATEGORY</h5>
        <form class="needs-validation" method="POST" action="index?cat&add_cat#subcat" novalidate>
            <div class="row">
            <div class="col-md-4 mb-3">
                <div class="insert-content">
                    <label>Select the category</label><br>
                    <select type="select" name="dropdown_cat" id="exampleCustomSelect" name="customSelect" class="custom-select" required>
                        <option value="">Select</option>
                        <?php $admin->display_cat_dropdown(); ?>
                    </select>
                </div>

<!--                 <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_category" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
                </button>   -->
            </div>      <!-- col-md-4 first -->

            <div class="col-md-3"></div>   <!--  for space -->

            <div class="col-md-4 mb-3">
                <div class="form-row insert-content">
                     <?php $admin->add_subcat(); ?>
                        <label for="validationCustom01">Sub-Category Title</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Fries" name="subcat_title" pattern="([A-Za-z ]){3,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="3 characters minimum" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please follow the requested format.
                        </div>
                        <div class="form-input-info">
                            Please enter atleast 3 characters.
                        </div>
                </div>
                <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_subcat" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
                </button>  
            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->
        </form>

        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </div>
</div>