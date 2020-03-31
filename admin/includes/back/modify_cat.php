<?php 

if(isset($_GET['cat']) && isset($_GET['modify_cat']) && isset($_GET['mod']) && !isset($_GET['del']))
{
    ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Categories</h1>
<a href="index?cat&modify_cat" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <?php isset($_GET['img']) ? $img = base64_decode($_GET['img']) : $img = "notset"; ?>
            <div class="row">
            <div class="col-md-5 mb-3">
                <h5 class="card-title text-gray-800">Modify Category</h5>
                <?php $admin->save_modify_cat($img); 
                ?>
                <div class="insert-content">
                <form class="needs-validation" method="POST" action="index?<?php echo $_SERVER['QUERY_STRING']; ?>" novalidate>
                    <div class="form-row insert-content">
                    <div class="insert-content img-modify">
                        <label>Modify the image of category</label><br>
                        <?php $admin->display_category_icons(); ?>
                    </div>
                        <div class="col-md-9">
                            <label for="validationCustom01">Category Title</label>
                            <input type="text" class="form-control" name="cat_title" id="validationCustom01" value="<?php $admin->display_catname_modify(); ?>" placeholder="Munchies" required="" pattern="([A-Za-z ]){4,}" data-toggle="tooltip" data-placement="top" title="" data-original-title="4 characters minimum">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please follow the requested format!
                            </div>                       

                        </div>
                        <div class="col-md-3 del-btn insert-content">
                            <?php 

                            if($admin->check_for_subcat(base64_decode($_GET['mod'])))
                            {
                                $disabled = "disabled ";
                                $tooltip = 'data-toggle="tooltip" data-placement="right" title="Categories that have Sub-Categories cannot be deleted. "';
                            } else {
                                $disabled = "";
                                $tooltip = "";
                            }

                            ?>
                            <span <?php echo $tooltip; ?> class="d-inline-block" tabindex="0">

                            <a href="index?cat&modify_cat&del&subcat&mod=<?php echo $_GET['mod']; ?>" class="<?php echo $disabled; ?> btn btn-danger btn-circle delete-btn-circle">
                            <i class="fas fa-trash"></i>
                            </a>                        
                            </span>
                        </div> 
                        <div class="img-modify col-md-10">
                            <label for="exampleFormControlTextarea1">Catgeory Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="cat_desc" rows="2"><?php $admin->display_cat_description(); ?></textarea>
                        </div>       
                    </div>

                    <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="save_modify_cat" type="submit">
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save</span>
                    </button> 
                </form>
                </div>

<!--                 <button href="#" class="btn btn-primary btn-icon-split blue-btn" name="add_category" type="submit">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add</span>
                </button>   -->
            </div>      <!-- col-md-4 first -->

            <div class="col-md-2"></div>   <!--  for space -->

            <div class="col-md-5 mb-3">
                <h5 class="card-title text-gray-800">Sub-Categories of <strong><?php $admin->display_catname_modify(); ?></strong></h5>
                <?php $admin->delete_subcat(); ?>
                <?php $admin->save_modify_subcat(); ?>
                    <div class="insert-content">
                     <form class="needs-validation" method="POST" action="index?cat&modify_cat&mod=<?php echo $_GET['mod']; ?>" novalidate>

                        <?php $admin->display_subcat_in_modify(); ?>

                    </div>

                    <?php 
                    $admin->temp == 1 ? $disabled = "disabled " : $disabled = "";

                    ?>

                    <button href="#" <?php echo $disabled; ?> class="btn btn-primary btn-icon-split blue-btn" name="modify_subcat" type="submit">
                        <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save</span>
                    </button> 
                    </form> 
                    <a href="index?cat&modify_cat&mod=<?php echo $_GET['mod']; ?>&delsc=<?php echo base64_encode("all"); ?>" class="<?php echo $admin->temp; ?> btn btn-danger btn-icon-split delete-btn <?php echo $disabled; ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete all Sub-Categories of <?php  $admin->display_catname_modify(); ?>">
                        <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">Delete all</span>
                    </a>

                    <a href="index?cat&add_cat#subcat" class="<?php echo $admin->temp; ?> btn btn-secondary btn-icon-split gray-btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add new Sub-Category for <?php  $admin->display_catname_modify(); ?>">
                    <span class="icon text-white-50">
                      <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Add New</span>
                    </a>

            </div>  <!-- col-md-4 second -->
            </div>  <!-- row -->

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

else            
{
    ?>

    <?php $admin->delete_category(); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categories</h1>
    <a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Goto Dashboard</a>
    </div>

    <div class="main-card mb-4 card shadow"> <!-- here -->
        <div class="card-body form-add cat-mod">
            <h5 class="card-title card-title-cat-modify text-gray-800">MODIFY CATEGORY</h5>
            <?php 
                if($admin->temp == 1 && isset($_GET['del']) && isset($_GET['mod']))
                {
                    setMessage("Category has been deleted. ");
                    $admin->temp = 0;  
                }
                if($admin->temp = 1 && isset($_GET['catdel']))
                {
                    setMessage("Category has been deleted. ");
                    $admin->temp = 0;                     
                }
            ?>
        </div>
    </div>



    <!-- SUB CATEGORIES -->
    <!-- <div id="subcat" class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sub Categories</h1>
    <a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Goto Dashboard</a>
    </div> -->

    <div class="row">
        <?php $admin->display_cat_modify(); ?>
    </div>


    <?php
}

?>

