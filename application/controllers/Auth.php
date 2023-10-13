<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('m_model');
    }
    public function login()
    {
        $this->load->view('auth/login');
    }
    public function aksi_login()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $data = ['email' => $email,];
        $query = $this->m_model->getwhere('user', $data);
        $result = $query->row_array();

        if (!empty($result) && md5($password) === $result['password']) {
            $data = [
                'logged_in' => true,
                'email' => $result['email'],
                'username' => $result['username'],
                'role' => $result['role'],
                'id' => $result['id'],
            ];
            $this->session->set_userdata($data);
			
            if ($this->session->userdata('role') == 'admin') {
                redirect(base_url('admin/dashboard'));
            }elseif ($this->session->userdata('role') == 'karyawan') {
            redirect(base_url('karyawan/dashboard'))  ;
            } else {
                redirect(base_url('auth/login'));
            }
        } else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Password Atau Email Anda Salah
			
		
		  </div>');
            redirect(base_url('auth/login'));
        }
    }
   public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth/login'));
    }
    public function admin()
	{

		$data['title'] = 'Halaman Registrasi';

		$this->load->view('auth/admin');
	}
    public function aksi_register_admin()
	{
$role="admin";
		$data = [
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'nama_depan' => $this->input->post('nama_depan'),
			'nama_belakang' => $this->input->post('nama_belakang'),
			'password' => md5($this->input->post('password')),
            'role'=> $role
		];
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

		if ($this->form_validation->run() === TRUE) {
			$this->m_model->tambah_data('user', $data);
			redirect(base_url('auth/login'));
            
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Password anda kurang dari 8 angka
			
		
		  </div>');
			redirect(base_url(('auth/admin')));
		}
	}
    public function register()
	{

		$data['title'] = 'Halaman Registrasi';

		$this->load->view('auth/register');
	}
	public function aksi_register()
	{
$role="karyawan";
		$data = [
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'nama_depan' => $this->input->post('nama_depan'),
			'nama_belakang' => $this->input->post('nama_belakang'),
			'password' => md5($this->input->post('password')),

'role'=> $role
		];
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

		if ($this->form_validation->run() === TRUE) {
			$this->m_model->tambah_data('user', $data);
			redirect(base_url('auth/login'));
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Password anda kurang dari 8 angka
			
		
		  </div>');
			redirect(base_url(('auth/register')));
		}
	}
}