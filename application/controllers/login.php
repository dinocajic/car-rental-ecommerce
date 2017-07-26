<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 */
class Login extends CI_Controller {

    /**
     * Displays the login page and processes the login form
     */
    public function index() {
        // If the user is logged in, redirect the user to the customer account page
        if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
            header('Location: ' . base_url() . 'customer_account');
            return;
        }

        // Once the user clicks submit, attempt to log him/her in
        if ( isset($_POST['login_submit']) ) {
            $this->load->model('login_model');

            $data['username'] = $_POST['login_email'];
            $data['password'] = $_POST['login_password'];

            if ($this->login_model->attempt_login($data)) {
                if ($_SESSION['access_level'] == 300) {
                    header('Location: ' . base_url() . 'customer_account');
                    return;
                }

                if ($_SESSION['access_level'] == 100) {
                    header('Location: ' . base_url() . 'admin_account');
                    return;
                }
            }

            $data['login_errors'] = true;
        }

        $data['title']         = 'Login';
        $data['display_login'] = true;
        $data['login']         = $this->load->view('login_view', $data, TRUE);

        $this->load->view('header', $data);
        $this->load->view('login_page_view');
        $this->load->view('footer');
    }

    /**
     * Logs the user out
     */
    public function logout() {
        $this->load->model('login_model');
        $this->login_model->logout();
        header('Location: ' . base_url());
    }
}