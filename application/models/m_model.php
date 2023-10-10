<?php

class M_model extends CI_Model
{
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

}