<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');        
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Patient_model');
        $this->load->model('User_model');
    }

    public function list() {
        $user = $this->Patient_model->get_user();
        $data['user'] = $user;
        $this->load->view('patient/patient_list', $data);
    }

    public function create() {                
        $this->load->view('patient/patient_create');
    }

    public function create_post() {        
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
            redirect('patient/create'); 
        }
        else {

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
                redirect('patient/create'); 
            }     
                        
            $this->Patient_model->save_user($record, $name, $birth, $nik, $phone, $address, $bloodtype, $weight, $height);

            redirect('patient');
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