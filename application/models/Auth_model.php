<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function get_user_by_email($email) {
        return $this->db->get_where('User', ['Email' => $email])->row();
    }
}