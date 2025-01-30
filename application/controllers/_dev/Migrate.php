<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {
    public function index() {
        $this->load->library('migration');

        if ($this->migration->latest()) {
            echo "Migration successful!";
        } else {
            // echo APPPATH;
            show_error($this->migration->error_string());
        }
    }
}
