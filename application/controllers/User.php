<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->load->model('User_model');
        // Load login view
        $user = $this->User_model->get_user();
        $data['user'] = $user;
        $this->load->view('user/user_list', $data);
    }

    public function create() {                
        $this->load->view('user/user_create');
    }

    public function create_post() {        
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password Default', 'required|min_length[6]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/]');

        // Run the form validation
        if ($this->form_validation->run() === FALSE)
        {            
            $this->session->set_flashdata('errors', validation_errors());
            redirect('user/create'); 
        }
        else {
            $this->load->model('User_model');

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->check_user($email);

            if($user) {
                $this->session->set_flashdata('errors', "Email sudah pernah terdaftar");
                redirect('user/create'); 
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
            $this->User_model->save_user($name, $email, $hashed_password);

            $this->session->set_flashdata('success', "Data user berhasil disimpan");
            redirect('user');
        }        
    }

    public function edit() {                
        $this->load->model('User_model');         
        $id = $this->input->get('id');

        $user = $this->User_model->check_user_id($id);
        $data['user'] = $user;
        $this->load->view('user/user_edit', $data);
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
            redirect('user/edit?id='.$this->input->post('id')); 
        }
        else {
            $this->load->model('User_model');

            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $hashed_password = null;
            if($this->input->post('password') !== null) {
                $password = $this->input->post('password');            
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }             
                        
            $this->User_model->update_user($id, $name, $email, $hashed_password);
            
            $this->session->set_flashdata('success', "Data user berhasil diupdate");
            redirect('user');
        }        
    }

    public function delete() {       
        $this->load->model('User_model');         
        $this->form_validation->set_rules('id', 'ID', 'required');

        $id = $this->input->get('id');
        $user = $this->User_model->delete_user($id);
        
        $this->session->set_flashdata('success', "Data user telah dihapus");
        redirect('user'); 
    }
}