<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Customer_model
 */
class Customer_model extends CI_Model {

    /**
     * Adds the customer to the database
     *
     * @param $customer_details
     * @return bool
     */
    public function add_customer($customer_details) {
        if ($this->check_if_customer_exists($customer_details['customer_email'])) {
            return false;
        }

        // Add to customers table
        $data = array(
            'first_name'     => $customer_details['first_name'],
            'middle_name'    => $customer_details['middle_name'],
            'last_name'      => $customer_details['last_name'],
            'customer_phone' => $customer_details['customer_phone'],
            'customer_email' => $customer_details['customer_email']
        );

        $this->db->insert('customers', $data);
        $customer_insert_id = $this->db->insert_id(); // get the last insert id

        // Add to addresses table
        $address_insert_id = $this->check_if_address_exists($customer_details);

        if (!$address_insert_id) {
            $data = array(
                'street_1' => $customer_details['street_1'],
                'street_2' => $customer_details['street_2'],
                'city'     => $customer_details['city'],
                'state'    => $customer_details['state'],
                'zip'      => $customer_details['zip']
            );

            $this->db->insert('addresses', $data);
            $address_insert_id = $this->db->insert_id();
        }

        $joined = date('Y-m-d H:i:s');

        // Link address to customer
        $data = array(
            'customer_id' => $customer_insert_id,
            'address_id'  => $address_insert_id,
            'date_from'   => $joined
        );

        $this->db->insert('customer_addresses', $data);

        $data = array(
            'customer_id'  => $customer_insert_id,
            'access_level' => 300,
            'password'     => $customer_details['password'],
            'joined'       => $joined,
            'active'       => 1
        );

        $this->db->insert('users', $data);

        return true;
    }

    /**
     * Updates the customers table
     *
     * @param $data
     */
    public function update_customer_details($data) {
        $this->db->where('customer_email', $data['customer_email']);
        $this->db->update('customers', $data);
    }

    /**
     * Retrieves customer information by user id
     *
     * @param $user_id
     * @return bool|array
     */
    public function get_customer_details($user_id) {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('id', $user_id);

        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $row = $query->row();

        if (!isset($row)) {
            return false;
        }

        $data['first_name']     = $row->first_name;
        $data['middle_name']    = $row->middle_name;
        $data['last_name']      = $row->last_name;
        $data['customer_phone'] = $row->customer_phone;
        $data['customer_email'] = $row->customer_email;

        $data['address'] = $this->get_customer_address($user_id);
        return $data;
    }

    /**
     * Retrieves a specific customer's address
     *
     * @param $user_id
     * @return array|bool
     */
    public function get_customer_address($user_id) {
        $this->db->select("addresses.street_1, addresses.street_2, addresses.city, addresses.state, addresses.zip");
        $this->db->from("addresses");
        $this->db->join('customer_addresses', 'customer_addresses.address_id = addresses.id', 'left');
        $this->db->where('customer_addresses.customer_id', $user_id);
        $this->db->order_by('customer_addresses.id', 'desc');
        $this->db->limit(1);
        // order by and last item

        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $row = $query->row();

        if (!isset($row)) {
            return false;
        }

        $address = array(
            "street_1" => $row->street_1,
            "street_2" => $row->street_2,
            "city"     => $row->city,
            "state"    => $row->state,
            "zip"      => $row->zip
        );

        return $address;
    }

    /**
     * Checks to see if the customer's email exists
     *
     * @param $customer_email
     *
     * @return bool
     */
    public function check_if_customer_exists($customer_email) {
        $this->db->select('id');
        $this->db->where('customer_email', $customer_email);
        $this->db->from('customers');

        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    /**
     * Checks to see if the address exists in the addresses table
     *
     * @param $customer_address
     *
     * @return bool|mixed
     */
    public function check_if_address_exists($customer_address) {
        $this->db->select('id');
        $this->db->where('street_1', $customer_address['street_1']);
        $this->db->where('street_2', $customer_address['street_2']);
        $this->db->where('city',     $customer_address['city']);
        $this->db->where('state',    $customer_address['state']);
        $this->db->where('zip',      $customer_address['zip']);
        $this->db->from('addresses');

        $query = $this->db->get();

        if (is_null($query->row())) {
            return false;
        }

        return $query->row();
    }

    /**
     * Get's the customer's id by email address
     *
     * @param $username
     * @return int|bool
     */
    public function get_customer_id($username) {
        $this->db->select("id");
        $this->db->from("customers");
        $this->db->where('customer_email', $username);

        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $row = $query->row();

        if (!isset($row)) {
            return false;
        }

        return $row->id;
    }

    /**
     * Adds address to database
     *
     * @param $address
     * @return mixed
     */
    public function add_address($address) {
        $this->db->insert('addresses', $address);

        return $this->db->insert_id();
    }

    /**
     * Links the specific customer to an address
     *
     * @param $customer_id
     * @param $address_id
     */
    public function link_customer_to_new_address($customer_id, $address_id) {
        $this->unlink_customer_from_old_address($customer_id);

        $joined = date('Y-m-d H:i:s');

        // Link address to customer
        $data = array(
            'customer_id' => $customer_id,
            'address_id'  => $address_id,
            'date_from'   => $joined
        );

        $this->db->insert('customer_addresses', $data);
    }

    /**
     * Sets the old addresses to current date
     *
     * @param $customer_id
     */
    public function unlink_customer_from_old_address($customer_id) {
        $data['date_to']  = date('Y-m-d H:i:s');

        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer_addresses', $data);
    }
}