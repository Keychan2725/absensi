<?php defined('BASEPATH') or exit('No direct script access allowed');
 
class Sidebar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
       
        }
        public function sidebar_1(){
            $data['absen'] = $this-> m_model->get_history('absensi' , $this->session->userdata('id'))->result();
            $data['jumlah_absen'] = $this-> m_model->get_absen('absensi' , $this->session->userdata('id'))->num_rows();
            $data['jumlah_izin'] = $this-> m_model->get_izin('absensi' , $this->session->userdata('id'))->num_rows();
            $this->load->view('sidebar/sidebar_1',$data);
        }
    }