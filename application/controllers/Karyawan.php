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

    if ($absensi_terakhir && $absensi_terakhir->jam_keluar === null) {
        // Karyawan belum pulang, tidak dapat melakukan absensi lagi
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Tidak dapat melakukan absensi tambahan
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

    // Cek apakah karyawan sudah memiliki catatan izin pada tanggal yang sama
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
        // Karyawan belum memiliki catatan izin pada tanggal yang sama, bisa melanjutkan
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
    
    $password_baru = md5($this->input->post('password_baru', true));
    $konfirmasi_password = md5($this->input->post('konfirmasi_password', true));
   
   
    $query = $this->m_model->getwhere('user', $data);
    $result = $query->row_array();
    if (md5($password_baru) === md5($konfirmasi_password)) {

     
            $data =  [   
                 'password' => md5($this->input->post('password_baru')),
                 'nama_depan' => $this->input->post('nama_depan'),
                 'nama_belakang' => $this->input->post('nama_belakang'),
                 'username' => $this->input->post('username'),
                 'email' => $this->input->post('email'),
                ];
            $eksekusi = $this->m_model->ubah_data('user', $data, array('id'=> $this->session->userdata('id')));
            if($eksekusi) {
                $this->session->set_flashdata('sukses' , 'berhasil');
                redirect(base_url('karyawan/akun'));
            } else {
                $this->session->set_flashdata('error' , 'gagal...');
                redirect(base_url('karyawan/akun/'.$this->session->userdata('id')));
            }
        
    } else {
        $this->session->set_flashdata('password_lama' , 'Password lama dengan inputan tidak cocok');
        redirect(base_url('karyawan/akun/'.$this->session->userdata('id')));
    }
}
// public function aksi_update_profile()
// {
//     $user_id = $this->session->userdata('id');
//     $username = $this->input->post('username');
//     $nama_depan = $this->input->post('nama_depan');
//     $nama_belakang = $this->input->post('nama_belakang');
//     $konfirmasi_password = md5($this->input->post('konfirmasi_password'));
//     $password_baru = md5($this->input->post('password_baru'));

//     if ($this->m_model->validate_password($user_id, $konfirmasi_password)) {
//         $data = array(
//             'username' => $username,
//             'nama_depan' => $nama_depan,
//             'nama_belakang' => $nama_belakang,
//             'password' => $password_baru
//         );

     
       

//         // Jika pengguna mengganti password, hash password baru
//         if (!empty($password_baru)) {
//             $data['password'] = md5($password_baru, PASSWORD_DEFAULT);
//         }

//         $this->m_model->update_profil($user_id, $data);
//         redirect('profil'); // Redirect kembali ke halaman profil setelah update
//     } else {
//         // Password konfirmasi tidak cocok
//         echo "Gagal memperbarui profil. Pastikan konfirmasi password benar.";
//     }
// }
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