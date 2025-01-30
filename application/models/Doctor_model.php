<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {
    
    public function get_user()
    {
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where('Role', 'Doctor');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_user($email)
    {
        return $this->db->get_where('User', ['Email' => $email])->row();
    }

    public function check_user_id($id)
    {
        return $this->db->get_where('User', ['ID' => $id])->row();
    }

    public function delete_user($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete('User');
    }

    public function save_user($name, $email, $password)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'createdat' => date('Y-m-d H:i:s'),
            'updatedat' => date('Y-m-d H:i:s'),
            'role' => 'Doctor'
        ];

        $this->db->insert('User', $data);
    }

    public function update_user($id, $name, $email, $password)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'updatedat' => date('Y-m-d H:i:s'),
        ];
    
        $this->db->where('ID', $id);
        return $this->db->update('User', $data); 
    }
}
