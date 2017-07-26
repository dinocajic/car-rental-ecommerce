<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Customer_account
 */
class Customer_account extends CI_Controller {

    /**
     * Displays the customer account page after a customer logs in
     */
    public function index() {
        // If the user is not logged in, redirect him/her back to login page
        if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . base_url() . 'login');
            return;
        }

        $data['title'] = 'Customer Account';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);
        $this->load->view('header', $data);
        $this->load->view('customer_account_view');
        $this->load->view('footer');
    }

    /**
     * Allows the customer to review their rental history
     */
    public function view_rental_history() {
        // If the user is not logged in, redirect him/her back to login page
        if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . base_url() . 'login');
            return;
        }

        $this->load->model('products_model');
        $data['rentals'] = $this->products_model->get_customer_rentals( $_SESSION['customer_id'] );

        $data['title'] = 'Customer Account';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('view_rental_history_view', $data);
        $this->load->view('footer');
    }
}