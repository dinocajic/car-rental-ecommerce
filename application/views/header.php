<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/rental.png" class="img-responsive" id="logo" /></a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>about">About</a></li>
            <li><a href="<?php echo base_url(); ?>rent_vehicle">Vehicle Selection</a></li>
            <li><a href="<?php echo base_url(); ?>contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
                ?>
                <li><a href="<?php echo base_url(); ?>customer_account"><i class="fa fa-address-book"></i> Welcome <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></a></li>
                <li><a href="<?php echo base_url(); ?>customer_account"><i class="fa fa-address-book"></i> Account</a></li>
                <?php
                if ($_SESSION['access_level'] == 100) {
                    ?><li><a href="<?php echo base_url(); ?>admin_account"><i class="fa fa-users"></i> Admin Account</a></li><?php
                }
                ?>
                <li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-address-book-o"></i> Logout</a></li>
                <?php
            } else {
                ?>
                <li><a href="<?php echo base_url(); ?>register"><i class="fa fa-address-book"></i> Sign Up</a></li>
                <li><a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-address-book-o"></i> Login</a></li>
                <?php
            }

            if ( isset($_SESSION['cart_total']) ) {
                ?><li><a href="<?php echo base_url(); ?>cart"><i class="fa fa-shopping-cart"></i> $<?php echo $_SESSION['cart_total']; ?></a></li><?php
            }
            ?>
        </ul>
    </div>
</nav>

<?php echo $login; ?>