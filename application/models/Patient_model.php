<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {
    
    public function get_total()
    {
        $this->db->select('COUNT(ID) AS total');
        $this->db->from('Patient');
        
        $query = $this->db->get();
        return $query->row()->total; 
    }

    public function get_total_month()
    {
        $this->db->select('COUNT(ID) AS total');
        $this->db->from('Patient');
        $this->db->where('MONTH(createdat)', date('m'));
        $this->db->where('YEAR(createdat)', date('Y'));        
        
        $query = $this->db->get();
        return $query->row()->total; 
    }

    public function get_user()
    {
        $this->db->select('*');
        $this->db->from('Patient');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_month()
    {
        $this->db->select('*');
        $this->db->from('Patient');
        $this->db->where('MONTH(createdat)', date('m'));
        $this->db->where('YEAR(createdat)', date('Y'));        
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_user_id($id)
    {
        return $this->db->get_where('Patient', ['ID' => $id])->row();
    }

    public function check_user_record($record)
    {
        return $this->db->get_where('Patient', ['RecordNumber' => $record3])->row();
    }

    public function delete_user($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete('Patient');
    }

    public function save_user($record, $name, $birth, $nik, $phone, $address, $bloodtype, $weight, $height)
    {
        $data = [
            'recordnumber' => $record,
            'name' => $name,            
            'birth' => $birth,
            'nik' => $nik,
            'phone' => $phone,
            'address' => $address,
            'bloodtype' => $bloodtype,
            'weight' => $weight,
            'height' => $height,            
            'createdat' => date('Y-m-d H:i:s'),
            'updatedat' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('Patient', $data);
    }

    public function update_user($id, $record, $name, $birth, $nik, $phone, $address, $bloodtype, $weight, $height)
    {
        $data = [
            'recordnumber' => $record,
            'name' => $name,            
            'birth' => $birth,
            'nik' => $nik,
            'phone' => $phone,
            'address' => $address,
            'bloodtype' => $bloodtype,
            'weight' => $weight,
            'height' => $height,            
            'updatedat' => date('Y-m-d H:i:s'),
        ];
    
        $this->db->where('ID', $id);
        return $this->db->update('Patient', $data); 
    }
}
