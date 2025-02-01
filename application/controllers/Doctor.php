<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');        
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'Admin') {            
            $this->session->set_flashdata('errors', "Maaf! Anda tidak dapat mengakses halaman ini");
            redirect('/');
        }
    }

    public function list() {        
        $this->load->model('Doctor_model');
        // Load login view
        $user = $this->Doctor_model->get_user();
        $data['user'] = $user;
        $this->load->view('doctor/doctor_list', $data);
    }

    public function create() {                
        $this->load->view('doctor/doctor_create');
    }

    public function create_post() {        
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password Default', 'required|min_length[6]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/]');

        // Run the form validation
        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('doctor/create'); 
        }
        else {
            $this->load->model('Doctor_model');

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Doctor_model->check_user($email);

            if($user) {
                $this->session->set_flashdata('errors', "Email sudah pernah terdaftar");
                redirect('doctor/create'); 
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
            $this->Doctor_model->save_user($name, $email, $hashed_password);

            $this->session->set_flashdata('success', "Data dokter berhasil disimpan");
            redirect('doctor');
        }        
    }

    public function edit() {                
        $this->load->model('Doctor_model');         
        $id = $this->input->get('id');

        $user = $this->Doctor_model->check_user_id($id);
        $data['user'] = $user;
        $this->load->view('doctor/doctor_edit', $data);
    }

    public function edit_post() {        
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if($this->input->post('password') != null) {
            $this->form_validation->set_rules('password', 'Password Default', 'required|min_length[6]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/]');
        }

        // Run the form validation
        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('doctor/edit?id='.$this->input->post('id')); 
        }
        else {
            $this->load->model('Doctor_model');

            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            
            $hashed_password = null;
            if($this->input->post('password') !== null) {
                $password = $this->input->post('password');            
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }  
                        
            $this->Doctor_model->update_user($id, $name, $email, $hashed_password);

            $this->session->set_flashdata('success', "Data dokter berhasil diupdate");
            redirect('doctor');
        }        
    }

    public function delete() {       
        $this->load->model('Doctor_model');         
        $this->form_validation->set_rules('id', 'ID', 'required');

        $id = $this->input->get('id');
        $user = $this->Doctor_model->delete_user($id);
        
        $this->session->set_flashdata('success', "Data dokter telah dihapus");
        redirect('doctor'); 
    }
}