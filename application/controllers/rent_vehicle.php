<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Rent_vehicle
 */
class Rent_vehicle extends CI_Controller {

    /**
     * Displays all of the available vehicles
     */
    public function index() {
        $data['title'] = 'Add Vehicle';

        $this->load->model('products_model');
        $data['vehicles']  = $this->products_model->get_vehicles();
        $data['login']     = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('vehicles_for_rent_view', $data);
        $this->load->view('footer');
    }

    /**
     * Displays the vehicle details.
     *
     * @param string $vehicle_id
     */
    public function process_search($vehicle_id = '') {
        $this->index();

        $data = array();

        if ( isset($_POST['search_for_vehicles_submit']) ) {
            $data['product_id'] = $_POST['vehicle'];
            $data['date_from']  = $_POST['date_from'];
            $data['date_to']    = $_POST['date_to'];
        } elseif ( $vehicle_id != '' ) {
            $data['product_id'] = $vehicle_id;
            $data['date_from']  = date('Y-m-d');
            $data['date_to']    = date('Y-m-d', strtotime("+3 days"));
        } else {
            header('Location: ' . base_url());
            return;
        }

        $this->load->model('products_model');
        $data['vehicles']     = $this->products_model->get_vehicle($data['product_id']);
        $data['image_folder'] = base_url() . "assets/images/" .
            strtolower($data['vehicles']['year']) . "_" .
            str_replace(" ", "_", strtolower($data['vehicles']['make'])) . "_" .
            strtolower($data['vehicles']['model']);

        $this->load->view('rent_vehicle_view', $data);
    }
}