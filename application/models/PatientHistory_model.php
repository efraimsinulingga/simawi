<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PatientHistory_model extends CI_Model {
    
    public function get_most_cases()
    {
        $this->db->select('ICD10Name, ICD10Code, COUNT(ICD10Code) AS total');
        $this->db->from('PatientHistory');
        $this->db->group_by('ICD10Code');
        $this->db->group_by('ICD10Name');
        $this->db->order_by('total', 'DESC');
        $this->db->where('ICD10Name !=', NULL); 
        $this->db->where('ICD10Name !=', ''); 
        $this->db->limit(5);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
