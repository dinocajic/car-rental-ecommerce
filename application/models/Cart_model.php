<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Cart_model
 */
class Cart_model extends CI_Model {

    /**
     * Initializes the necessary cart sessions
     */
    public function initialize_cart_session() {
        if ( !isset($_SESSION['cart_items']) ) {
            $_SESSION['cart_items'] = array();
        }

        if ( !isset($_SESSION['cart_total']) ) {
            $_SESSION['cart_total'] = 0;
        }

        if ( !isset($_SESSION['first_name']) ) {
            $_SESSION['first_name'] = '';
        }

        if ( !isset($_SESSION['last_name']) ) {
            $_SESSION['last_name'] = '';
        }

        if ( !isset($_SESSION['username']) ) {
            $_SESSION['username'] = '';
        }

        if ( !isset($_SESSION['phone']) ) {
            $_SESSION['phone'] = '';
        }

        if ( !isset($_SESSION['cart_shipping']) ) {
            $_SESSION['cart_shipping'] = array(
                'street' => '',
                'city'   => '',
                'state'  => '',
                'zip'    => ''
            );
        }
    }

    /**
     * Adds items to the cart sessions.
     *
     * @param $data
     */
    public function add_items_to_session($data) {
        $date_from = new DateTime($data['date_from']);
        $date_to   = new DateTime($data['date_to']);

        $days = $date_to->diff($date_from)->format("%a");
        $days = (int)$days;

        $total_cost = $data['daily_cost'] * $days;

        $_SESSION['cart_items'][ $data['product_id'] ] = array(
            'date_from' => $data['date_from'],
            'date_to'   => $data['date_to'],
            'total'     => $total_cost,
            'days'      => $days
        );
    }

    /**
     * Updates the cart total cost
     */
    public function update_total_cost() {
        $_SESSION['cart_total'] = 0;

        foreach($_SESSION['cart_items'] as $cart_item) {
            $_SESSION['cart_total'] += $cart_item['total'];
        }
    }

    /**
     * Grabs all of the vehicle details from the products table for each item in the cart
     *
     * @return array
     */
    public function get_cart_items() {
        $this->load->model('products_model');

        foreach($_SESSION['cart_items'] as $product_id => $cart_item) {
            $_SESSION['cart_items'][$product_id]['vehicle_details'] = $this->products_model->get_vehicle($product_id);
        }
    }

    /**
     * Removes the item from the cart
     *
     * @param $product_id
     */
    public function remove_from_cart($product_id) {
        unset($_SESSION['cart_items'][$product_id]);
    }

    /**
     * Checks the availability of a vehicle between two dates
     *
     * @param $product_id
     * @param $date_from
     * @param $date_to
     *
     * @return array|bool|string
     */
    public function check_if_available($product_id, $date_from, $date_to) {
        $this->db->select('reserved_from, reserved_to');
        $this->db->from('products_availability');

        $product_id = (int)$product_id;

        $from_date = 'products_id = "' . $product_id . '" and reserved_from BETWEEN "' . date('Y-m-d H:i:s', strtotime($date_from)) . '" and "' . date('Y-m-d H:i:s', strtotime($date_to)) . '"';
        $to_date   = 'products_id = "' . $product_id . '" and reserved_to BETWEEN "'   . date('Y-m-d H:i:s', strtotime($date_from)) . '" and "' . date('Y-m-d H:i:s', strtotime($date_to)) . '"';

        $this->db->where($from_date);
        $this->db->or_where($to_date);

        $query    = $this->db->get();

        if (!$query) {
            return "Error has occurred.";
        }

        $date_occupied = array();

        foreach( $query->result() as $row ) {
            $date_occupied[] = array(
                "reserved_from" => $row->reserved_from,
                "reserved_to"   => $row->reserved_to
            );
        }

        return $date_occupied;
    }

    /**
     * Retrieves the available credit card types
     *
     * @return array|bool
     */
    public function get_credit_cards() {
        $this->db->select('*');
        $this->db->from('customer_payment_credit_card_third_party_vendors');
        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $cards = array();

        foreach( $query->result() as $row ) {
            $cards[] = array(
                "card_id"   => $row->customer_payment_credit_card_third_party_vendors_id,
                "card_name" => $row->cc_third_party_vendor_name
            );
        }

        return $cards;
    }

