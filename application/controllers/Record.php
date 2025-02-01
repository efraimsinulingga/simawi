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

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'Admin') {            
            $this->session->set_flashdata('errors', "Maaf! Anda tidak dapat mengakses halaman ini");
            redirect('/');
        }
    }

    public function list() {
        if($this->input->get('is_done')) {
            $isDone = $this->input->get('is_done');
        } else {
            $isDone = '0';
        }
        if($this->input->get('date')) {
            $date = $this->input->get('date');
        } else {
            $date = date('Y-m-d');
        }
        
        if($this->input->get('q')) {
            $q = $this->input->get('q');
        } else {
            $q=null;
        }

        $user = $this->RecordMedic_model->get_patient_history($isDone, $date, $q);
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
            $this->RecordMedic_model->save($doctor, $patient, $admin);

            $this->session->set_flashdata('success', "Data pendaftaran berhasil");
            redirect('record');
        }        
    }

    public function edit() {                
        $id = $this->input->get('id');

        $record = $this->RecordMedic_model->get_record_id($id);

        if(!$record) {

        }
        if($record->isDone == 1) {
            $this->session->set_flashdata('errors', 'Mohon maaf, data riwayat pasien ini sudah selesai.');
            redirect('record');
        }

        $data['record'] = $record;

        $patient = $this->Patient_model->get_user();
        $data['patient'] = $patient;
    
        $doctor = $this->Doctor_model->get_user();
        $data['doctor'] = $doctor;

        $this->load->view('record/record_edit', $data);
    }

    public function edit_post() {        
        $this->form_validation->set_rules('doctor', 'Dokter', 'required');
        $this->form_validation->set_rules('patient', 'Pasien', 'required');        
        $this->form_validation->set_rules('id', 'ID', 'required');
        // Run the form validation

        $id = $this->input->post('id');

        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('record/edit?id='.$id); 
        }
        else {            
            $doctor = $this->input->post('doctor');
            $patient = $this->input->post('patient');                      
            $this->RecordMedic_model->update($doctor, $patient, $id);

            $this->session->set_flashdata('success', "Data pendaftaran telah diupdate");
            redirect('record');
        }       
    }

    public function delete() {       
        $this->form_validation->set_rules('id', 'ID', 'required');
        $id = $this->input->get('id');
        $data = $this->RecordMedic_model->get_record_id($id);

        if($data->isDone) {
            $this->session->set_flashdata('errors', "Data pendaftaran tidak dapat dihapus");
            redirect('record');     
        }

        $user = $this->RecordMedic_model->delete($id);
        
        $this->session->set_flashdata('success', "Data pendaftaran telah dihapus");
        redirect('record'); 
    }
}