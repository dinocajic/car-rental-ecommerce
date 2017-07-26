<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Checkout
 */
class Checkout extends CI_Controller {

    /** @var array $_errors - Checkout errors */
    private $_errors = array();

    /** @var array $_data - Sanitized input */
    private $_data = array();

    /**
     * Allows the user to enter billing, shipping and payment information to complete the purchase. Once the user enters
     * the information, a thorough check is performed before allowing the customer to complete the order. If the input is
     * good, the order is inserted and a success page is displayed. Otherwise, errors that need to be fixed are displayed
     * on the page.
     */
    public function index() {
        // Auto populate customer information
        if ( isset($_SESSION['customer_id']) ) {
            $this->load->model('customer_model');
            $address = $this->customer_model->get_customer_address($_SESSION['customer_id']);

            $_SESSION['cart_shipping']['street'] = $address['street_1'];
            $_SESSION['cart_shipping']['city'] = $address['city'];
            $_SESSION['cart_shipping']['state'] = $address['state'];
            $_SESSION['cart_shipping']['zip'] = $address['zip'];
        }

        $this->load->model('cart_model');

        // Once the user presses the submit button
        if (isset($_POST['buy_now'])) {
            // validate make sure there are no errors
            $this->_data['billing_first_name']   = $_POST['billing_first_name'];
            $this->_data['billing_last_name']    = $_POST['billing_last_name'];
            $this->_data['card_number']          = $_POST['card_number'];
            $this->_data['expiration_month']     = $_POST['expiration_month'];
            $this->_data['expiration_year']      = $_POST['expiration_year'];
            $this->_data['cvv']                  = $_POST['cvv'];
            $this->_data['card_type']            = $_POST['card_type'];
            $this->_data['billing_street']       = $_POST['billing_street'];
            $this->_data['billing_city']         = $_POST['billing_city'];
            $this->_data['billing_state']        = $_POST['billing_state'];
            $this->_data['billing_zip']          = $_POST['billing_zip'];
            $this->_data['shipping_first_name']  = $_POST['shipping_first_name'];
            $this->_data['shipping_last_name']   = $_POST['shipping_last_name'];
            $this->_data['shipping_phone']       = $_POST['shipping_phone'];
            $this->_data['shipping_email']       = $_POST['shipping_email'];
            $this->_data['shipping_street']      = $_POST['shipping_street'];
            $this->_data['shipping_city']        = $_POST['shipping_city'];
            $this->_data['shipping_state']       = $_POST['shipping_state'];
            $this->_data['shipping_zip']         = $_POST['shipping_zip'];
            $this->_data['password']             = $this->_data['shipping_phone'];
            $this->_data['re-password']          = $this->_data['shipping_phone'];

            $_SESSION['cart_shipping']['street'] = $this->_data['shipping_street'];
            $_SESSION['cart_shipping']['city']   = $this->_data['shipping_city'];
            $_SESSION['cart_shipping']['state']  = $this->_data['shipping_state'];
            $_SESSION['cart_shipping']['zip']    = $this->_data['shipping_zip'];

            // validation
            $this->check_for_errors();

            if ( empty($this->_errors) ) {
                // upon pass, insert into tables
                $this->cart_model->insert_order($this->_data);

                $data['title'] = 'Checkout';
                $data['login'] = $this->load->view('login_view', NULL, TRUE);

                $this->load->view('header', $data);
                $this->load->view('checkout_view_success');

                $to      = $this->_data['shipping_email'];
                $subject = 'Thank you for your order at Exotic Car Rentals';
                $body    = 'Your order has been received. We will contact you when it is ready for pickup';
                $headers = "From: webmaster@cyberrims.com" . "\r\n" .
                           "CC: sales@cyberrims.com";

                mail($to, $subject, $body, $headers);
                return;
            }

            $data = $this->_data;
            $data['errors'] = $this->_errors;
        } else {
            $data = $this->_data;
        }

        $data['credit_cards'] = $this->cart_model->get_credit_cards();

        $data['title'] = 'Checkout';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('checkout_view', $data);
        $this->load->view('footer');
    }

    /**
     * Checks for errors
     */
    private function check_for_errors() {
        foreach($this->_data as $key => $value) {
            // Clean up any unnecessary spaces
            $this->_data[$key] = trim($value);
        }

        // All validation is done in the validation_model
        $this->load->model('validation_model');

        $this->_data['shipping_first_name'] = $this->validation_model->validate_name( $this->_data['shipping_first_name'] );
        $this->_data['shipping_last_name']  = $this->validation_model->validate_name( $this->_data['shipping_last_name'] );
        $this->_data['shipping_phone']      = $this->validation_model->validate_phone( $this->_data['shipping_phone'] );
        $this->_data['shipping_email']      = $this->validation_model->validate_email( strtolower($this->_data['shipping_email']) );
        $this->_data['shipping_street']     = $this->validation_model->validate_street( $this->_data['shipping_street'] );
        $this->_data['shipping_city']       = $this->validation_model->validate_city( $this->_data['shipping_city'] );
        $this->_data['shipping_state']      = $this->validation_model->validate_state( $this->_data['shipping_state'] );
        $this->_data['shipping_zip']        = $this->validation_model->validate_zip( $this->_data['shipping_zip'] );
        $this->_data['billing_first_name']  = $this->validation_model->validate_name( $this->_data['billing_first_name'] );
        $this->_data['billing_last_name']   = $this->validation_model->validate_name( $this->_data['billing_last_name'] );
        $this->_data['billing_street']      = $this->validation_model->validate_street( $this->_data['billing_street'] );
        $this->_data['billing_city']        = $this->validation_model->validate_city( $this->_data['billing_city'] );
        $this->_data['billing_state']       = $this->validation_model->validate_state( $this->_data['billing_state'] );
        $this->_data['billing_zip']         = $this->validation_model->validate_zip( $this->_data['billing_zip'] );
        $this->_data['password']            = $this->validation_model->validate_password( $this->_data['password'], $this->_data['re-password'] );

        if ( !$this->validation_model->luhn_check( $this->_data['card_number'] ) ) {
            $this->_data['card_number']     = false;
        }

        $this->_data['cvv']                 = $this->validation_model->validate_cvv( $this->_data['cvv'] );

        // If any inputs are not valid, it'll store them in the $_errors array
        foreach($this->_data as $key => $value) {
            if ($value === false) {
                $this->_errors[$key] = $this->_data[$key];
            }
        }
    }
}