<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Items</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<?php 
if(isset($_GET['prod']) && isset($_GET['view_prod']))
{
    ?>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">ALL ITEMS</h5>
            <div class="form-input-info text-center">
                Items currently showing up on the website.
            </div>  
        </div>      
            <div class="border-top-primary border-table-top"></div>
            <?php 
            $staff->delete_product_view_page(); 
            $staff->hide_product_view_page();
            ?>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr data-toggle="tooltip" data-placement="top" data-original-title="Click on the column names to sort accordingly.">
                        <th>#</th>
                        <th>Item Title</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Date Added</th>
                        <th>Date Modified</th>
                        <th></th>
                        <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Item Title</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Date Added</th>
                        <th>Date Modified</th>
                        <th></th>
                        <th></th>                      
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php $staff->display_items(); ?>
                  </tbody>
                </table>
              </div>
              <div class="border-bottom-primary border-table-bottom"></div>
    </div>
</div>

    <?php
}

else if(isset($_GET['prod']) && isset($_GET['modify_prod']) && $_GET['modify_prod'] == 1 && isset($_GET['id']))
{
    $con->connect();
    $id = base64_decode($_GET['id']);
    $sql = "SELECT item_id, ROUND(item_price) AS item_price, item_title FROM items WHERE item_id = " . $id;
    $send_query = $con->query($sql);
    if(isset($send_query))
    {
        while($row = mysqli_fetch_array($send_query)):
?>


<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center text-uppercase">Modify Item</h5>
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="index?<?php echo $_SERVER['QUERY_STRING']; ?>" novalidate>
            <?php $staff->modify_item(); ?>
            <div class="row">
            <div class="col-md-5 mb-3">
                <div class="insert-content">
                
                    <div class="form-row insert-content">
                            <label for="validationCustom01">Item ID (cannot be modified)</label>
                            <input type="text" class="form-control" name="item_id" id="validationCustom01" placeholder="123" pattern="([0-9]){1,10}" data-toggle="tooltip" value="<?php echo $row['item_id']; ?>" data-placement="top" title="" data-original-title="Min 1 digit, Max 10 digits." title="" disabled>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>
                    </div>
                    <div class="form-row insert-content">
                            <label for="validationCustom02">Item Title</label>
                            <input type="text" class="form-control" name="item_title" id="validationCustom02" placeholder="Munchies" required="" pattern="([()A-Za-z ]){4,50}" value="<?php echo $row['item_title']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="4 characters minimum" title="">
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
                            <input type="text" class="form-control" name="item_price" id="validationCustom03" placeholder="199" required="" pattern="([0-9]){2,}" value="<?php echo $row['item_price']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Min 2 digits, Max 6 digits" title="">
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
                                <?php $staff->display_cat_dropdown(); ?>
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
    endwhile;
    }
    else
    {
        die("Do not change the URL!!");
    }
    $con->disconnect();
}

else if(isset($_GET['prod']) && isset($_GET['modify_prod']) && $_GET['modify_prod'] == 2 && $_SESSION['header'] == $_SERVER['QUERY_STRING'])
{
    $con->connect();
    $id = base64_decode($_GET['id']);
    $sql = "SELECT isAvailable, item_image FROM items WHERE item_id = " . $id;
    $send_query = $con->query($sql);
    if(isset($send_query))
    {
        while($row = mysqli_fetch_array($send_query)):
            if($row['isAvailable'] == 1) {
                $checked = "checked";
                $label = '<label class="custom-control-label" for="customCheck1">This item is marked as <strong>Available</strong>. Uncheck the box to mark it as <strong>Unavailable</strong>.</label>';
            } else {
                $checked = "";
                $label = '<label class="custom-control-label" for="customCheck1">This item is marked as <strong>Unavailable</strong>. Uncheck the box to mark it as <strong>Available</strong>.</label>';
            }
?>


<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center">Modify Item - Final step</h5>
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="index?<?php echo $_SERVER['QUERY_STRING']; ?>" novalidate>
        <?php $staff->modify_item(); ?>
            <div class="row">
            <div class="col-md-5 mb-3">
                <!-- <div class="insert-content"> -->
                    <div class="form-row insert-content">
                            <label for="validationCustom04">Sub-Category Title</label>
                            <select type="select" name="sub_cat_title" id="exampleCustomSelect" class="custom-select" required="">
                                <option value="">Select</option>
                                <?php $staff->dispay_subcat_dropdown(); ?>
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
                                The current image will be set as default if no image is selected.
                            </div>
                    </div>
                    <label for="validatedCustomFile">Current image</label><br>
                    <div class="form-row insert-content">                            
                            <!-- <div class="custom-file"> -->
                            <div>
                                <img id="validatedCustomFile" class="img-fluid current-image-modify shadow" src="<?php echo "../" . $row['item_image']; ?>">
                            </div>
                    </div>
                <!-- </div> -->

            </div>  <!-- col-md-4 second -->

            <div class="custom-control custom-checkbox insert-content text-center-force" data-toggle="tooltip"  data-placement="top" title="" data-original-title="Uncheck this box if you DO&nbsp;NOT&nbsp;want the item to show up on the website. This setting can be changed later. ">
              <input type="checkbox" class="custom-control-input" id="customCheck1" name="available_check" <?php echo $checked; ?> >
              <?php echo $label; ?>
            </div>

            </div>  <!-- row -->
                <div class="insert-content text-center">
                    <button href="#" class="btn btn-primary btn-icon-split blue-btn btn-padding" name="add_prod_publish" type="submit">
                        <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Modify</span>
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
    endwhile;
    }
    $con->disconnect();
}
else if(isset($_GET['prod']) && isset($_GET['modify_prod']) && $_GET['modify_prod'] == 3 && isset($_GET['lid']) && $_SESSION['header'] == $_SERVER['QUERY_STRING'])
{

?>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <h5 class="card-title text-gray-800 text-center">Item Updated!</h5>
        <?php $staff->modify_item(); 
        if(isset($_SESSION['header'])) unset($_SESSION['header']);
        ?>            

        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <div class="insert-content">
                <h5>Here are the details:</h5>
            </div>
            <div class="row">
                <?php $staff->display_last_item_added(); ?>
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
                                <?php //$staff->dispay_subcat_dropdown(); ?>
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

?>