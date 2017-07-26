<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Products_model
 */
class Products_model extends CI_Model {

    /**
     * Gets a list of vehicles for the drop-down selection
     *
     * @return array
     */
    public function get_vehicles_for_dropdown() {
        $this->db->select('products_id, year, make, model');
        $this->db->from('products');

        // @todo: Maybe add a check here to see if the car is rented

        $query    = $this->db->get();
        $vehicles = array();

        foreach( $query->result() as $row ) {
            $vehicles[] = array(
                "id"    => $row->products_id,
                "year"  => $row->year,
                "make"  => $row->make,
                "model" => $row->model
            );
        }

        return $vehicles;
    }

    /**
     * Gets the specific vehicle by vehicle id
     *
     * @param $vehicle_id
     * @return array|bool
     */
    public function get_vehicle($vehicle_id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('products_id', $vehicle_id);

        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $row = $query->row();

        if (!isset($row)) {
            return false;
        }

        $vehicle = array(
            'year'               => $row->year,
            'make'               => $row->make,
            'model'              => $row->model,
            'engine'             => $row->engine,
            'horsepower'         => $row->horsepower,
            'torque'             => $row->torque,
            'zero_to_sixty_time' => $row->zero_to_sixty_time,
            'quarter_mile_time'  => $row->quarter_mile_time,
            'daily_cost'         => $row->daily_cost
        );

        return $vehicle;
    }

    /**
     * Gets a list of all of the vehicles
     *
     * @return array
     */
    public function get_vehicles() {
        $this->db->select('*');
        $this->db->from('products');

        $query    = $this->db->get();
        $vehicles = array();

        foreach( $query->result() as $row ) {
            $vehicles[] = array(
                "id"          => $row->products_id,
                "year"        => $row->year,
                "make"        => $row->make,
                "model"       => $row->model,
                "daily_cost"  => $row->daily_cost,
                "description" => $row->vehicle_description
            );
        }

        return $vehicles;
    }

    /**
     * Retrieves a list of rentals for the specific customer
     *
     * @param $user_id
     * @return array
     */
    public function get_customer_rentals($user_id) {
        $this->db->select('products_availability.reserved_from, products_availability.reserved_to, products.year, products.make, products.model, customer_orders.total_price_paid_with_taxes');
        $this->db->from('products_availability');
        $this->db->where('products_availability.reserved_by', $user_id);
        $this->db->join('products', 'products_availability.products_id = products.products_id');
        $this->db->join('customer_orders', 'products_availability.customer_orders_id = customer_orders.id');

        $query    = $this->db->get();
        $vehicles = array();

        foreach( $query->result() as $row ) {
            $vehicles[] = array(
                "year"      => $row->year,
                "make"      => $row->make,
                "model"     => $row->model,
                "date_from" => $row->reserved_from,
                "date_to"   => $row->reserved_to,
                "total_paid" => $row->total_price_paid_with_taxes
            );
        }

        return $vehicles;
    }

    /**
     * Retrieves all rentals for all customers
     *
     * @return array
     */
    public function get_all_rentals() {
        $this->db->select('products_availability.reserved_from, products_availability.reserved_to, products.year, products.make, products.model, customer_orders.total_price_paid_with_taxes');
        $this->db->from('products_availability');
        $this->db->join('products', 'products_availability.products_id = products.products_id');
        $this->db->join('customer_orders', 'products_availability.customer_orders_id = customer_orders.id');

        $query    = $this->db->get();
        $vehicles = array();

        foreach( $query->result() as $row ) {
            $vehicles[] = array(
                "year"      => $row->year,
                "make"      => $row->make,
                "model"     => $row->model,
                "date_from" => $row->reserved_from,
                "date_to"   => $row->reserved_to,
                "total_paid" => $row->total_price_paid_with_taxes
            );
        }

        return $vehicles;
    }
}