<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Admin_account
 */
class Admin_account extends CI_Controller {

    /**
     * Displays the administrative account when an administrator logs in
     */
    public function index() {
        // If the user is not logged in, redirect him/her back to login page
        if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['access_level'] != 100) {
            header('Location: ' . base_url() . 'login');
            return;
        }

        $data['title'] = 'Administrative Account';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);
        $this->load->view('header', $data);
        $this->load->view('admin_account_view');
        $this->load->view('footer');
    }

    /**
     * Allows an administrator to review sales history
     */
    public function view_sales_history() {
        // If the user is not logged in, redirect him/her back to login page
        if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['access_level'] != 100) {
            header('Location: ' . base_url() . 'login');
            return;
        }

        $this->load->model('products_model');
        $data['rentals'] = $this->products_model->get_all_rentals();

        $data['title'] = 'Customer Account';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('view_sales_history_view', $data);
        $this->load->view('footer');
    }
}