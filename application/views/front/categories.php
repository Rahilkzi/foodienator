<div class="cat-page-header">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
            <h1 class="display-4">Categories</h1>
         </div>
        </div>
    </div>
</div>
<div class="container text-center ">
    <div class="row">
        <?php if(!empty($categories)) { ?>
        <?php foreach($categories as $category) { ?>
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card cat-card">
                <?php $image = $category['img'];?>
                <img class="card-img-top" src="<?php echo base_url().'public/uploads/category/thumb/'.$image; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $category['c_name']; ?></h4>
                    
                    <p class="card-text">  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam sit a, dicta quisquam
                    , laboriosam odio, quibusdam amet soluta omnis fugit minima ullam consectetur?
                    </p>
                   
                    <hr>
                    <a href="<?php echo base_url().'dish/list/'.$category['c_id']; ?>" class="btn btn-primary">
                        <i class="fa fa-list"></i>
                        View Menu</a>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <h1>No records found</h1>
        <?php } ?>
    </div>
</div>