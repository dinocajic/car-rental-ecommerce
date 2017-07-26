<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Update_profile
 */
class Update_profile extends CI_Controller {

    /**
     * Allows a user to update their profile. Updates the customer details, address and username/password info.
     */
    public function index() {
        $data['title'] = 'Update your Profile';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->model('customer_model');

        $data['errors'] = array();

        if ( isset($_POST['submit_changes']) ) {
            $customer['first_name']     = $_POST['customer_first_name'];
            $customer['middle_name']    = $_POST['customer_middle_name'];
            $customer['last_name']      = $_POST['customer_last_name'];
            $customer['customer_phone'] = $_POST['customer_phone'];
            $customer['customer_email'] = $_POST['customer_email'];

            // update customer details
            $this->customer_model->update_customer_details($customer);

            $address['street_1'] = $_POST['customer_street_1'];
            $address['street_2'] = $_POST['customer_street_2'];
            $address['city']     = $_POST['customer_city'];
            $address['state']    = $_POST['customer_state'];
            $address['zip']      = $_POST['customer_zip'];

            // update customer address
            $address_id = $this->customer_model->check_if_address_exists( $address );

            if ( !$address_id ) {
                // need to insert address
                $address_id = $this->customer_model->add_address( $address );
                $this->customer_model->link_customer_to_new_address($_SESSION['customer_id'], $address_id);
            }

            // update password
            $pass    = $_POST['customer_password'];
            $re_pass = $_POST['customer_password_repeat'];

            if (!empty($pass)) {
                $this->load->model('validation_model');
                $password['password'] = $this->validation_model->validate_password( $pass, $re_pass );

                if ($password['password'] === false) {
                    $data['errors']['customer_password'] = false;
                } else {
                    $password['customer_id'] = $_SESSION['customer_id'];
                    $this->load->model('login_model');
                    $this->login_model->update_password( $password );
                }
            }
        }

        $data['customer_details'] = $this->customer_model->get_customer_details( (int)$_SESSION['customer_id'] );

        $this->load->view('header', $data);
        $this->load->view('update_profile_view', $data);
        $this->load->view('footer');
    }
}