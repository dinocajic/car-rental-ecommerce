<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class About
 */
class About extends CI_Controller {

    /**
     * Displays the About Page
     */
    public function index() {
        $data['title'] = 'About';
        $data['login'] = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('about_view', $data);
        $this->load->view('footer');
    }
}