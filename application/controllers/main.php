<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
 */
class Main extends CI_Controller {

	/**
	 * Displays the main page
	 */
	public function index() {
		$data['title'] = 'Exotic Car Rental';

		$this->load->model('products_model');
		$data['vehicles'] = $this->products_model->get_vehicles_for_dropdown();

		$data['login'] = $this->load->view('login_view', NULL, TRUE);

		$this->load->view('header', $data);
		$this->load->view('main_view', $data);
		$this->load->view('footer');
	}
}