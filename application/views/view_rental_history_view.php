<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-car"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">Rental History</h4>
                    <p>
                        Below you'll find all of the vehicles that you've had the pleasure of driving over the years. We thank you for your business and hope to see you soon.
                    </p>

                    <table class="table package-table">
                        <tbody>
                        <tr>
                            <td>Vehicle</td>
                            <td>Date From</td>
                            <td>Date To</td>
                            <td>Cost</td>
                        </tr>

                    <?php
                    foreach($rentals as $rental) {
                        ?>
                                <tr>
                                    <td><?php echo $rental['year'] . " " . $rental['make'] . " " . $rental['model']; ?></td>
                                    <td><?php echo date('m-d-Y', strtotime($rental['date_from'])); ?></td>
                                    <td><?php echo date('m-d-Y', strtotime($rental['date_to'])); ?></td>
                                    <td>$<?php echo number_format($rental['total_paid'], 2, '.', ''); ?></td>
                                </tr>
                            </tbody>

                        <?php
                    }
                    ?>

                    </table>

                    <a href="<?php echo base_url(); ?>rent_vehicle" class="btn">Go rent a car</a>
                </div>
            </div>
        </div>
    </div>
</div>