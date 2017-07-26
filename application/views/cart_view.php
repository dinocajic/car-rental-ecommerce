<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <?php
            // If there are no items in the cart
            if ($_SESSION['cart_total'] == 0) {
                ?>
                            <h1>There are no items in the cart</h1>

                            <?php
                            if ( isset($error) ) {
                                echo "<h3>" . $error . "</h3><hr />";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                return;
            }

            ?>

            <h1>Cart</h1>

            <?php
            if ( isset($error) ) {
                echo "<h3>" . $error . "</h3><hr />";
            }
            ?>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Days</th>
                    <th class="text-center">Daily $</th>
                    <th class="text-center">Total $</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cost_wo_tax = number_format($_SESSION['cart_total'], 2, '.', '');
                $tax         = number_format( ((float)$cost_wo_tax * 0.07), 2, '.', '');
                $cost_w_tax  = number_format(((float)$cost_wo_tax + (float)$tax), 2, '.', '');

                foreach($_SESSION['cart_items'] as $product_id => $cart_item) {
                    $year       = $cart_item['vehicle_details']['year'];
                    $make       = $cart_item['vehicle_details']['make'];
                    $model      = $cart_item['vehicle_details']['model'];
                    $daily_cost = $cart_item['vehicle_details']['daily_cost'];
                    $total_cost = $cart_item['total'];
                    $date_from  = $cart_item['date_from'];
                    $date_to    = $cart_item['date_to'];
                    $days       = $cart_item['days'];

                    $image_folder = base_url() . "assets/images/" . strtolower($year) . "_" . str_replace(" ", "_", strtolower($make)) . "_" . strtolower($model);
                    ?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left small-images" href="<?php echo base_url() . "rent_vehicle/process_search/" . $product_id; ?>"> <img class="media-object" src="<?php echo $image_folder; ?>/1.jpg"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?php echo base_url() . "rent_vehicle/process_search/" . $product_id; ?>">
                                            <?php echo $year . " " . $make . " " . $model; ?>
                                        </a>
                                    </h4>
                                    <span class="cart-date">Date From: </span><span class="text-primary"><strong><?php echo $date_from; ?></strong></span><br />
                                    <span class="cart-date">Date To:   </span><span class="text-primary"><strong><?php echo $date_to; ?></strong></span>
                                </div>
                            </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            <?php echo $days; ?>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $daily_cost; ?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $total_cost; ?></strong></td>
                        <td class="col-sm-1 col-md-1">
                            <a href="<?php echo base_url(); ?>cart/remove/<?php echo $product_id; ?>">
                                <button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span> Remove
                                </button></td>
                            </a>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Subtotal<br>Estimated tax</h5><h5>Total</h5></td>
                    <td class="text-right">
                        <h5><strong>$<?php echo $cost_wo_tax; ?><br>$<?php echo $tax; ?></strong></h5><h5 style="margin-right: 0;">$<?php echo $cost_w_tax; ?></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <a href="<?php echo base_url() . "rent_vehicle"; ?>">
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                            </button>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url() . "checkout"; ?>">
                            <button type="button" class="btn btn-success">
                                Checkout <span class="glyphicon glyphicon-play"></span>
                            </button>
                        </a>
                    </td>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>