<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('WhoApi');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

	public function index()
	{		
		$this->load->model('PatientHistory_model');
		$this->load->model('Patient_model');

    	$data['most_cases'] = $this->PatientHistory_model->get_most_cases();
		$data['patient_total'] = $this->Patient_model->get_total();
		$data['patient_total_month'] = $this->Patient_model->get_total_month();
		$data['user'] = $this->Patient_model->get_user_month();
		$this->load->view('welcome', $data);
	}

	public function icd() {
		$data = $this->whoapi->fetchData();
        echo json_encode($data, JSON_PRETTY_PRINT);
		return;
	}
}
