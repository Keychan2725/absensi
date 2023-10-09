<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
       
    }
    public function ubah_karyawan($id)
    {
        $data['user'] = $this->m_model->get_by_id('user', 'id_karyawan', $id)->result();
        $this->load->view('aksi/ubah_karyawan',$data);
    }
   
    
}