    /**
     * Inserts the order into the database
     *
     * @param $data
     */
    public function insert_order($data) {
        $this->load->model('customer_model');

        // Convert all of the input into column names of specific tables in the database
        $customer = array();
        $customer['first_name']     = $data['shipping_first_name'];
        $customer['middle_name']    = '';
        $customer['last_name']      = $data['shipping_last_name'];
        $customer['customer_phone'] = $data['shipping_phone'];
        $customer['customer_email'] = $data['shipping_email'];

        $customer_add['street_1']   = $data['shipping_street'];
        $customer_add['street_2']   = '';
        $customer_add['city']       = $data['shipping_city'];
        $customer_add['state']      = $data['shipping_state'];
        $customer_add['zip']        = $data['shipping_zip'];
        $customer_add['password']   = $data['password'];

        // if customer exists, update customer details
        if ( $this->customer_model->check_if_customer_exists( $data['shipping_email'] ) ) {
            $this->customer_model->update_customer_details( $customer );
        } else {
            // add customer to database if he/she doesn't exist
            $customer = array_merge($customer, $customer_add);
            $this->customer_model->add_customer($customer);
        }

        $customer_id = $this->customer_model->get_customer_id( $customer['customer_email'] );
        $address_id  = $this->customer_model->check_if_address_exists( $customer_add );

        if ( $address_id ) {
            $address_id  = (array)$address_id;
            $address_id  = (int)$address_id['id'];
        } else {
            $address_id  = $this->customer_model->add_address( $customer_add );
            $this->customer_model->link_customer_to_new_address( $customer_id, $address_id );
        }

        $billing_address['street_1'] = $data['billing_street'];
        $billing_address['street_2'] = '';
        $billing_address['city']     = $data['billing_city'];
        $billing_address['state']    = $data['billing_state'];
        $billing_address['zip']      = $data['billing_zip'];

        $billing_address_id = $this->customer_model->check_if_address_exists( $billing_address );

        if ( $billing_address_id ) {
            // Get billing address id if address already exists
            $billing_address_id = (array)$billing_address_id;
            $billing_address_id = (int)$billing_address_id['id'];
        } else {
            // if billing address doesn't exist, insert billing address and get billing address id
            $billing_address_id  = $this->customer_model->add_address( $billing_address );
        }

        // Add credit card payment to customer_payment_credit_card
        $cc['card_number']     = $data['card_number'];
        $cc['card_security']   = $data['cvv'];
        $cc['card_exp_month']  = $data['expiration_month'];
        $cc['card_exp_year']   = $data['expiration_year'];
        $cc['card_type_id']    = $data['card_type'];
        $cc['card_first_name'] = $data['billing_first_name'];
        $cc['card_last_name']  = $data['billing_last_name'];
        $cc['customers_id']    = $customer_id;
        $cc['card_billing_address_id'] = $billing_address_id;

        $this->db->insert('customer_payment_credit_card', $cc);
        $cc_insert_id = $this->db->insert_id();

        foreach($_SESSION['cart_items'] as $product_id => $cart_item) {
            // Add all of the items to the order
            $order['customer_id']                 = $customer_id;
            $order['products_id']                 = $product_id;
            $order['order_status_id']             = 1;
            $order['date_order_placed']           = date('Y-m-d H:i:s');
            $order['date_order_paid']             = date('Y-m-d H:i:s');
            $taxes = number_format(($cart_item['total'] * .07), 2, '.', '');
            $taxes = (float)$taxes;
            $order['total_price_paid_with_taxes'] = $cart_item['total'] + $taxes;
            $order['total_taxes_paid']            = $taxes;
            $order['customer_payment_id']         = $cc_insert_id;

            $this->db->insert('customer_orders', $order);
            $order_id = $this->db->insert_id();

            // Set item as unavailable for the specified dates
            $avail['products_id']        = $product_id;
            $avail['reserved_from']      = date("Y-m-d H:i:s", strtotime($cart_item['date_from']));
            $avail['reserved_to']        = date("Y-m-d H:i:s", strtotime($cart_item['date_to']));
            $avail['reserved_by']        = $customer_id;
            $avail['customer_orders_id'] = $order_id;

            $this->db->insert('products_availability', $avail);
        }
    }
}