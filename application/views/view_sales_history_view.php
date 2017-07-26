<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-car"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">Sales History</h4>

                    <table class="table package-table">
                        <tbody>
                        <tr>
                            <td>Vehicle</td>
                            <td>Date From</td>
                            <td>Date To</td>
                            <td>Cost</td>
                        </tr>

                        <?php
                        $total = 0;

                        foreach($rentals as $rental) {
                        $total += $rental['total_paid'];
                        ?>
                        <tr>
                            <td><?php echo $rental['year'] . " " . $rental['make'] . " " . $rental['model']; ?></td>
                            <td><?php echo date('m-d-Y', strtotime($rental['date_from'])); ?></td>
                            <td><?php echo date('m-d-Y', strtotime($rental['date_to'])); ?></td>
                            <td>$<?php echo number_format($rental['total_paid'], 2, '.', ''); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total: </td>
                            <td>$<?php echo number_format($total, 2, '.', ''); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>