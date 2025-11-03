<div class="dish-page-header">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="display-4"><?php echo $cat['c_name']; ?> Menu</h1>
                <p class="lead">Explore our delicious selection of <?php echo $cat['c_name']; ?> dishes</p>
            </div>
        </div>
    </div>
</div>

<!-- <div class="container">
    <div class="category-banner">
        <div class="row no-gutters align-items-center">
            <div class="col-md-6">
                <?php $img = $cat['img'];?>
                <img src="<?php echo base_url().'public/uploads/category/thumb/'.$img; ?>" class="img-fluid" alt="<?php echo $cat['c_name']; ?>">
            </div>
            <div class="col-md-6">
                <div class="category-info">
                    <h2><?php echo $cat['c_name']; ?></h2>
                    <p>A feast of gorgeousness awaits you with super-seasonal dishes created with love by our wonderful chefs. Each dish is carefully crafted using the freshest ingredients to deliver an unforgettable dining experience.</p>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="container">
    <div class="row">
        <?php if(!empty($dishesh)) { ?>
            <?php foreach($dishesh as $dish) { ?>
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card dish-card">
                    <?php $image = $dish['img'];?>
                    <img class="card-img-top" src="<?php echo base_url().'public/uploads/dishesh/thumb/'.$image; ?>" alt="<?php echo $dish['name']; ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="card-title"><?php echo $dish['name']; ?></h4>
                            <h4 class="price">₹<?php echo $dish['price']; ?></h4>
                        </div>
                        <p class="card-text"><?php echo $dish['about']; ?></p>
                        <a href="<?php echo base_url().'Dish/addToCart/'.$dish['d_id']; ?>" class="btn btn-primary mt-auto">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-12">
                <div class="no-dishes">
                    <h2>No dishes found</h2>
                    <p>We're currently updating our menu. Please check back later for delicious <?php echo $cat['c_name']; ?> options.</p>
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>