<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style="margin-bottom: 20px;">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-icon">
                <span class="fa fa-4x fa-car"></span>
            </div>
            <div class="info">
                <div id="registration">
                    <h1>Update your profile</h1>
                    <hr />

                    <?php

                    if (!empty($errors)) {
                        echo "<h3>Please review errors below<hr /></h3>";
                    }

                    if (isset($errors['registered'])) {
                        echo "<h4>" . $errors['registered'] . "</h4>";
                    }
                    ?>

                    <form id="register" method="post" action="<?php echo base_url(); ?>update_profile">
                        <div>
                            <label for="customer_first_name"<?php echo (isset($errors['first_name'])) ? " class='error'" : ""; ?>>First Name: </label>
                            <input type="text" name="customer_first_name" id="customer_first_name" value="<?php echo (isset($_POST['customer_first_name'])) ? $_POST['customer_first_name'] : $customer_details['first_name']; ?>" />
                        </div>

                        <div>
                            <label for="customer_middle_name"<?php echo (isset($errors['middle_name'])) ? " class='error'" : ""; ?>>Middle Name: </label>
                            <input type="text" name="customer_middle_name" id="customer_middle_name" value="<?php echo (isset($_POST['customer_middle_name'])) ? $_POST['customer_middle_name'] : $customer_details['middle_name']; ?>" />
                        </div>

                        <div>
                            <label for="customer_last_name"<?php echo (isset($errors['last_name'])) ? " class='error'" : ""; ?>>Last Name: </label>
                            <input type="text" name="customer_last_name" id="customer_last_name" value="<?php echo (isset($_POST['customer_first_name'])) ? $_POST['customer_last_name'] : $customer_details['last_name']; ?>" />
                        </div>

                        <div>
                            <label for="customer_phone"<?php echo (isset($errors['customer_phone'])) ? " class='error'" : ""; ?>>Phone Number: </label>
                            <input type="text" name="customer_phone" id="customer_phone" value="<?php echo (isset($_POST['customer_phone'])) ? $_POST['customer_phone'] : $customer_details['customer_phone']; ?>" />
                        </div>

                        <div>
                            <label for="customer_email"<?php echo (isset($errors['customer_email'])) ? " class='error'" : ""; ?>>Email Address: </label>
                            <input type="text" name="customer_email" id="customer_email" value="<?php echo (isset($_POST['customer_email'])) ? $_POST['customer_email'] : $customer_details['customer_email']; ?>" />
                        </div>

                        <div>
                            <label for="customer_street_1"<?php echo (isset($errors['street_1'])) ? " class='error'" : ""; ?>>Street: </label>
                            <input type="text" name="customer_street_1" id="customer_street_1" value="<?php echo (isset($_POST['customer_street_1'])) ? $_POST['customer_street_1'] : $customer_details['address']['street_1']; ?>" />
                        </div>

                        <div>
                            <label for="customer_street_2"<?php echo (isset($errors['street_2'])) ? " class='error'" : ""; ?>>Street 2: </label>
                            <input type="text" name="customer_street_2" id="customer_street_2" value="<?php echo (isset($_POST['customer_street_2'])) ? $_POST['customer_street_2'] : $customer_details['address']['street_2']; ?>" />
                        </div>

                        <div>
                            <label for="customer_city"<?php echo (isset($errors['city'])) ? " class='error'" : ""; ?>>City: </label>
                            <input type="text" name="customer_city" id="customer_city" value="<?php echo (isset($_POST['customer_city'])) ? $_POST['customer_city'] : $customer_details['address']['city']; ?>" />
                        </div>

                        <div>
                            <label for="customer_state"<?php echo (isset($errors['state'])) ? " class='error'" : ""; ?>>State: </label>
                            <input type="text" name="customer_state" id="customer_state" value="<?php echo (isset($_POST['customer_state'])) ? $_POST['customer_state'] : $customer_details['address']['state']; ?>" />
                        </div>

                        <div>
                            <label for="customer_zip"<?php echo (isset($errors['zip'])) ? " class='error'" : ""; ?>>Zip Code: </label>
                            <input type="text" name="customer_zip" id="customer_zip" value="<?php echo (isset($_POST['customer_zip'])) ? $_POST['customer_zip'] : $customer_details['address']['zip']; ?>" />
                        </div>

                        <?php
                        if (isset($errors['password'])) {
                            echo "<p>You must enter a password that is at least 5 characters in length and make sure that the passwords you entered match.</p>";
                        }
                        ?>

                        <div>
                            <label for="customer_password"<?php echo (isset($errors['password'])) ? " class='error'" : ""; ?>>Password: </label>
                            <input type="password" name="customer_password" id="customer_password" />
                        </div>

                        <div>
                            <label for="customer_password_repeat"<?php echo (isset($errors['password'])) ? " class='error'" : ""; ?>>Repeat Password: </label>
                            <input type="password" name="customer_password_repeat" id="customer_password_repeat" />
                        </div>

                        <div>
                            <label for="submit_changes"></label>
                            <input type="submit" name="submit_changes" id="submit_changes" value="Update Profile" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>