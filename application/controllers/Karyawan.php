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
        $data['user']=$this->m_model->get_data('user')->result();
        $data['absensi']=$this->m_model->get_data('absensi')->result();
    
        $this->load->view('karyawan/dashboard',$data);
    }
    public function history()
    {        $data['absensi']=$this->m_model->get_data('absensi')->result();
        $data['jam'] = date('Y-m-d H:i:s'); // Isi tanggal_masuk secara otomatis

        $this->load->view('karyawan/history',$data);
  
}
public function hapus_karyawan($id)
{
    $this->m_model->delete('absensi', 'id', $id);
    redirect(base_url('karyawan/history'));
}

public function absensi()
{

    $this->load->view('karyawan/absensi');
}
public function kegiatan()
{
    $data=array(
        'kegiatan'=> $this->input->post('kegiatan')
    );
    $this->m_model->ubah_data('absensi', $data, array('id_karyawan' => $this->input->post('id_karyawan')));redirect(base_url('karyawan/history'));
 
}

}