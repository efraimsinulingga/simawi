<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecordMedic_model extends CI_Model {
    
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

    public function get_user()
    {
        $this->db->select('*');
        $this->db->from('PatientHistory');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_record_id($id)
    {
        return $this->db->get_where('PatientHistory', ['ID' => $id])->row();
    }

    public function delete($id)
    {
        $this->db->where('ID', $id);
        return $this->db->delete('PatientHistory');
    }

    public function save($doctor, $patient, $admin)
    {
        $data = [
            'recordnumber' => $patient,
            'DateVisit' => date('Y-m-d H:i:s'),
            'ConsultationBy' => $doctor,            
            'RegisteredBy' => $admin,                
            'isDone' => 0,            
        ];

        $this->db->insert('PatientHistory', $data);
    }

    public function update($doctor, $patient, $id)
    {
        $data = [
            'recordnumber' => $patient,
            'DateVisit' => date('Y-m-d H:i:s'),
            'ConsultationBy' => $doctor,            
            'isDone' => 0,            
        ];

        $this->db->where('ID', $id);
        return $this->db->update('PatientHistory', $data); 
    }
}
