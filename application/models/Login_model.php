<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login_model
 */
class Login_model extends CI_Model {

    /**
     * Attempts to log the user in. If successful, a number of sessions are set.
     *
     * @param $user_data
     * @return bool
     */
    public function attempt_login($user_data) {
        $username = strtolower($user_data['username']);
        $password = $user_data['password'];

        $this->db->select('customers.id, customers.customer_phone, customers.first_name, customers.last_name, users.password, users.access_level');
        $this->db->from('customers');
        $this->db->join('users', 'users.customer_id = customers.id', 'left');
        $this->db->where('customers.customer_email', $username);
        $this->db->where('users.active', 1);

        $query = $this->db->get();

        if (!$query) {
            return false;
        }

        $row = $query->row();

        if (!isset($row)) {
            return false;
        }

        if(password_verify($password, $row->password)) {
            $_SESSION['logged_in']    = true;
            $_SESSION['customer_id']  = $row->id;
            $_SESSION['username']     = $username;
            $_SESSION['phone']        = $row->customer_phone;
            $_SESSION['access_level'] = $row->access_level;
            $_SESSION['first_name']   = $row->first_name;
            $_SESSION['last_name']    = $row->last_name;

            return true;
        }

        return false;
    }

    /**
     * Updates the user's password
     *
     * @param $data
     */
    public function update_password( $data ) {
        $this->db->where('customer_id', $data['customer_id']);
        $this->db->update('users', $data);
    }

    /**
     * Logs the user out
     */
    public function logout() {
        session_destroy();
    }
}