<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Validation_model
 */
class Validation_model extends CI_Model {

    /**
     * Checks to see if the email is correct. If it is, it'll return a string, otherwise false.
     *
     * @param $email
     *
     * @return mixed
     */
    public function validate_email($email) {
        $email = strtolower($email);

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Checks to see if the name of a person is valid or not. If valid, returns the name,
     * otherwise it returns false.
     *
     * @param $name
     *
     * @return bool
     */
    public function validate_name($name) {
        if (is_string($name) && strlen($name) > 0) {
            return $name;
        }

        return false;
    }

    /**
     * Checks to see if a valid phone number was entered. If it was, it cleans it up and returns
     * the digits only. Otherwise, it returns false;
     *
     * @param $phone_number
     *
     * @return bool|mixed
     */
    public function validate_phone($phone_number) {
        $clean_phone = preg_replace("/[^0-9]/", '', $phone_number);

        if (strlen($clean_phone) == 11) {
            $clean_phone = preg_replace("/^1/", '', $clean_phone);
        }

        if (strlen($clean_phone) == 10) {
            return $clean_phone;
        }

        return false;
    }

    /**
     * Validates the street address. If valid, returns the street address, otherwise returns false;
     *
     * @param $street_address
     *
     * @return bool
     */
    public function validate_street($street_address) {
        $check_pattern = '/\d+ [0-9a-zA-Z ]+/';

        if (preg_match($check_pattern, $street_address)) {
            return $street_address;
        }

        return false;
    }

    /**
     * Checks to see if city input is valid. If it is, it returns the city, otherwise it returns false.
     *
     * @param $city
     *
     * @return mixed
     */
    public function validate_city($city) {
        if (is_string($city) && strlen($city) > 0) {
            return $city;
        }

        return false;
    }

    /**
     * Checks to see if the state is valid. An array of states is located in the Form_library.php file.
     * If it exists, it returns the state, otherwise it returns false.
     *
     * @param $state
     *
     * @return mixed
     */
    public function validate_state($state) {
        $this->load->library('form_library');
        $states = $this->form_library->get_states();

        if (array_key_exists($state, $states)) {
            return $state;
        }

        return false;
    }

    /**
     * Checks to see if the zip code is either in the format 00000 or 00000-0000. We store the 5 digit
     * zip code only so the first five numbers are returned if valid. Otherwise, false is returned.
     *
     * @param $zip_code
     *
     * @return bool|string
     */
    public function validate_zip($zip_code) {
        if(preg_match("/^([0-9]{5})(-[0-9]{4})?$/i", $zip_code)) {
            return substr($zip_code, 0, 5);
        }

        return false;
    }

    /**
     * Checks to make sure that the passwords entered match and that the password entered is at least
     * 5 characters in length. If it's not, it returns false, otherwise it returns the password.
     *
     * @param $password
     * @param $password_repeat
     *
     * @return bool
     */
    public function validate_password($password, $password_repeat) {
        if ($password !== $password_repeat) {
            return false;
        }

        if (strlen($password) < 5) {
            return false;
        }

        $options = array("cost"=>4);
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        return $hashPassword;
    }

    /**
     * Checks the credit card number
     *
     * @param $number
     * @return bool
     */
    public function luhn_check($number) {
        if (strlen($number) < 15) {
            return false;
        }

        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number = preg_replace('/\D/', '', $number);

        // Set the string length and parity
        $number_length = strlen($number);
        $parity = $number_length % 2;

        // Loop through each digit and do the math
        $total = 0;

        for ($i = 0; $i < $number_length; $i++) {
            $digit = $number[$i];

            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit *= 2;

                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            // Total up the digits
            $total += $digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return ($total % 10 == 0) ? true : false;
    }

    /**
     * Validates the CVV of a Credit Card
     *
     * @param $cvv
     * @return bool
     */
    public function validate_cvv($cvv) {
        if(preg_match("/^([0-9]{3})([0-9]{4})?$/i", $cvv)) {
            return $cvv;
        }

        return false;
    }
}