<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style="margin-bottom: 10px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-4x fa-car"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">Welcome to your Account <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></h4>
                    <p>
                        A car rental, hire car, or car hire agency is a company that rents automobiles for short periods of time,
                        generally ranging from a few hours to a few weeks. It is often organized with numerous local branches
                        (which allow a user to return a vehicle to a different location), and primarily located near airports
                        or busy city areas and often complemented by a website allowing online reservations.
                    </p>

                    <p>
                        <i class="fa fa-user" style="display: inline-block; width: 20px;"></i> <a href="<?php echo base_url(); ?>update_profile">Update your Profile</a><br />
                        <i class="fa fa-car" style="display: inline-block; width: 20px;"></i> <a href="<?php echo base_url(); ?>customer_account/view_rental_history">View Rental History</a>
                    </p>

                    <p>
                        Car rental agencies primarily serve people who require a temporary vehicle, for example those who
                        do not own their own car, travelers who are out of town, or owners of damaged or destroyed vehicles
                        who are awaiting repair or insurance compensation. Car rental agencies may also serve the self-moving
                        industry needs, by renting vans or trucks, and in certain markets other types of vehicles such as
                        motorcycles or scooters may also be offered.
                    </p>

                    <p>
                        <img src="<?php echo base_url(); ?>assets/images/lamborghini.png" alt="Lamborghini" class="img-responsive" width="100%" />
                    </p>
                    <p>
                        Alongside the basic rental of a vehicle, car rental agencies typically also offer extra products
                        such as insurance, global positioning system (GPS) navigation systems, entertainment systems,
                        mobile phones, portable WiFi and child safety seats.
                    </p>
                    <a href="<?php echo base_url(); ?>rent_vehicle" class="btn">Go rent a car</a>
                </div>
            </div>
        </div>
    </div>
</div>