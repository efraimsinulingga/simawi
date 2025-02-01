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

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'Doctor') {            
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

        $user = $this->RecordMedicDoctor_model->get_patient_history($isDone, $date, $q);
        
        $data['user'] = $user;
        $this->load->view('record_medic/record_medic_list', $data);
    }

    public function diagnose() {
        
        $id = $this->input->get('id');

        $user = $this->RecordMedicDoctor_model->get_single_patient_history($id);
        if($user->isDone == '1') {
            $this->session->set_flashdata('success', "Data Pemeriksaan Pasien Telah Selesai!");
        }
        $data['user'] = $user;
        
        $this->load->view('record_medic/record_medic_edit', $data);
    }  

    public function diagnose_post() {        
        
            $id = $this->input->post('id');
            $kode = $this->input->post('kode');
            $name = $this->input->post('name');
            $diagnose = $this->input->post('diagnose');
            $symptoms = $this->input->post('symptoms');    
            
            
            $this->RecordMedicDoctor_model->save($id, $diagnose, $kode, $name, $symptoms);

            $this->session->set_flashdata('success', "Pemeriksaan Selesai!");
            redirect('medical-record');
    }
}