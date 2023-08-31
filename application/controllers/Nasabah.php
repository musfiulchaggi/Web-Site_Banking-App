<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use phpDocumentor\Reflection\Types\This;

class Nasabah extends CI_Controller
{
    public function __construct()
    {
        // cek masuk terlebih dahulu
        parent::__construct();

        // load model nasabah untuk generate
        $this->load->model('Nasabah_model');

        // cek masuk terlebih dahulu
        // memanggil fungsi yang ada di helper musfiul_helper.php
        sudah_masuk();
    }

    public function tambahNasabah()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Nasabah';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        
        $data['all_user'] = $this->db->query('select * from user a left join tbl_nasabah b on a.id_user = b.id_user where b.id_user is null and a.role_id = 2;')->result_array();

        $data['nasabah'] = $this->db->query('select * from tbl_nasabah a, user b where a.id_user = b.id_user  order by a.id_nasabah ASC;')->result_array();
        $data['users'] = $this->db->query('select * from user where role_id = 2 order by id_user ASC;')->result_array();
        
        $this->form_validation->set_rules('income', 'Income', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat Sesuai KTP', 'required');
        $this->form_validation->set_rules('nama_ibu_kandung', 'Nama Ibu Kandung', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        
        if($this->form_validation->run() == false){
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('nasabah/tambah_nasabah.php', $data);
            $this->load->view('templates/footer_dashboard', $data); 
            
        }else{
            
            $data['userCalon'] = $this->db->get_where('user', [
                'email' => $this->input->post('email')
            ])->row_array();

            $id_user = $data['userCalon']['id_user'];
            $income = $this->input->post('income');
            $status = $this->input->post('status');
            $pendidikan = $this->input->post('pendidikan');
            $pengeluaran = $this->input->post('pengeluaran');
            $no_hp = $this->input->post('no_hp');
            $pekerjaan = $this->input->post('pekerjaan');
            $no_ktp = $this->input->post('no_ktp');
            $nama_ibu_kandung = $this->input->post('nama_ibu_kandung');
            $nama_pasangan = $this->input->post('nama_pasangan');
            $date_birth_pasangan = $this->input->post('date_birth_pasangan');
            $pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
            $no_ktp_pasangan = $this->input->post('no_ktp_pasangan');
            $jumlah_anak = $this->input->post('jumlah_anak');
            $alamat_ktp = $this->input->post('alamat_ktp');
            $lattitude = $this->input->post('lattitude');
            $longitude = $this->input->post('longitude');

            
            $foto_ktp = $_FILES['foto_ktp'];
            $nama_foto_ktp = $foto_ktp['name'];
            $foto_kk = $_FILES['foto_kk'];
            $nama_foto_kk = $foto_kk['name'];

            $nama_foto_ktp_pasangan = '';
            $nama_foto_buku_nikah = '';

            if(isset($_FILES['foto_ktp_pasangan'])){
                
                $foto_ktp_pasangan = $_FILES['foto_ktp_pasangan'];
                $nama_foto_ktp_pasangan = $foto_ktp_pasangan['name'];
            }

            if(isset( $_FILES['foto_buku_nikah'])){
                
                $foto_buku_nikah = $_FILES['foto_buku_nikah'];
                $nama_foto_buku_nikah = $foto_buku_nikah['name'];                
            }

            // set library upload
            $config['upload_path'] = './assets/img/nasabah/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']     = '2048';
        
            $this->load->library('upload', $config);

            $data['calonNasabah'] = $this->db->get_where('tbl_nasabah',[
                'id_user' => $id_user
            ])->row_array();

            if($data['calonNasabah']){

                    $nama_foto_ktp = $data['calonNasabah']['foto_ktp'];
                    $nama_foto_kk = $data['calonNasabah']['foto_kk'];
                    $nama_foto_ktp_pasangan = $data['calonNasabah']['foto_ktp_pasangan'];
                    $nama_foto_buku_nikah = $data['calonNasabah']['foto_buku_nikah'];
        
                        if ($this->upload->do_upload('foto_ktp')) {
                            // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                            $gbr = $this->upload->data();
                            $nama_foto_ktp = $gbr['file_name'];        
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }
    
                        if ($this->upload->do_upload('foto_kk')) {
                        $gbr = $this->upload->data();
                        $nama_foto_kk = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }
    
                        if ($this->upload->do_upload('foto_ktp_pasangan')) {
                        $gbr = $this->upload->data();
                        $nama_foto_ktp_pasangan = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }

                        if ($this->upload->do_upload('foto_buku_nikah')) {
                        $gbr = $this->upload->data();
                        $nama_foto_buku_nikah = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }

                        // rubah tgl pengajuan menjadi format angka
                        $date_birth_pasangan=strtotime($date_birth_pasangan);
                        if($pendidikan == "Pilih Pendidikan Terakhir"){
                            $pendidikan = $data['calonNasabah']['pendidikan'];
                        }
                        
                        if($status == "Pilih Status"){
                            $status = $data['calonNasabah']['status'];
                        }elseif($status == "Belum Menikah"){
                            $date_birth_pasangan  = null;
                            $nama_pasangan = null;
                            $pekerjaan_pasangan = null;
                            $no_ktp_pasangan = null; 
                            $jumlah_anak  = null;
                            $nama_foto_ktp_pasangan = null;
                            $nama_foto_buku_nikah = null;
                        }

                     
                        
                        $this->db->where('id_nasabah',$data['calonNasabah']['id_nasabah']);
                        $this->db->set([
                            'income' => $income,
                            'status' => $status,
                            'pendidikan' => $pendidikan,
                            'pengeluaran' => $pengeluaran,
                            'no_hp' => $no_hp,
                            'pekerjaan' => $pekerjaan,
                            'no_ktp' => $no_ktp,
                            'nama_ibu_kandung' => $nama_ibu_kandung,
                            'date_birth_pasangan' => $date_birth_pasangan,
                            'nama_pasangan' => $nama_pasangan,
                            'pekerjaan_pasangan' => $pekerjaan_pasangan,
                            'no_ktp_pasangan' => $no_ktp_pasangan,
                            'jumlah_anak' => $jumlah_anak,
                            'alamat_ktp' => $alamat_ktp,
                            'lattitude' => $lattitude,
                            'longitude' => $longitude,

                            'foto_ktp' => $nama_foto_ktp,
                            'foto_kk' => $nama_foto_kk,
                            'foto_ktp_pasangan' => $nama_foto_ktp_pasangan,
                            'foto_buku_nikah' => $nama_foto_buku_nikah,

                        ]);
                        $this->db->update('tbl_nasabah');
               
                

                // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                your data has been Edited!
                </div><br>');
            
            }else{
                if ($this->upload->do_upload('foto_ktp')) {

                            $gbr = $this->upload->data();
                            $nama_foto_ktp = $gbr['file_name'];        
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
    
                if ($this->upload->do_upload('foto_kk')) {
                        $gbr = $this->upload->data();
                        $nama_foto_kk = $gbr['file_name'];                    
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
    
                if ($this->upload->do_upload('foto_ktp_pasangan')) {
                        $gbr = $this->upload->data();
                        $nama_foto_ktp_pasangan = $gbr['file_name'];                    
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }

                if ($this->upload->do_upload('foto_buku_nikah')) {
                        $gbr = $this->upload->data();
                        $nama_foto_buku_nikah = $gbr['file_name'];                    
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
                        // rubah tgl pengajuan menjadi format angka
                $date_birth_pasangan=strtotime($date_birth_pasangan);
                if($pendidikan == "Pilih Pendidikan Terakhir"){
                            $pendidikan = null;
                }
                        
                if($status == "Pilih Status"){
                            $pendidikan = null;
                }
                
                $this->db->insert('tbl_nasabah',[
                    'id_user' => $id_user,
                    'income' => $income,
                    'status' => $status,
                    'pendidikan' => $pendidikan,
                    'pengeluaran' => $pengeluaran,
                    'no_hp' => $no_hp,
                    'pekerjaan' => $pekerjaan,
                    'no_ktp' => $no_ktp,
                    'nama_ibu_kandung' => $nama_ibu_kandung,
                    'date_birth_pasangan' => $date_birth_pasangan,
                    'nama_pasangan' => $nama_pasangan,
                    'pekerjaan_pasangan' => $pekerjaan_pasangan,
                    'no_ktp_pasangan' => $no_ktp_pasangan,
                    'jumlah_anak' => $jumlah_anak,
                    'alamat_ktp' => $alamat_ktp,
                    'lattitude' => $lattitude,
                    'longitude' => $longitude,

                    'foto_ktp' => $nama_foto_ktp,
                    'foto_kk' => $nama_foto_kk,
                    'foto_ktp_pasangan' => $nama_foto_ktp_pasangan,
                    'foto_buku_nikah' => $nama_foto_buku_nikah,
                ]);

                // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Input data success!
                </div><br>');

            }

            redirect('nasabah/tambahNasabah');
        }
    }

    public function getDataNasabah()
    {
        $id_nasabah = $this->input->post('idnasabah');
        $email = $this->input->post('email');
       
        $data['nasabah'] =  $this->db->get_where('tbl_nasabah', [
            'id_nasabah' => $id_nasabah,

            ])->row_array();
        $data['nasabah']['email'] = $email;

        echo json_encode($data['nasabah']);
    }

    // generate semua kategori nasabah lancar dan tidak lancar
    public function generateKategori( $id_nasabah = null)
    {
           $data_nasabah = $this->Nasabah_model->generateKategori($id_nasabah);

           redirect('nasabah/tambahNasabah');
        
    }

    public function loaddaftar()
    {
        $data['nasabah'] = $this->db->query("select * tbl_from nasabah;
         ")->result_array();

        if ($data['nasabah']) {
            echo json_encode($data['nasabah']);
        } else {
            echo json_encode(['message' => 'Data Kosong']);
        }
    }

    public function generateKemacetan( $id_nasabah = null)
    {
        $data_nasabah = $this->Nasabah_model->generateKemacetan($id_nasabah);
        return $data_nasabah;
           //redirect('nasabah/tambahNasabah');
        
    }

    // notifications 
    public function tampil_notif()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Member';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $this->load->view('nasabah/tampil_notif', $data);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', "Data Nasabah"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "Id Nasabah"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "Nama"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('D3', "Email"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('E3', "Income"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('F3', "Status"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('G3', "Pendidikan"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "Pengeluaran"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "Skor Kredit"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "Kategori Nasabah"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('I3', "Ship Date"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('J3', "Shipping Cost"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('K3', "Ship Via"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('L3', "Sales"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('M3', "Desc"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        // $sheet->getStyle('K3')->applyFromArray($style_col);
        // $sheet->getStyle('L3')->applyFromArray($style_col);
        // $sheet->getStyle('M3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->db->query("select * from user a inner join tbl_nasabah b on a.id_user = b.id_user;")->result_array();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['id_nasabah']);
            $sheet->setCellValue('C' . $numrow, $data['name']);
            $sheet->setCellValue('D' . $numrow, $data['email']);
            $sheet->setCellValue('E' . $numrow, $data['income']);
            $sheet->setCellValue('F' . $numrow, $data['status']);
            $sheet->setCellValue('G' . $numrow, $data['pendidikan']);
            $sheet->setCellValue('H' . $numrow, $data['pengeluaran']);
            $sheet->setCellValue('I' . $numrow, $data['kemacetan_kredit']);
            $sheet->setCellValue('J' . $numrow, $data['kategori_nasabah']);
            // $sheet->setCellValue('K' . $numrow, $data['ship_via']);
            // $sheet->setCellValue('L' . $numrow, $data['sales']);
            // $sheet->setCellValue('M' . $numrow, $data['keterangan']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(30); // Set width kolom E
        // $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom E
        // $sheet->getColumnDimension('L')->setWidth(30); // Set width kolom E
        // $sheet->getColumnDimension('M')->setWidth(30); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data Nasabah");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Nasabah.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


}