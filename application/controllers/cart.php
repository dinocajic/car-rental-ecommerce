<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Cart
 */
class Cart extends CI_Controller {

    /**
     * Displays the cart page with all of the product information added. If the customer is redirected here after pushing
     * the add to cart button, the availability of the vehicle is checked. If the vehicle is available, the items
     * are added to the cart. Otherwise, an error displaying that the vehicle could not be added is displayed.
     */
    public function index() {
        $this->load->model('cart_model');
        $this->cart_model->initialize_cart_session();

        if ( isset($_POST['add_to_cart']) ) {
            $data['product_id'] = $_POST['product_id'];
            $data['date_from']  = $_POST['date_from'];
            $data['date_to']    = $_POST['date_to'];
            $data['daily_cost'] = $_POST['daily_cost'];

            $data['availability'] = $this->cart_model->check_if_available( $data['product_id'], $data['date_from'], $data['date_to'] );

            if ( !empty($data['availability']) ) {
                $data['error'] = 'The vehicle you tried to add is not available for the selected days: <br />';

                foreach($data['availability'] as $value) {
                    $data['error'] .= " -  From: " . date('Y-m-d', strtotime($value['reserved_from'])) . "<br />";
                    $data['error'] .= " -  To: " . date('Y-m-d', strtotime($value['reserved_to'])) . "<br />";
                }

            } else {
                $this->cart_model->add_items_to_session($data);
                $this->cart_model->update_total_cost();
                $data['cart_items'] = $this->cart_model->get_cart_items();
            }
        }

        $data['title']         = 'Cart';
        $data['login']         = $this->load->view('login_view', NULL, TRUE);

        $this->load->view('header', $data);
        $this->load->view('cart_view', $data);
        $this->load->view('footer');
    }

    /**
     * Removes a product from the cart
     *
     * @param $product_id
     */
    public function remove($product_id) {
        $this->load->model('cart_model');
        $this->cart_model->remove_from_cart($product_id);
        $this->cart_model->update_total_cost();
        header('Location: ' . base_url() . 'cart');
    }
}