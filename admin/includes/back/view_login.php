<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Logins</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Go Back</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
    <div class="card-body form-add">
        <div class="card-title">
            <h5 class="text-gray-800 text-center text-uppercase">
                <?php 
                if(isset($_GET['cust'])) {
                    echo "CUSTOMERS";
                } else 
                if (isset($_GET['admin'])) {
                    echo "ADMINS";
                }
                else {
                    echo "STAFF";
                }
                ?>
            </h5>
<!--             <div class="form-input-info text-center">
                Click on the item to view delivery and payment details.
            </div>   -->
        </div>      
            <div class="border-top-primary border-table-top"></div>
            <?php 
            $admin->delete_logins();
            //$admin->delete_product_view_page(); 
            //$admin->hide_product_view_page();
            ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr data-toggle="tooltip" data-placement="top" data-original-title="Click on the column names to sort accordingly.">
                    <th>Email ID</th>
                    <th>Name</th>
                    <th>Date Added</th>
                    <th>Date Modified</th>
                    <th></th>
                    <!-- <th></th> -->
                </tr>
              </thead>
              <tfoot>
                <tr>
                    <th>Email ID</th>
                    <th>Name</th>
                    <th>Date Added</th>
                    <th>Date Modified</th>
                    <th></th>
                    <!-- <th></th>                     -->
                </tr>
              </tfoot>
              <tbody>



<!--                 <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Mark '. $item_title .' as available. ">
                    <a href="index?prod&view_prod&itid='. base64_encode($item_id) .'&status='. base64_encode(1) .'" class="btn btn-success btn-circle btn-sm success-btn-circle">
                        <i class="fas fa-plus"></i>
                    </a>
                </td>  -->

<!--                 <div class="modal fade" id="exampleModal'. $item_id .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel'. $item_id .'" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel'. $item_id .'">Are you sure? This action is irreversible!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Do you want to permanently delete '. $item_title .'?</p>
                                '. $hide_instead .'
                            </div>
                            <div class="modal-footer">
                                <a href="index?prod&view_prod&del='. base64_encode($item_id) .'" class="btn btn-danger btn-icon-split delete-btn btn-padding">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Delete</span>
                                </a>
                                <button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-times"></i>
                                    </span>
                                    <span class="text">Close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->

                <?php $admin->display_customers(); ?>
              </tbody>
            </table>
        </div>
        <div class="border-bottom-primary border-table-bottom"></div>             
    </div>
</div>