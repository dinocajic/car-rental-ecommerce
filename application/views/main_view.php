<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
	<div class="row">
        <div id="main-background">
            <img src="<?php echo base_url(); ?>assets/images/rental.png" />
            <h1>Exotic Car Rentals</h1>
            <h2>From Ferrari's to Lamborghini's and everything in between</h2>
        </div>

        <div id="vehicle-selection">
            <h1>Search for Vehicles</h1>
            <hr />
            <form id="select-vehicle" method="post" action="<?php echo base_url(); ?>rent_vehicle/process_search">
                <p>
                    <label for="date_from">From Date: </label>
                    <input id="date_from" name="date_from" type="date">
                </p>
                <p>
                    <label for="date_to">To Date: </label>
                    <input id="date_to" name="date_to" type="date">
                </p>

                <p>
                    <label for="vehicle">Choose Vehicle: </label>
                    <select name="vehicle" id="vehicle">
                        <?php
                        foreach($vehicles as $vehicle) {
                            echo "<option value='" . $vehicle['id'] . "'>" . $vehicle['year'] . " " . $vehicle['make'] . " " . $vehicle['model'] . "</option>";
                        }
                        ?>
                    </select>
                </p>

                <p>
                    <label for="search_for_vehicles_submit"></label>
                    <input type="submit" name="search_for_vehicles_submit" id="search_for_vehicles_submit" value="Search for Vehicles" />
                </p>
            </form>
        </div>


    </div>
</div>

<div class="container-fluid" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-car"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">The #1 Exotic Car Rental Site</h4>
                    <p>
                        <img src="<?php echo base_url(); ?>assets/images/exotic-cars.jpg" class="img-responsive" width="100%" />
                    </p>
                    <a href="<?php echo base_url(); ?>rent_vehicle" class="btn">Go rent a car</a>
                </div>
            </div>
        </div>
    </div>
</div>