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
            $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();

            $this->load->view('sidebar/sidebar_1',$data);
        }
    }