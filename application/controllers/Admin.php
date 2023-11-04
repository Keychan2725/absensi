<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload','pagination');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url() . 'auth/login');
        }
    }
    public function dashboard()
    {   $data['rekap_seluruh'] = $this->m_model->get_data('absensi')->result();
        $data['absen'] = $this-> m_model->get_data('absensi' )->result();
        $data['jumlah_absen'] = $this-> m_model->get_data('absensi'  )->num_rows();
        $data['karyawan'] = $this-> m_model->get_data('user'  )->num_rows();
         $this->load->view('admin/dashboard',$data);
    }
   
    public function rekap_minggu()
    {   $data['absensi'] = $this->m_model->getAbsensiLast7Days();
        $this->load->view('admin/rekap_minggu',$data);
    }
    public function rekap_bulan()
    {   
         
        $bulan = $this->input->post('bulan'); // Ambil nilai bulan yang dipilih dari form
        $data['rekap_bulan'] = $this->m_model->getAbsensiLastMonth($bulan);
       
        $this->load->view('admin/rekap_bulan',$data);
    }
    public function rekap_harian()
    {  
        $hari = $this->input->post('hari'); // Ambil nilai bulan yang dipilih dari form
        $data['data_harian'] = $this->m_model->get_harian( $hari);
     $this->load->view('admin/rekap_harian', $data);
    }
  
    public function karyawan()
    { $data['karyawan']= $this->m_model->get_data('user')->result();
        
        $this->load->view('admin/karyawan',$data);
    }
   // Menghapus data karyawan berdasarkan ID
   public function hapus_karyawan($id) {
    // Menghapus data terkait di tabel 'absensi'
    $this->m_model->delete('absensi', 'id_karyawan', $id);

    // Menghapus data dari tabel 'user'
    $this->m_model->delete('user', 'id', $id);

    $this->session->set_flashdata('berhasil_menghapus', 'Data berhasil dihapus.');
    redirect(base_url('admin/karyawan'));
}
    public function  export_karyawan(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
         
        $style_col = [
            'font'=> ['bold' => true],
            'alignment'=> [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
            ],
            'borders'=> [
                'top'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'right'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'bottom'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'left'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN]
            ],
            ];
        $style_row = [
            
            'alignment'=> [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
            ],
            'borders'=> [
                'top'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'right'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'bottom'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN],
                'left'=> ['borderstyle'=> \PhpOffice\PhpSpreadsheet\Style\Border ::BORDER_THIN]
            ],
            ];
    // Head
            $sheet->setCellValue('A1','DATA KARYAWAN');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $sheet->setCellValue('A2','ID');
            $sheet->setCellValue('B2','FOTO');
            $sheet->setCellValue('C2','USERNAME');
            $sheet->setCellValue('D2','NAMA DEPAN');
            $sheet->setCellValue('E2','NAMA BELAKANG');
            $sheet->setCellValue('F2','EMAIL');
    
            $sheet->getStyle('A2')->applyFromArray($style_col);
            $sheet->getStyle('B2')->applyFromArray($style_col);
            $sheet->getStyle('C2')->applyFromArray($style_col);
            $sheet->getStyle('D2')->applyFromArray($style_col);
            $sheet->getStyle('E2')->applyFromArray($style_col);
            $sheet->getStyle('F2')->applyFromArray($style_col);
    // get data dari database
            $karyawan =  $this->m_model->get_data('user')->result();
    // isi
            $no=1;
            $numrow=3;
            foreach ($karyawan as $data) {
            $sheet->setCellValue('A'.$numrow,$no );
            $sheet->setCellValue('B'.$numrow, $data->foto);
            $sheet->setCellValue('C'.$numrow,$data->username);
            $sheet->setCellValue('D'.$numrow,$data->nama_depan);
            $sheet->setCellValue('E'.$numrow, $data->nama_belakang) ;
            $sheet->setCellValue('F'.$numrow, $data->email) ;
          
    
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            
            $no++;
            $numrow++;
            }
            
    
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
     
            $sheet->getDefaultRowDimension()->setRowHeight(-1);
    
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    
            $sheet->setTitle("LAPORAN DATA KARYAWAN");
    
    
            header('Content-Type: aplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="KARYAWAN.xlsx"');
            header('cache-Control: max-age=0');
    
            $writer =new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
        public function export_seluruh() {

            // Load autoloader Composer
            require 'vendor/autoload.php';
            
            $spreadsheet = new Spreadsheet();
    
            // Buat lembar kerja aktif
           $sheet = $spreadsheet->getActiveSheet();
            // Data yang akan diekspor (contoh data)
            $data = $this->m_model->get_data('absensi')->result();
            
            // Buat objek Spreadsheet
            $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN'];
            $rowIndex = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
                $rowIndex++;
            }
            
            // Isi data dari database
            $rowIndex = 2;
            $no = 1;
            foreach ($data as $rowData) {
                $columnIndex = 1;
                $nama_karyawan = '';
                $kegiatan = '';
                $tanggal = '';
                $jam_masuk = '';
                $jam_keluar = '';
                $izin = ''; 
                $status = ''; 
                foreach ($rowData as $cellName => $cellData) {
                    if ($cellName == 'kegiatan') {
                       $kegiatan = $cellData;
                    } else if($cellName == 'id_karyawan') {
                        $nama_karyawan = tampil_id_karyawan($cellData);
                    } elseif ($cellName == 'date') {
                        $tanggal = $cellData;
                    } elseif ($cellName == 'jam_masuk') {
                        if($cellData == NULL) {
                            $jam_masuk = '-';
                        }else {
                            $jam_masuk = $cellData;
                        }
                    } elseif ($cellName == 'jam_keluar') {
                        if($cellData == NULL) {
                            $jam_keluar = '-';
                        }else {
                            $jam_keluar = $cellData;
                        }
                    } elseif ($cellName == 'keterangan_izin') {
                        $izin = $cellData;
                    }   elseif ($cellName == 'status') {
                        $status = $cellData;
                    }
            
                    // Anda juga dapat menambahkan logika lain jika perlu
                    
                    // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                    $columnIndex++;
                }
                // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
                // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
                $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
                $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
                $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
                $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
                $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_keluar);
                $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
                $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
                $no++;
            
                $rowIndex++;
            }
            // Auto size kolom berdasarkan konten
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set style header
            $headerStyle = [
                'font'=> ['bold' => true],
            'alignment'=> [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
            ],
            ];
            $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
            
            // Konfigurasi output Excel
            $writer = new Xlsx($spreadsheet);
            $filename = ' REKAP_KESELURUHAN.xlsx'; // Nama file Excel yang akan dihasilkan
            
            // Set header HTTP untuk mengunduh file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // Outputkan file Excel ke browser
            $writer->save('php://output');
            
        }
        public function export_minggu() {

            // Load autoloader Composer
            require 'vendor/autoload.php';
            
            $spreadsheet = new Spreadsheet();
    
            // Buat lembar kerja aktif
           $sheet = $spreadsheet->getActiveSheet();
            // Data yang akan diekspor (contoh data)
            $data = $this->m_model->getAbsensiLast7Days();
            
            // Buat objek Spreadsheet
            $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN'];
            $rowIndex = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
                $rowIndex++;
            }
            
            // Isi data dari database
            $rowIndex = 2;
            $no = 1;
            foreach ($data as $rowData) {
                $columnIndex = 1;
                $nama_karyawan = '';
                $kegiatan = '';
                $tanggal = '';
                $jam_masuk = '';
                $jam_keluar = '';
                $izin = ''; 
                $status = ''; 
                foreach ($rowData as $cellName => $cellData) {
                    if ($cellName == 'kegiatan') {
                       $kegiatan = $cellData;
                    } else if($cellName == 'id_karyawan') {
                        $nama_karyawan = tampil_id_karyawan($cellData);
                    } elseif ($cellName == 'date') {
                        $tanggal = $cellData;
                    } elseif ($cellName == 'jam_masuk') {
                        if($cellData == NULL) {
                            $jam_masuk = '-';
                        }else {
                            $jam_masuk = $cellData;
                        }
                    } elseif ($cellName == 'jam_keluar') {
                        if($cellData == NULL) {
                            $jam_keluar = '-';
                        }else {
                            $jam_keluar = $cellData;
                        }
                    } elseif ($cellName == 'keterangan_izin') {
                        $izin = $cellData;
                    }  elseif ($cellName == 'status') {
                        $status = $cellData;
                    }
            
                    // Anda  dapat menambahkan logika lain jika perlu
                    
                     $columnIndex++;
                }
                // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
                // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
                $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
                $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
                $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
                $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
                $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_keluar);
                $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
                $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
                $no++;
            
                $rowIndex++;
            }
            // Auto size kolom berdasarkan konten
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set style header
            $headerStyle = [
                'font'=> ['bold' => true],
            'alignment'=> [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
            ],
            ];
            $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
            
            // Konfigurasi output Excel
            $writer = new Xlsx($spreadsheet);
            $filename = ' REKAP_MINGGUAN.xlsx'; // Nama file Excel yang akan dihasilkan
            
            // Set header HTTP untuk mengunduh file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // Outputkan file Excel ke browser
            $writer->save('php://output');
            
        }
        public function export_harian() {

            // Load autoloader Composer
            require 'vendor/autoload.php';
            
            $spreadsheet = new Spreadsheet();
    
            // Buat lembar kerja aktif
           $sheet = $spreadsheet->getActiveSheet();
            // Data yang akan diekspor (contoh data)
            $tanggal = date('Y-m-d'); // Ambil nilai tanggal yang dipilih dari form
            $data = $this->m_model->get_harian($tanggal);
            
            // Buat objek Spreadsheet
            $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN'];
            $rowIndex = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
                $rowIndex++;
            }
            
            // Isi data dari database
            $rowIndex = 2;
            $no = 1;
            foreach ($data as $rowData) {
                $columnIndex = 1;
                $nama_karyawan = '';
                $kegiatan = '';
                $tanggal = '';
                $jam_masuk = '';
                $jam_keluar = '';
                $izin = ''; 
                $status = ''; 
                foreach ($rowData as $cellName => $cellData) {
                    if ($cellName == 'kegiatan') {
                       $kegiatan = $cellData;
                    } else if($cellName == 'id_karyawan') {
                        $nama_karyawan = tampil_id_karyawan($cellData);
                    } elseif ($cellName == 'date') {
                        $tanggal = $cellData;
                    } elseif ($cellName == 'jam_masuk') {
                        if($cellData == NULL) {
                            $jam_masuk = '-';
                        }else {
                            $jam_masuk = $cellData;
                        }
                    } elseif ($cellName == 'jam_keluar') {
                        if($cellData == NULL) {
                            $jam_keluar = '-';
                        }else {
                            $jam_keluar = $cellData;
                        }
                    } elseif ($cellName == 'keterangan_izin') {
                        $izin = $cellData;
                    }elseif ($cellName == 'status') {
                        $status = $cellData;
                     }
            
                    // Anda juga dapat menambahkan logika lain jika perlu
                    
                    // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                    $columnIndex++;
                }
                // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
                // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
                $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
                $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
                $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
                $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
                $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_keluar);
                $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
                $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
                $no++;
            
                $rowIndex++;
            }
            // Auto size kolom berdasarkan konten
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set style header
            $headerStyle = [
                'font' => ['bold' => true],
                'alignment'=> [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
                ],
            ];
            $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
            
            // Konfigurasi output Excel
            $writer = new Xlsx($spreadsheet);
            $filename = 'REKAP_HARIAN.xlsx'; // Nama file Excel yang akan dihasilkan
            
            // Set header HTTP untuk mengunduh file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // Outputkan file Excel ke browser
            $writer->save('php://output');
            
        }
        public function export_bulan() {

            // Load autoloader Composer
            require 'vendor/autoload.php';
            
            $spreadsheet = new Spreadsheet();
    
            // Buat lembar kerja aktif
           $sheet = $spreadsheet->getActiveSheet();
            // Data yang akan diekspor (contoh data)
            $bulan = date('m');; // Ambil nilai bulan yang dipilih dari form
            $data = $this->m_model->getAbsensiLastMonth($bulan);
            
            // Buat objek Spreadsheet
            $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN', 'STATUS'];
            $rowIndex = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
                $rowIndex++;
            }
            
            // Isi data dari database
            $rowIndex = 2;
            $no = 1;
            foreach ($data as $rowData) {
                $columnIndex = 1;
                $nama_karyawan = '';
                $kegiatan = '';
                $tanggal = '';
                $jam_masuk = '';
                $jam_keluar = '';
                $izin = ''; 
                $status = ''; 
                foreach ($rowData as $cellName => $cellData) {
                    if ($cellName == 'kegiatan') {
                       $kegiatan = $cellData;
                    } else if($cellName == 'id_karyawan') {
                        $nama_karyawan = tampil_id_karyawan($cellData);
                    } elseif ($cellName == 'date') {
                        $tanggal = $cellData;
                    } elseif ($cellName == 'jam_masuk') {
                        if($cellData == NULL) {
                            $jam_masuk = '-';
                        }else {
                            $jam_masuk = $cellData;
                        }
                    } elseif ($cellName == 'jam_keluar') {
                        if($cellData == NULL) {
                            $jam_keluar = '-';
                        }else {
                            $jam_keluar = $cellData;
                        }
                    } elseif ($cellName == 'keterangan_izin') {
                        $izin = $cellData;
                    } elseif ($cellName == 'status') {
                       $status = $cellData;
                    }
            
                    // Anda juga dapat menambahkan logika lain jika perlu
                    
                    // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                    $columnIndex++;
                }
                // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
                // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
                $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
                $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
                $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
                $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
                $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
                $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_keluar);
                $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
                $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
                $no++;
            
                $rowIndex++;
            }
            // Auto size kolom berdasarkan konten
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set style header
            $headerStyle =[
                'font'=> ['bold' => true],
                'alignment'=> [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment ::VERTICAL_CENTER
            ]];
            $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
            
            // Konfigurasi output Excel
            $writer = new Xlsx($spreadsheet);
            $filename = ' REKAP_BULANAN.xlsx'; // Nama file Excel yang akan dihasilkan
            
            // Set header HTTP untuk mengunduh file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // Outputkan file Excel ke browser
            $writer->save('php://output');
            
        }
       
}  