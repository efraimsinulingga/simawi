<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecordMedic_model extends CI_Model {
    
    public function get_patient_history() {
        $this->db->select('
            PatientHistory.*, 
            Patient.name AS PatientName, 
            Patient.birth AS PatientBirth, 
            (
                SELECT name FROM User WHERE ID = PatientHistory.ConsultationBy LIMIT 1
            ) AS DoctorName,
            (
                SELECT name FROM User WHERE ID = PatientHistory.RegisteredBy LIMIT 1
            ) AS RegisteredName
        ');
        $this->db->from('PatientHistory');
        $this->db->join('Patient', 'Patient.RecordNumber = PatientHistory.RecordNumber', 'left');

        $query = $this->db->get();
        return $query->result_array();

    }

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
        $this->db->from('PatientHistory');
        
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

    public function save_user($symptoms, $doctor, $patient, $admin)
    {
        $data = [
            'recordnumber' => $patient,
            'DateVisit' => date('Y-m-d H:i:s'),
            'ConsultationBy' => $doctor,            
            'RegisteredBy' => $admin,            
            'Symptoms' => $symptoms,            
            'isDone' => 0,            
        ];

        $this->db->insert('PatientHistory', $data);
    }
}
