<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecordMedicDoctor_model extends CI_Model {
    
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

        $doctor = $this->session->userdata('user_id');

        $this->db->where('PatientHistory.ConsultationBy', $doctor);
        $this->db->where('PatientHistory.isDone', 0);

        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_single_patient_history($id) {
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
    
        $doctor = $this->session->userdata('user_id');
            
        $this->db->where('PatientHistory.ConsultationBy', $doctor);
        $this->db->where('PatientHistory.ID', $id);
    
        
        $query = $this->db->get();
    
        
        return $query->row();
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

    public function save_user($id, $diagnose, $kode, $name)
    {
        $data = [
            'DoctorDiagnose' => $diagnose,
            'ICD10Code' => $kode,            
            'ICD10Name' => $name,            
            'isDone' => 1,            
        ];

        $this->db->where('ID', $id);
        return $this->db->update('PatientHistory', $data); 
    }
}
