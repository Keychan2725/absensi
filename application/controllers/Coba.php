<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coba extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
       
    }
    public function coba_tailwind()
    {
        $this->load->view('coba_tailwind',);
    }
   
    
}