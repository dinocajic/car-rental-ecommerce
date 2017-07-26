<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>checkout">
        <?php
        if ( !empty($errors) ) {
            echo '<h3>Please fix all items below.</h3>';
        }
        ?>
        <fieldset>
            <legend>Payment</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="billing_first_name">Name on Card</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['billing_first_name'])) ? " error" : ""; ?>" name="billing_first_name" id="billing_first_name"
                           placeholder="Card Holder's First Name" value="<?php echo ( isset($_POST['billing_first_name']) ) ? $_POST['billing_first_name'] : ''; ?>">
                </div>

                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['billing_last_name'])) ? " error" : ""; ?>" name="billing_last_name" id="billing_last_name"
                           placeholder="Card Holder's Last Name" value="<?php echo ( isset($_POST['billing_last_name']) ) ? $_POST['billing_last_name'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card_number">Card Number</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control<?php echo (isset($errors['card_number'])) ? " error" : ""; ?>" name="card_number" id="card_number"
                           placeholder="Debit/Credit Card Number" value="<?php echo ( isset($_POST['card_number']) ) ? $_POST['card_number'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="expiration_month">Expiration Date</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-3">
                            <select class="form-control col-sm-2" name="expiration_month" id="expiration_month">
                                <option value="01">Jan (01)</option>
                                <option value="02">Feb (02)</option>
                                <option value="03">Mar (03)</option>
                                <option value="04">Apr (04)</option>
                                <option value="05">May (05)</option>
                                <option value="06">June (06)</option>
                                <option value="07">July (07)</option>
                                <option value="08">Aug (08)</option>
                                <option value="09">Sep (09)</option>
                                <option value="10">Oct (10)</option>
                                <option value="11">Nov (11)</option>
                                <option value="12">Dec (12)</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select class="form-control" name="expiration_year" title="expiration_year">
                                <?php
                                $year = date('Y');

                                for ($i = $year; $i <= $year + 10; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['cvv'])) ? " error" : ""; ?>" name="cvv" id="cvv"
                           placeholder="Security Code" value="<?php echo ( isset($_POST['cvv']) ) ? $_POST['cvv'] : ''; ?>">
                </div>

                <div class="col-xs-3">
                    <select class="form-control col-sm-2" name="card_type" id="card_type" title="Card Type">
                        <?php
                        foreach($credit_cards as $card) {
                            echo '<option value="' . $card['card_id'] . '">' . $card['card_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

        </fieldset>
        
        <fieldset>
            <legend>Billing Address</legend>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="billing_street">Billing Info</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control<?php echo (isset($errors['billing_street'])) ? " error" : ""; ?>" name="billing_street" id="billing_street"
                           placeholder="Street" value="<?php echo ( isset($_POST['billing_street']) ) ? $_POST['billing_street'] : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="billing_city"></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['billing_city'])) ? " error" : ""; ?>" name="billing_city" id="billing_city"
                                   placeholder="City" value="<?php echo ( isset($_POST['billing_city']) ) ? $_POST['billing_city'] : ''; ?>">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['billing_state'])) ? " error" : ""; ?>" name="billing_state" id="billing_state"
                                   placeholder="State" value="<?php echo ( isset($_POST['billing_state']) ) ? $_POST['billing_state'] : ''; ?>">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['billing_zip'])) ? " error" : ""; ?>" name="billing_zip" id="billing_zip"
                                   placeholder="Zip" value="<?php echo ( isset($_POST['billing_zip']) ) ? $_POST['billing_zip'] : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>

        <fieldset>
            <legend>Shipping Info/Order Details</legend>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="shipping_first_name">Customer Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['shipping_first_name'])) ? " error" : ""; ?>" name="shipping_first_name" id="shipping_first_name"
                           placeholder="Customer's First Name" value="<?php echo (isset($_POST['shipping_first_name'])) ? $_POST['shipping_first_name'] : $_SESSION['first_name']; ?>">
                </div>

                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['shipping_last_name'])) ? " error" : ""; ?>" name="shipping_last_name" id="shipping_last_name"
                           placeholder="Customer's Last Name" value="<?php echo (isset($_POST['shipping_last_name'])) ? $_POST['shipping_last_name'] : $_SESSION['last_name']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="shipping_email"></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['shipping_email'])) ? " error" : ""; ?>" name="shipping_email" id="shipping_email"
                           placeholder="Customer's Email" value="<?php echo (isset($_POST['shipping_email'])) ? $_POST['shipping_email'] : $_SESSION['username']; ?>">
                </div>

                <div class="col-sm-3">
                    <input type="text" class="form-control<?php echo (isset($errors['shipping_phone'])) ? " error" : ""; ?>" name="shipping_phone" id="shipping_phone"
                           placeholder="Customer's Phone" value="<?php echo (isset($_POST['shipping_phone'])) ? $_POST['shipping_phone'] : $_SESSION['phone']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="shipping_street">Shipping Info</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control<?php echo (isset($errors['shipping_street'])) ? " error" : ""; ?>" name="shipping_street" id="shipping_street"
                           placeholder="Street" value="<?php echo (isset($_POST['shipping_street'])) ? $_POST['shipping_street'] : $_SESSION['cart_shipping']['street']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="shipping_city"></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['shipping_city'])) ? " error" : ""; ?>" name="shipping_city" id="shipping_city"
                                   placeholder="City" value="<?php echo (isset($_POST['shipping_city'])) ? $_POST['shipping_city'] : $_SESSION['cart_shipping']['city']; ?>">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['shipping_state'])) ? " error" : ""; ?>" name="shipping_state" id="shipping_state"
                                   placeholder="State" value="<?php echo (isset($_POST['shipping_state'])) ? $_POST['shipping_state'] : $_SESSION['cart_shipping']['state']; ?>">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control<?php echo (isset($errors['shipping_zip'])) ? " error" : ""; ?>" name="shipping_zip" id="shipping_zip"
                                   placeholder="Zip" value="<?php echo (isset($_POST['shipping_zip'])) ? $_POST['shipping_zip'] : $_SESSION['cart_shipping']['zip']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" value="Pay Now $<?php echo $_SESSION['cart_total']; ?>" name="buy_now" id="buy_now" class="btn btn-success" />
                </div>
            </div>

        </fieldset>
    </form>
</div>

<script type="text/javascript">
    // Automatically select card type based on number
    $("#card_number").change(function() {
        var card_number = $('#card_number').val();

        //MasterCard IINs have the first two digts in the range 51-55
        if (
            card_number.search('51') == 0 ||
            card_number.search('52') == 0 ||
            card_number.search('53') == 0 ||
            card_number.search('54') == 0 ||
            card_number.search('55') == 0
        ) {
            $("#card_type").val("3");

            //Visa IINs always begin with a 4
        } else if (card_number.search('4') == 0) {
            $("#card_type").val("2");

            //American Expression IINs always begin with 34 or 37
        } else if (
            card_number.search('34') == 0 ||
            card_number.search('37') == 0
        ) {
            $("#card_type").val("4");

            //If nothing else, then Discover
        } else {
            $("#card_type").val("1");
        }

    });

</script>