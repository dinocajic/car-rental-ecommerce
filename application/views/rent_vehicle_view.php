<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade modal-wide product_view" id="product_view" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title"><?php echo $vehicles['year'] . " " . $vehicles['make'] . " " . $vehicles['model']; ?></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 product_img">
                        <img src="<?php echo $image_folder; ?>/1.jpg" class="img-responsive">
                        <p>
                            <img src="<?php echo $image_folder; ?>/2.jpg" class="small-images" />
                            <img src="<?php echo $image_folder; ?>/3.jpg" class="small-images" />
                            <img src="<?php echo $image_folder; ?>/4.jpg" class="small-images" />
                        </p>
                    </div>
                    <div class="col-md-6 product_content">
                        <div class="rating">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            (10 reviews)
                        </div>
                        <p class="specs">
                            <span>Engine: </span> <?php echo $vehicles['engine']; ?>
                        </p>

                        <p class="specs">
                            <span>Horsepower: </span> <?php echo $vehicles['horsepower']; ?>
                        </p>

                        <p class="specs">
                            <span>Torque: </span> <?php echo $vehicles['torque']; ?>
                        </p>

                        <p class="specs">
                            <span>0-60 time: </span> <?php echo $vehicles['zero_to_sixty_time']; ?> seconds
                        </p>

                        <p class="specs">
                            <span>1/4 mile: </span> <?php echo $vehicles['quarter_mile_time']; ?>
                        </p>
                        <hr />
                        <h3 class="cost">$<?php echo $vehicles['daily_cost']; ?>.00/day</h3>
                        <hr />
                        <div class="row">
                            <form id="select-date" method="post" action="<?php echo base_url(); ?>cart">
                                <div class="col-xs-12">
                                    <label for="date_from">From Date: </label>
                                    <input type="hidden" value="<?php echo $product_id; ?>" name="product_id" />
                                    <input type="hidden" value="<?php echo $vehicles['daily_cost']; ?>" name="daily_cost" />
                                    <input id="date_from" name="date_from" type="date" value="<?php echo $date_from; ?>">
                                </div>
                                <!-- end col -->
                                <div class="col-xs-12">
                                    <label for="date_to">To Date: </label>
                                    <input id="date_to" name="date_to" type="date" value="<?php echo $date_to; ?>">
                                </div>

                                <div class="col-xs-12">
                                    <label for="add_to_cart"></label>
                                    <input type="submit" name="add_to_cart" id="add_to_cart" class="btn btn-primary" value="Add to Cart" />
                                </div>
                                <!-- end col -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#product_view').modal('show');
</script>