<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'karyawan') {
            redirect(base_url() . 'auth/login');
        }
    }
    public function dashboard()
    {
        $data['user']=$this->m_model->get_data('user')->num_rows();
        $this->load->view('karyawan/dashboard',$data);
    }
    public function karyawan()
    {
    //    $data['user']=$this->m_model->get_data('user')->result();

        $this->load->view('karyawan/karyawan');
    }
    
}