<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Register
 */
class Register extends CI_Controller {

    /** @var array $_data - Sanitized input */
    private $_data   = array();

    /** @var array $_errors - Registration errors */
    private $_errors = array();

    /**
     * Registration page. If the user clicks on the register button, the check_input() method is called. If there are no
     * errors, the add_customer() method is called in the customer_model to attempt to add the items to the database. If
     * no errors occur, the user is successfully added and redirected to the login page. Otherwise, errors are notated
     * and sent to the registration page where the customer has the opportunity to correct them.
     */
    public function index() {
        if (isset($_POST['register_submit'])) {
            $this->check_input();

            if (empty($this->_errors)) {
                $this->load->model('customer_model');

                if ($this->customer_model->add_customer($this->_data)) {
                    header('Location: ' . base_url() . 'login');
                    return;
                }

                $this->_errors['registered'] = "You are already registered. If you can't remember your password, you can <a href='" . base_url() . "reset_password'>reset it</a>.";
            }

            $data['errors'] = $this->_errors;
        }

        $data['title'] = 'Register';

        $this->load->library('form_library');
        $data['state'] = $this->form_library->get_states(); // For the states drop-down menu
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('register_view', $data);
        $this->load->view('footer');
    }

    /**
     * Calls the validation model and passes the arguments to validate form field entries. Sanitized form
     * field entries are stored in the $this->_data array. If any errors occurred, the $this->_errors array
     * will store the errors.
     */
    private function check_input() {
        $data = array();
        $data['first_name']     = $_POST['customer_first_name'];
        $data['middle_name']    = $_POST['customer_middle_name'];
        $data['last_name']      = $_POST['customer_last_name'];
        $data['customer_phone'] = $_POST['customer_phone'];
        $data['customer_email'] = $_POST['customer_email'];
        $data['street_1']       = $_POST['customer_street_1'];
        $data['street_2']       = $_POST['customer_street_2'];
        $data['city']           = $_POST['customer_city'];
        $data['state']          = $_POST['customer_state'];
        $data['zip']            = $_POST['customer_zip'];
        $data['password']       = $_POST['customer_password'];
        $data['re_password']    = $_POST['customer_password_repeat'];

        foreach($data as $key => $value) {
            // Clean up any unnecessary spaces
            $data[$key] = trim($value);
        }

        // All validation is done in the validation_model
        $this->load->model('validation_model');

        $this->_data['first_name']      = $this->validation_model->validate_name( $data['first_name'] );

        if (strlen($data['middle_name']) > 0) {
            $this->_data['middle_name'] = $this->validation_model->validate_name( $data['middle_name'] );
        } else {
            $this->_data['middle_name'] = '';
        }

        $this->_data['last_name']       = $this->validation_model->validate_name( $data['last_name'] );
        $this->_data['customer_phone']  = $this->validation_model->validate_phone( $data['customer_phone'] );
        $this->_data['customer_email']  = $this->validation_model->validate_email( strtolower($data['customer_email']) );
        $this->_data['street_1']        = $this->validation_model->validate_street( $data['street_1'] );

        if (strlen($data['street_2']) > 0) {
            $this->_data['street_2']    = $this->validation_model->validate_street( $data['street_2'] );
        } else {
            $this->_data['street_2'] = '';
        }

        $this->_data['city']            = $this->validation_model->validate_city( $data['city'] );
        $this->_data['state']           = $this->validation_model->validate_state( $data['state'] );
        $this->_data['zip']             = $this->validation_model->validate_zip( $data['zip'] );
        $this->_data['password']        = $this->validation_model->validate_password( $data['password'], $data['re_password'] );

        // If any inputs are not valid, it'll store them in the $_errors array
        foreach($this->_data as $key => $value) {
            if ($value === false) {
                $this->_errors[$key] = $data[$key];
            }
        }
    }
}