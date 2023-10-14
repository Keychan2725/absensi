<!-- <?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        $data['absen'] = $this-> m_model->get_data('absensi' , $this->session->userdata('id'))->result();
        $data['jumlah_absen'] = $this-> m_model->get_absen('absensi' , $this->session->userdata('id'))->num_rows();
        $data['jumlah_izin'] = $this-> m_model->get_izin('absensi' , $this->session->userdata('id'))->num_rows();
     
        $this->load->view('karyawan/dashboard',$data);
    }
    public function izin()
    {       
     
        $this->load->view('karyawan/izin');
    }
    public function history()
    {       
        $data['history'] = $this->m_model->get_data('absensi' , $this->session->userdata('id'))->result();

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

public function aksi_absensi()
{        
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $id_karyawan = $this->session->userdata('id');
    $tanggal_absensi = date('Y-m-d');

    // Cek apakah karyawan sudah pulang
    $absensi_terakhir = $this->m_model->getlast('absensi', array(
        'id_karyawan' => $id_karyawan
    ));

    // Mengecek apakah tanggal terakhir absensi sudah berbeda
    if ($absensi_terakhir && $absensi_terakhir->date !== $tanggal_absensi) {
        $absensi_terakhir = null; // Atur $absensi_terakhir menjadi null jika tanggal berbeda
    }

    if ($absensi_terakhir && $absensi_terakhir->jam_keluar === null) {
        // Karyawan belum pulang, tidak dapat melakukan absensi tambahan
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Anda tidak dapat melakukan absensi tambahan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect(base_url('karyawan/absensi'));
    } else {
        // Karyawan sudah pulang atau belum ada catatan absensi
        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => $this->input->post('kegiatan'),
            'jam_keluar' => null,
            'jam_masuk' => $waktu_sekarang, 
            'date' => $tanggal_absensi,  
            'keterangan_izin' => '-',
            'status' => 'not'
        ];

        $this->m_model->tambah_data('absensi', $data);
        redirect(base_url('karyawan/history'));
    }
}


public function aksi_izin()
{        
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $id_karyawan = $this->session->userdata('id');
    $tanggal_izin = date('Y-m-d');

    
    $izin = $this->m_model->getwhere('absensi', array(
        'id_karyawan' => $id_karyawan,
        'date' => $tanggal_izin
    ));

    if ($izin->num_rows() > 0) {
        // Karyawan sudah memiliki catatan izin pada tanggal yang sama
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Anda Sudah Mengajukan Izin Hari Ini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect(base_url('karyawan/izin'));
    } else {
      
        
        // Tambahkan pengecekan apakah sudah ada data absensi pada tanggal yang sama
        $absensi = $this->m_model->getwhere('absensi', array(
            'id_karyawan' => $id_karyawan,
            'date' => $tanggal_izin
        ));

        if ($absensi->num_rows() > 0) {
            // Karyawan sudah memiliki catatan absensi pada tanggal yang sama
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Anda Sudah Melakukan Absensi Hari Ini
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect(base_url('karyawan/izin'));
        } else {
            // Karyawan belum memiliki catatan izin atau absensi pada tanggal yang sama, bisa melanjutkan
            $data = [
                'id_karyawan' => $id_karyawan,
                'kegiatan' => '-',
                'jam_keluar' => NULL,
                'jam_masuk' => NULL, 
                'date' => $tanggal_izin,  
                'keterangan_izin' => $this->input->post('izin'),
                'status' => 'done'
            ];
        
            $this->m_model->tambah_data('absensi', $data);
             
            redirect(base_url('karyawan/history'));
        }
    }
}




public function pulang($id)
{
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $data = [
        'jam_keluar' => $waktu_sekarang,
        'status' => 'done'
    ];
    $this->m_model->ubah_data('absensi', $data, array('id'=> $id));
    redirect(base_url('karyawan/history'));
}
public function akun()
{         
    $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();


    $this->load->view('karyawan/akun',$data);

}

public function aksi_update_profile()
    {
    
        
        $username = $this->input->post('username');
        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');
        $foto = $this->input->post('foto');
     
				$data = [
                   'foto' => $foto,
                   'username' => $username,
                   'nama_depan' => $nama_depan,
                   'nama_belakang' => $nama_belakang,
               ];
               
              
               $this->session->set_userdata($data);
               $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));
               redirect(base_url('karyawan/akun'));
            
	 
           
		}
 
public function aksi_ubah_password()
    {
    
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');
        
     
			 
               if (!empty($password_baru) && strlen($password_baru) >= 8) {
                   if ($password_baru === $konfirmasi_password) {
                       $data['password'] = md5($password_baru);
                   }
              
               $this->session->set_userdata($data);
               $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));
               redirect(base_url('karyawan/akun'));
             } else {
                $this->session->set_flashdata('message','Password Anda Kurang Dari 8 Angka');
                  redirect(base_url('karyawan/akun'));
              }
		 
	 
           
		}
 

        public function upload_image()
        {  
            $base64_image = $this->input->post('base64_image');

            $binary_image = base64_encode($base64_image);
        
            $data = array(
                'foto' => $binary_image
            );
        
            $eksekusi = $this->m_model->ubah_data('user', $data, array('id'=>$this->input->post('id')));
            if($eksekusi) {
                $this->session->set_flashdata('sukses' , 'berhasil');
                redirect(base_url('karyawan/akun'));
            } else {
                $this->session->set_flashdata('error' , 'gagal...');
               echo "error gais";
            }
        }
        
    
    public function hapus_image()
    { 
        $data = array(
            'foto' => NULL
        );
    
        $eksekusi = $this->m_model->ubah_data('user', $data, array('id'=>$this->session->userdata('id')));
        if($eksekusi) {
            $this->session->set_flashdata('sukses' , 'berhasil');
            redirect(base_url('karyawan/akun'));
        } else {
            $this->session->set_flashdata('error' , 'gagal...');
           echo "error gais";
        }
    }
    
    
 
public function ubah_absen($id)
{
    $data['absen'] = $this-> m_model->get_by_id('absensi' , 'id', $id)->result();
    $this->load->view('karyawan/ubah_absen',$data);
}
public function aksi_ubah_absen()
{
    $data =  [
        'kegiatan' => $this->input->post('kegiatan'),
    ];
    $eksekusi = $this->m_model->ubah_data('absensi', $data, array('id'=>$this->input->post('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/history'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
        redirect(base_url('karyawan/ubah_absen'.$this->input->post('id')));
    }
}
public function ubah_izin($id)
{
    $data['izin'] = $this-> m_model->get_by_id('absensi' , 'id', $id)->result();
    $this->load->view('karyawan/ubah_izin',$data);
}
public function aksi_ubah_izin()
{
    $data =  [
        'keterangan_izin' => $this->input->post('izin'),
    ];
    $eksekusi = $this->m_model->ubah_data('absensi', $data, array('id'=>$this->input->post('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/history'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
        redirect(base_url('karyawan/ubah_izin'.$this->input->post('id')));
    }
}



} 