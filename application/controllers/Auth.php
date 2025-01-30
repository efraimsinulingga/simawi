<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        // Check if user is already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('/');
        }

        // Load login view
        $this->load->view('auth/login');
    }

    public function do_login() {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true); 
        $this->load->library('form_validation'); 

        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/]');

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array(); 

            $res = array(
                'code' => '02',
                'message' => 'Validasi form gagal',
                'data' => $errors
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
            return;
        }

        $email = $data['email']; 
        $password = $data['password'];

        $user = $this->Auth_model->get_user_by_email($email);     

        if ($user && password_verify($password, $user->Password)) {
            // Set session data
            $session_data = [
                'user_id' => $user->ID,
                'name' => $user->Name,
                'email' => $user->Email,
                'role' => $user->Role,
                'logged_in' => TRUE,
            ];
            $this->session->set_userdata($session_data);

            $data = array(
                'code' => '00',
                'message' => 'Berhasil login!',
                'data' => [],
            );
    
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
            return;
        } else {
            $data = array(
                'code' => '01',
                'message' => 'Gagal login, periksa email dan password kembali!',
                'data' => [],
            );
    
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
            return;
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}