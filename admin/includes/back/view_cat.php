<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Categories</h1>
<a href="index" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Goto Dashboard</a>
</div>

<div class="main-card mb-4 card shadow"> <!-- here -->
<div class="card-body form-add">
    <div class="row">
        <div class="col-md-6 card-title">
            <h5 class="text-gray-800">ALL CATEGORIES</h5>
            <div class="form-input-info">Click on the categories to view the sub-categories.</div>
        </div>
            
        <div class="col-md-6">
            <a href="index?cat&modify_cat"><button class="btn btn-secondary btn-icon-split gray-btn modify-btn">
            <span class="icon text-white-50">
              <i class="fas fa-arrow-right"></i>
            </span>
            <span class="text">Modify</span>
            </button></a>
        </div>
    </div>

    <?php $admin->display_cat_view(); ?>

</div>
</div>