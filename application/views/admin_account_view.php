<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style="margin-bottom: 120px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-car"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">Welcome to your Account <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></h4>
                    <p>
                        Good job! We have had tremendous success during the first two quarters. I know we can continue the
                        upward climb. Starting this Tuesday, we will hold weekly strategy meetings to plan ways to
                        out-perform the Exotic Car Rentals Group in sales and service--with the emphasis on service. We want our customers
                        to leave the store happy with the service and products we provide them. Good service always translates into more sales.
                    </p>
                    <p>
                        <i class="fa fa-user" style="display: inline-block; width: 20px;"></i> <a href="<?php echo base_url(); ?>update_profile">Update your Profile</a><br />
                        <i class="fa fa-car" style="display: inline-block; width: 20px;"></i> <a href="<?php echo base_url(); ?>admin_account/view_sales_history">View Sales History</a>
                    </p>
                    <p>
                        It has been great to get bonuses for exceeding sales goals, and I want you to keep getting them.
                        Remember, the earlier in the month we reach our goals, the more time remains for added bonus money.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>