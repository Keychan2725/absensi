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
				$this->session->set_flashdata('sukses', '  Berhasil Login ');
                redirect(base_url('admin/dashboard'));
            }elseif ($this->session->userdata('role') == 'karyawan') {
		    $this->session->set_flashdata('sukses', '  Berhasil Login ');
            redirect(base_url('karyawan/dashboard'))  ;
            } else {
                redirect(base_url('auth/login'));
            }
        } else {
			$this->session->set_flashdata('gagal', ' Password Atau Email Anda Salah ');
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
    public function aksi_register()
	{
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$nama_depan = $this->input->post('nama_depan');
		$nama_belakang = $this->input->post('nama_belakang');
 		$password = $this->input->post('password');
		if ($this->m_model->EmailSudahAda($email)) {
			$this->session->set_flashdata('error', '  Email ini sudah  ada. Gunakan email lainya ');
			redirect(base_url('auth/register'));
		}elseif ($this->m_model->usernameSudahAda($username)) {
			$this->session->set_flashdata('error', '  Username ini sudah ada. Gunakan username lainya	 ');
			redirect(base_url('auth/register'));
		} elseif (strlen($password) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
			// Password tidak memenuhi persyaratan
			$this->session->set_flashdata('error', '  Password harus memiliki setidaknya 8 karakter ');
			redirect(base_url('auth/register'));
		} else {
			// Hash password menggunakan MD5
			$hashed_password = md5($password);

			// Simpan data pengguna ke database
			$data = array(
				'username' => $username,
				'password' => $hashed_password,
				'email' => $email,
				'role' => 'karyawan',
				'nama_depan' => $nama_depan,
				'nama_belakang' => $nama_belakang,
			);

			$this->m_model->register($data); // Panggil model untuk menyimpan data

			$this->session->set_flashdata('sukses', 'Berhasil Register');
			redirect(base_url('auth/login'));
		}
}
    public function register()
	{

		$data['title'] = 'Halaman Registrasi';

		$this->load->view('auth/register');
	}
	public function aksi_register_admin()
	{
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		$nama_depan = $this->input->post('nama_depan');
		$nama_belakang = $this->input->post('nama_belakang');
 		$password = $this->input->post('password');
		if ($this->m_model->EmailSudahAda($email)) {
			$this->session->set_flashdata('error', ' 	Email ini sudah ada. Gunakan email lainya ');
			redirect(base_url('auth/admin'));
		}elseif ($this->m_model->usernameSudahAda($username)) {
			$this->session->set_flashdata('error', ' Username ini sudah ada. Gunakan username lainya ');
			redirect(base_url('auth/admin'));
		} elseif (strlen($password) < 8 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
			// Password tidak memenuhi persyaratan
			$this->session->set_flashdata('error', ' Password harus memiliki setidaknya 8 karakter ');
			redirect(base_url('auth/admin'));
		} else {
			// Hash password menggunakan MD5
			$hashed_password = md5($password);

			// Simpan data pengguna ke database
			$data = array(
				'username' => $username,
				'password' => $hashed_password,
				'email' => $email,
				'role' => 'admin',
				'nama_depan' => $nama_depan,
				'nama_belakang' => $nama_belakang,
			);

			$this->m_model->register($data); // Panggil model untuk menyimpan data

			$this->session->set_flashdata('sukses', 'Berhasil Register');
			redirect(base_url('auth/login'));
		}
}
}