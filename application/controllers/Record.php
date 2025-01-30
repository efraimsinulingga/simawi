<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');        
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('RecordMedic_model');
        $this->load->model('Patient_model');
        $this->load->model('User_model');
        $this->load->model('Doctor_model');
    }

    public function list() {
        $user = $this->RecordMedic_model->get_patient_history();
        $data['user'] = $user;
        $this->load->view('record/record_list', $data);
    }

    public function create() {          
        $patient = $this->Patient_model->get_user();
        $data['patient'] = $patient;
    
        $doctor = $this->Doctor_model->get_user();
        $data['doctor'] = $doctor;

        $this->load->view('record/record_create', $data);
    }

    public function create_post() {        
        $this->form_validation->set_rules('doctor', 'Dokter', 'required');
        $this->form_validation->set_rules('patient', 'Pasien', 'required');        
        $this->form_validation->set_rules('symptoms', 'Gejala', 'required');        
        // Run the form validation
        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('record/create'); 
        }
        else {

            $doctor = $this->input->post('doctor');
            $patient = $this->input->post('patient');
            $admin = $this->session->userdata('user_id');
            $symptoms = $this->input->post('symptoms');                        
            $this->RecordMedic_model->save_user($symptoms, $doctor, $patient, $admin);

            redirect('record');
        }        
    }

    public function edit() {                
        $id = $this->input->get('id');

        $user = $this->Patient_model->check_user_id($id);
        $data['user'] = $user;
        $this->load->view('patient/patient_edit', $data);
    }

    public function edit_post() {        
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('rekam', 'Rekam Medis', 'required');
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('birth', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('blood', 'Golongan Darah', 'required');
        $this->form_validation->set_rules('height', 'Tinggi', 'required');
        $this->form_validation->set_rules('weight', 'Berat', 'required');

        // Run the form validation
        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('patient'); 
        }
        else {
            $id = $this->input->post('id');
            $record = $this->input->post('rekam');
            $name = $this->input->post('name');
            $birth = $this->input->post('birth');
            $nik = $this->input->post('nik');
            $phone = $this->input->post('phone');
            $address = $this->input->post('address');
            $bloodtype = $this->input->post('blood');
            $weight = $this->input->post('weight');
            $height = $this->input->post('height');

            $user = $this->Patient_model->check_user_record($record);

            if($user) {
                $this->session->set_flashdata('errors', "Rekam medis sudah pernah terdaftar");
                redirect('patient/edit'); 
            }     
                        
            $this->Patient_model->update_user($id, $record, $name, $birth, $nik, $phone, $address, $bloodtype, $weight, $height);

            redirect('patient');
        }        
    }

    public function delete() {       
        $this->form_validation->set_rules('id', 'ID', 'required');

        $id = $this->input->get('id');
        $user = $this->Patient_model->delete_user($id);
        
        redirect('patient'); 
    }
}