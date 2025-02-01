<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecordMedicDoctor_model extends CI_Model {
    
    public function get_patient_history($isDone, $date, $q) {
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
        $this->db->where('PatientHistory.isDone', $isDone);
        $this->db->where('DATE(PatientHistory.DateVisit)', $date);
        if ($q != null) {
            $this->db->group_start();
            $this->db->like('Patient.name', $q);
            $this->db->or_like('Patient.RecordNumber', $q);
            $this->db->group_end();
        }
    
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_single_patient_history($id) {
        $this->db->select('
            PatientHistory.*, 
            Patient.name AS PatientName, 
            Patient.birth AS PatientBirth,
            Patient.height AS PatientHeight,
            Patient.weight AS PatientWeight, 
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
        
    public function get_user()
    {
        $this->db->select('*');
        $this->db->from('PatientHistory');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function save($id, $diagnose, $kode, $name, $symptoms)
    {
        $data = [
            'DoctorDiagnose' => $diagnose,
            'ICD10Code' => $kode,            
            'ICD10Name' => $name,            
            'Symptoms' => $symptoms,
            'isDone' => 1,            
        ];

        $this->db->where('ID', $id);
        return $this->db->update('PatientHistory', $data); 
    }
}
