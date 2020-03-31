<?php 

if(isset($_GET['prod']) && isset($_GET['add_prod']) && $_GET['add_prod'] == 1)
{
    ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Items</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center text-uppercase">Add Item</h5>
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="index?<?php echo $_SERVER['QUERY_STRING']; ?>" novalidate>
        <?php $admin->add_item(); ?>            
            <div class="row">
            <div class="col-md-5 mb-3">
                <div class="insert-content">
                
                    <div class="form-row insert-content">
                            <label for="validationCustom01">Item ID (optional)</label>
                            <input type="text" class="form-control" name="item_id" id="validationCustom01" placeholder="123" pattern="([0-9]){1,10}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 1 digit, Max 10 digits." title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                    </div>
                    <div class="form-row insert-content">
                            <label for="validationCustom02">Item Title</label>
                            <input type="text" class="form-control" name="item_title" id="validationCustom02" placeholder="Munchies" required="" pattern="([()A-Za-z ]){4,50}" data-toggle="tooltip" data-placement="top" title="" data-original-title="4 characters minimum" title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                            <div class="form-input-info">
                                Please enter atleast 4 characters.
                            </div>
                    </div>
                </div>

            </div>      <!-- col-md-4 first -->

            <div class="col-md-2"></div>   <!--  for space -->

            <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                            <label for="validationCustom03">Item Price&nbsp;(&#8377;)</label>
                            <input type="text" class="form-control" name="item_price" id="validationCustom03" placeholder="199" required="" pattern="([0-9]){2,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 digits, Max 6 digits" title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                    </div>
                    <div class="form-row insert-content">
                            <label for="validationCustom04">Category</label>
                            <select type="select" name="cat_title" id="exampleCustomSelect" class="custom-select" required="">
                                <option value="">Select</option>
                                <?php $admin->display_cat_dropdown(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select an option
                            </div>
                    </div>
                
                </div>

            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->
                <div class="insert-content text-center">
                    <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="add_prod_next" type="submit">
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

    <?php
}

//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS//DO NOT TOUCH THIS

else if(isset($_GET['prod']) && isset($_GET['add_prod']) && $_GET['add_prod'] == 2 && $_SESSION['header'] == $_SERVER['QUERY_STRING'])  
{
    ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Items</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center">Add Item - Final step</h5>
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="index?<?php echo $_SERVER['QUERY_STRING']; ?>" novalidate>
        <?php $admin->add_item(); ?>            
            <div class="row">
            <div class="col-md-5 mb-3">
                <!-- <div class="insert-content"> -->
                    <div class="form-row insert-content">
                            <label for="validationCustom04">Sub-Category Title</label>
                            <select type="select" name="sub_cat_title" id="exampleCustomSelect" class="custom-select" required="">
                                <option value="">Select</option>
                                <?php $admin->dispay_subcat_dropdown(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select an option
                            </div>
                    </div>
                <!-- </div> -->

            </div>      <!-- col-md-4 first -->

            <div class="col-md-2"></div>   <!--  for space -->

            <div class="col-md-5 mb-3">
                <!-- <div class="insert-content"> -->
                    <div class="form-row insert-content">
                            <label for="validatedCustomFile">Item image&nbsp;(optional)</label>
                            <!-- <div class="custom-file"> -->
                              <input type="file" id="validatedCustomFile" class="form-control" name="prod_image">
                              <!-- <label  for="validatedCustomFile"></label> -->
                            <!-- </div> -->
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select an option
                            </div>
                            <div class="form-input-info">
                                A default image will be replaced if no image is selected.
                            </div>
                    </div>
                
                <!-- </div> -->

            </div>  <!-- col-md-4 second -->

            <div class="custom-control custom-checkbox insert-content text-center-force" data-toggle="tooltip"  data-placement="top" title="" data-original-title="Uncheck this box if you DO&nbsp;NOT&nbsp;want the item to show up on the website. This setting can be changed later. ">
              <input type="checkbox" class="custom-control-input" id="customCheck1" name="available_check" checked="">
              <label class="custom-control-label" for="customCheck1">Mark this item as <strong>Available</strong></label>
            </div>

            </div>  <!-- row -->
                <div class="insert-content text-center">
                    <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="add_prod_publish" type="submit">
                        <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Publish</span>
                    </button> 
                    <button href="#" class="btn btn-danger btn-icon-split delete-btn btn-padding" type="reset">
                        <span class="icon text-white-50">
                        <i class="fas fa-times"></i>
                        </span>
                        <span class="text">Clear</span>
                    </button> 
                </div>
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


    <?php
}
else if(isset($_GET['prod']) && isset($_GET['add_prod']) && $_GET['add_prod'] == 3 && isset($_GET['lid']) && $_SESSION['header'] == $_SERVER['QUERY_STRING'])
{
    // if(isset($_SESSION['header'])) unset($_SESSION['header']);
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Items</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center">Item Added!</h5>
        <!-- <form class="needs-validation" method="POST" action="index?prod&add_prod=3" novalidate> -->
        <?php $admin->add_item(); 
        if(isset($_SESSION['header'])) unset($_SESSION['header']);
        ?>            

        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <div class="insert-content">
                <h5>Here are the details:</h5>
            </div>
            <div class="row">
                <?php $admin->display_last_item_added(); ?>
            </div>
          </div>
        </div> 
            <div class="insert-content">

<!--             <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                            <label for="validationCustom04">Sub-Category Title</label>
                            <select type="select" name="sub_cat_title" id="exampleCustomSelect" class="custom-select" required="">
                                <option value="">Select</option>
                                <?php //$admin->dispay_subcat_dropdown(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select an option
                            </div>
                    </div>
                </div>

            </div> -->      <!-- col-md-4 first -->

            <!-- <div class="col-md-2"></div>  -->

<!--             <div class="col-md-5 mb-3">
                <div class="insert-content">
                    <div class="form-row insert-content">
                            <label for="validatedCustomFile">Item image&nbsp;(optional)</label>
                              <input type="file" id="validatedCustomFile" class="form-control" accept=".png .jpg .jpeg">

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select an option
                            </div>
                            <div class="form-input-info">
                                A default image will be replaced if no image is selected.
                            </div>
                    </div>
                
                </div>

            </div> --> 
            </div>  <!-- row -->
                <div class="insert-content text-center">
                    <a href="index?prod&add_prod=1" class="btn btn-primary btn-icon-split blue-btn btn-padding">
                        <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Add more items</span>
                    </a> 
                    <a href="index?prod&modify_prod=1&id=<?php echo $_GET['lid']; ?>" class="btn btn-danger btn-icon-split delete-btn btn-padding">
                        <span class="icon text-white-50">
                        <i class="fas fa-fw fa-wrench"></i>
                        </span>
                        <span class="text">Modify</span>
                    </a>                     
                    <a href="index" class="btn btn-success btn-icon-split success-btn btn-padding">
                        <span class="icon text-white-50">
                        <i class="fas fa-home"></i>
                        </span>
                        <span class="text">Go home</span>
                    </a>
                </div>
                <!-- </form> -->
        
             <!-- Example starter JavaScript for disabling form submissions if there are invalid fields -->
<!--         <script>
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
        </script> -->
    </div>
</div>

<?php
}
else
{
    if(isset($_SESSION['header'])) unset($_SESSION['header']);
    redirect("index");
}
// if(isset($_SESSION['header'])) unset($_SESSION['header']);
?>