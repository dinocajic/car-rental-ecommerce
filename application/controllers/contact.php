<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Contact
 */
class Contact extends CI_Controller {

    /**
     * Displays the contact page
     */
    public function index() {
        $data['title'] = 'Contact';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('contact_view', $data);
        $this->load->view('footer');
    }
}