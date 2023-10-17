<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_model extends CI_Model
{

                public function __construct()
                {
                    parent::__construct();
                }
                
                function get_data($table)
                {
                    return $this->db->get($table);
                }
                function getwhere($table, $data)
                {
                    return $this->db->get_where($table, $data);
                }
                function delete($table, $field, $id)
                {
                    $data = $this->db->delete($table, array($field => $id));
                    return $data;
                }
                function tambah_data($table, $data)
                {
                    $this->db->insert($table, $data);
                    return $this->db->insert_id();
                }
                public function get_by_id($tabel, $id_column, $id)
                {
                    $data = $this->db->where($id_column, $id)->get($tabel);
                    return $data;
                }
                public function ubah_data($tabel, $data, $where)
                {
                    $data = $this->db->update($tabel, $data, $where);
                    return $this->db->affected_rows();
                }
                public function get_siswa_foto_by_id($id_siswa)
            {
                $this->db->select('foto');
                $this->db->from('siswa');
                $this->db->where('id_siswa', $id_siswa);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    $result = $query->row();
                    return $result->foto;
                } else {
                    return false;
                }
            }
            public function get_by_nisn($nisn){
                $this->db->select('id_siswa');
                $this->db->from('siswa');
                $this->db->where('nisn', $nisn);
                $query =  $this->db->get();

                if ($query->num_rows()>0) {
                    $result= $query->row();
                    return $result->id_siswa;
                }else {
                    return false;
                }
                    

            }
            public function get_foto_by_id($id)
                {
                    $this->db->select('foto');
                    $this->db->from('user');
                    $this->db->where('id', $id);
                    $query = $this->db->get();
                
                    if ($query->num_rows() > 0) {
                        $result = $query->row();
                        return $result->f;
                    } else {
                        return false;
                    }
                }
            public function get_by_jurusan($tingkat, $jurusan)
                {
                    $this->db->select('id');
                    $this->db->from('kelas');
                    $this->db->where('tingkat_kelas', $tingkat);
                    $this->db->where('jurusan_kelas', $jurusan);
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {
                        $result = $query->row();
                        return $result->id;
                    } else {
                        return false;
                    }
                }
            
                public function registerUser($username, $password, $role_id)
                {
                    // Simpan data pengguna ke dalam tabel users
                    $data = array(
                        'username' => $username,
                        'password' => $password,
                        'role_id' => $role_id,
                    );

                    $this->db->insert('users', $data);
                }
                public function absensi($data) {
                    $this->db->insert('absensi', $data);
                }
                public function get_history($table, $id_karyawan)
                {
                    return $this->db->where('id_karyawan', $id_karyawan)->get($table);
                }
                public function getlast($table, $where) {
                    $this->db->select('*');
                    $this->db->from($table);
                    $this->db->where($where);
                    $this->db->order_by('id', 'DESC');
                    $this->db->limit(1);
                    return $this->db->get()->row();
                }
                public function get_absen($table, $id_karyawan)
                {
                return $this->db->where('id_karyawan', $id_karyawan)
                                ->where('keterangan_izin', '-')
                                ->get($table);
                }
                public function get_izin($table, $id_karyawan)
                {
                return $this->db->where('id_karyawan', $id_karyawan)
                                ->where('kegiatan', '-')
                                 ->get($table);
                }
                public function get_user_data($user_id)
                {
                    return $this->db->get_where('user', array('id' => $user_id))->row_array();
                }
            
               
                public function getAbsensiLast7Days() {
                    $this->load->database();
                    $end_date = date('Y-m-d');
                    $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));        
                    $query = $this->db->select('id_karyawan,date, kegiatan, jam_masuk, jam_keluar, keterangan_izin, status, COUNT(*) AS total_absences')
                                      ->from('absensi')
                                      ->where('date >=', $start_date)
                                      ->where('date <=', $end_date)
                                      ->group_by('id_karyawan,date, kegiatan, jam_masuk, jam_keluar, keterangan_izin, status')
                                      ->get();
                    return $query->result_array();
                }
              
 
 
                public function getAbsensiLastMonth($date)
                {
                    $this->db->from('absensi');
                    $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
                    $query = $this->db->get();
                    return $query->result();
                }
                
                public function view_by_date($date){
                    $this->db->where('date', $date); // Tambahkan where tanggal nya
                    
                return $this->db->get('absensi')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
                }
                public function get_harian($date)
                {
                $this->db->from('absensi');
                $this->db->where('date =', $date);
                $query = $this->db->get();
                return $query->result();
                }
                public function getAbsensiDaily($hari)
                {
                    $this->db->from('absensi');
                    $this->db->where('date', $hari);
                    $query = $this->db->get();
                    return $query->result();
                }

}