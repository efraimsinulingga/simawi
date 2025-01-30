<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedicalRecord extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');        
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('RecordMedicDoctor_model');
        $this->load->model('Patient_model');
        $this->load->model('User_model');
        $this->load->model('Doctor_model');
    }

    public function list() {
        $user = $this->RecordMedicDoctor_model->get_patient_history();
        $data['user'] = $user;
        $this->load->view('record_medic/record_medic_list', $data);
    }

    public function diagnose() {
        
        $id = $this->input->get('id');

        $user = $this->RecordMedicDoctor_model->get_single_patient_history($id);
        $data['user'] = $user;
        
        $this->load->view('record_medic/record_medic_edit', $data);
    }

    public function create() {          
        $patient = $this->Patient_model->get_user();
        $data['patient'] = $patient;
    
        $doctor = $this->Doctor_model->get_user();
        $data['doctor'] = $doctor;

        $this->load->view('record/record_create', $data);
    }

    public function diagnose_post() {        
        
            $id = $this->input->post('id');
            $kode = $this->input->post('kode');
            $name = $this->input->post('name');
            $diagnose = $this->session->userdata('diagnose');
            $symptoms = $this->input->post('symptoms');                        
            
            $this->RecordMedicDoctor_model->save_user($id, $diagnose, $kode, $name);

            redirect('medical-record');
    }

    public function edit() {                
        $id = $this->input->get('id');

        $user = $this->Patient_model->check_user_id($id);
        $data['user'] = $user;
        $this->load->view('patient/patient_edit', $data);
    }    
}