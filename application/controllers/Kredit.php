<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet

use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Thumbnails;

class Kredit extends CI_Controller
{
    public function __construct()
    {
        // cek masuk terlebih dahulu
        parent::__construct();

        // cek masuk terlebih dahulu
        // memanggil fungsi yang ada di helper musfiul_helper.php
        sudah_masuk();
    }


    public function deleteao(){
        $id_user = $this->input->post('id_user');

        $this -> db -> where('id_user', $id_user);
        $this -> db -> delete('user');

        // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Berhasil menghapus satu data Account Officer.
            </div><br>');


        redirect('kredit/ao');

    }

    public function ao()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Account Officer (AO)';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['ao'] = $this->db->query('SELECT * from user where user.role_id = 4 ORDER by user.id_user DESC')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('date_birth', 'Date Birth', 'required|trim');
        $this->form_validation->set_rules('ao_phone', 'Phone Number', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
        //     'is_unique' => 'This email has already registered!'
        // ]);


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/accountofficer.php', $data);
            $this->load->view('templates/footer_dashboard', $data);
        } else {

            $data = [
                // untuk menghindari xss (cross site scripting) digunakan parameter true dan htmlspecialchars untuk sanitasi karakter special (password tidak perlu)
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'gender' => $this->input->post('gender'),
                'ao_phone' => $this->input->post('ao_phone'),
                'date_birth' => strtotime($this->input->post('date_birth')),
                
                // menyimpan password dengan enkripsi menggunakan ci dengan password_hash
                'role_id' => '4', // role 4 for AO
                'is_active' => 0,
            ];

            // var_dump($data);
            //     die;
            // cek apakah dari form edit
            if(!empty($this->input->post('id_user'))){
                // do edit
                $id_user = $this->input->post('id_user');

                
                // menyimpan di database
                    $this->db->set($data);
                    $this->db->where('id_user', $id_user);

                    $this->db->update('user');

            }else{
                // do insert
                $data2 = ['image' => 'default.jpg',
                            'date_created' => time()
                        ];

                $data_insert = array_merge($data,$data2);

                $this->db->insert('user', $data_insert);

                $id_user = $this->db->insert_id();

            }
            
            // cek jika ada gambar yang diupload
            // maka akan ada $_FILES
            $upload_image = $_FILES['image'];
            $nama_image = $upload_image['name'];

            // var_dump($upload_image, [$id_user] , [ $nama_image]);
            // die;

            if (!empty($nama_image)) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                

                    // mengecek terlebih dahulu nama gambar untuk hapus filw di folder
                    // if ($data['user']['image'] != 'default.jpg') {
                    //     // untuk menghapus pakai unlink
                    //     // tidak bisa pakai base_url();
                    //     unlink(FCPATH . 'assets/img/profile/' . $data['user']['image']);
                    // }

                    // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                    $new_image = $this->upload->data('file_name');

                    // menyimpan di database
                    $this->db->set([
                        'image' => $new_image,
                    ]);
                    $this->db->where('id_user', $id_user);

                    $this->db->update('user');
                } else {
                    echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
            }     


            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil Menambahkan satu Account Officer
            </div><br>');

            redirect('kredit/ao');
        } 
    }


    public function deletejmn(){
        $id_jaminan = $this->input->post('id_jaminan');

        $this -> db -> where('id_jaminan', $id_jaminan);
        $this -> db -> delete('tbl_jaminan');

        // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Berhasil menghapus satu data Agunan.
            </div><br>');

        redirect('kredit/agunan');

    }

    public function agunan()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Agunan (Jaminan)';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['agunan_kendaraan'] = $this->db->query('SELECT * from tbl_jaminan a where a.kode_jaminan != "SHM/SHGB" ORDER by a.merk;')->result_array();
        $data['agunan_shm'] = $this->db->query('SELECT * from tbl_jaminan a where a.kode_jaminan = "SHM/SHGB" ')->row_array();

        // $this->form_validation->set_rules('kode_jaminan', 'Kode Agunan', 'required');
        // $this->form_validation->set_rules('merk', 'Pabrikan', 'required');
        // $this->form_validation->set_rules('roda', 'Jenis Kendaraan', 'required');
        // $this->form_validation->set_rules('harga', 'Harga Jual', 'required');
        // $this->form_validation->set_rules('nama_jaminan', 'Nama Agunan', 'required');
        $this->form_validation->set_rules('taksasi', 'Taksasi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/agunan.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            $data = [
                // untuk menghindari xss (cross site scripting) digunakan parameter true dan htmlspecialchars untuk sanitasi karakter special (password tidak perlu)
                'kode_jaminan' => $this->input->post('kode_jaminan'),
                'merk' => strtolower($this->input->post('merk')),
                'roda' => $this->input->post('roda'),
                'harga' => $this->input->post('harga'),
                'nama_jaminan' => $this->input->post('nama_jaminan'),
                'taksasi' => $this->input->post('taksasi'),
                'tgl_berlaku' => time(),
                
            ];

            if(!empty($this->input->post('id_jaminan'))){
                // do edit
                $id_jaminan = $this->input->post('id_jaminan');

                
                // menyimpan di database
                    if($id_jaminan == 1){
                        $this->db->set([
                            'taksasi'=> $this->input->post('taksasi'),
                        ]);
                    }else{
                        $this->db->set($data);
                    }

                    $this->db->where('id_jaminan', $id_jaminan);

                    $this->db->update('tbl_jaminan');

                    // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Berhasil Edit satu data Agunan.
                    </div><br>');

                    redirect('kredit/agunan');

            }else{

                $this->db->insert('tbl_jaminan', $data);

                $id_user = $this->db->insert_id();

            }

            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil Menambahkan satu data Agunan.
            </div><br>');

            redirect('kredit/agunan');
        }
    }


    public function tambahJenisKredit()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Jenis Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();



        $data['jenisKredit'] = $this->db->query('select * from tbl_jenis_kredit where status=0 order by id_jenis_kredit ASC;')->result_array();

        $this->form_validation->set_rules('total_angsuran_bulan', 'Angsuran', 'required');
        $this->form_validation->set_rules('jumlah_bunga_persen', 'Bunga', 'required');
        $this->form_validation->set_rules('nama_kredit', 'Kredit', 'required');
        $this->form_validation->set_rules('denda_persen', 'Denda', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/tambah_jenis_kredit.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            $id_jenis_kredit = $this->input->post('id_jenis_kredit');
            $total_angsuran_bulan = $this->input->post('total_angsuran_bulan');
            $jumlah_bunga_persen = $this->input->post('jumlah_bunga_persen');
            $nama_kredit = $this->input->post('nama_kredit');
            $denda_kredit = $this->input->post('denda_persen');
            $admin = 3;

            $this->db->insert('tbl_jenis_kredit', [
                'total_angsuran_bulan' => $total_angsuran_bulan,
                'jumlah_bunga_persen' => $jumlah_bunga_persen,
                'nama_kredit' => $nama_kredit,
                'denda_kredit' => $denda_kredit,
                'admin' => $admin,
                'status' => 1,
            ]);
            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            your data has been added!
            </div><br>');

            redirect('kredit/tambahJenisKredit');
        }
    }

    public function editJenisKredit()
    {
        $id_jenis_kredit = $this->input->post('id_jenis_kredit');
        $total_angsuran_bulan = $this->input->post('total_angsuran_bulan');
        $jumlah_bunga_persen = $this->input->post('jumlah_bunga_persen');
        $nama_kredit = $this->input->post('nama_kredit');
        $denda_kredit = $this->input->post('denda_persen');

        $this->db->update('tbl_jenis_kredit', [
            'total_angsuran_bulan' => $total_angsuran_bulan,
            'jumlah_bunga_persen' => $jumlah_bunga_persen,
            'nama_kredit' => $nama_kredit,
            'denda_kredit' => $denda_kredit,
        ], ['id_jenis_kredit' => $id_jenis_kredit]);

        // membuat flashdata untuk menampilkan pesan
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
         your data has been edited!
         </div><br>');

        redirect('kredit/tambahJenisKredit');
    }

    public function loaddaftar()
    {
        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit;
         ")->result_array();

        if ($data['jenisKredit']) {
            echo json_encode($data['jenisKredit']);
        } else {
            echo json_encode(['message' => 'Data Kosong']);
        }
    }

    public function getDataPengajuan ()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_nasabah = $this->input->post('id_nasabah');
        $data['request'] =[
            'id_pengajuan' => $id_pengajuan,
            'id_nasabah' => $id_nasabah,
        ];

        $data['pengajuan'] = $this->db->query('select * from tbl_pengajuan_kredit a, tbl_jenis_kredit c, 
            tbl_nasabah b, user d where a.id_nasabah = b.id_nasabah 
            and a.id_nasabah ='.$id_nasabah.' and c.id_jenis_kredit = a.id_jenis_kredit 
            and d.id_user = b.id_user and a.id_pengajuan='.$id_pengajuan.' order by a.id_pengajuan ASC;')->row_array();

        if(!empty($data['pengajuan'])){
            $data['daftar_jaminan'] = $this->db->query('select * from tbl_daftar_jaminan a, tbl_jaminan b
            where a.id_jaminan = b.id_jaminan and a.id_pengajuan='.$id_pengajuan)->result_array();


            if(!empty($data['daftar_jaminan'])){

                if(!isset($data['daftar_foto_jaminan']) && !isset($data['daftar_foto_surat_kepemilikan'])){

                    $data['daftar_foto_jaminan'] = array();
                    $data['daftar_foto_surat_kepemilikan'] = array();
                }
                
                
                foreach($data['daftar_jaminan'] as $dt){
                        
                        $data['daftar_foto_jaminan'][]=$this->db->query('select * from tbl_daftar_foto_jaminan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array() ;
    
                        $data['daftar_foto_surat_kepemilikan'][]=$this->db->query('select * from tbl_daftar_foto_surat_kepemilikan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array();
                }

            }
        }
        echo json_encode($data);
    }

    public function hapusfotosurat ()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_nasabah = $this->input->post('id_nasabah');
        $id_daftar_foto_surat_kepemilikan = $this->input->post('id_daftar_foto_surat_kepemilikan');

        $data['request'] =[
            'id_pengajuan' => $id_pengajuan,
            'id_nasabah' => $id_nasabah,
            'id_daftar_foto_surat_kepemilikan' => $id_daftar_foto_surat_kepemilikan,
        ];

        // delete foto surat kendaraan
        if(!empty($id_daftar_foto_surat_kepemilikan)){
            $this->db->where('id_daftar_foto_surat_kepemilikan', $id_daftar_foto_surat_kepemilikan);
            $this->db->delete('tbl_daftar_foto_surat_kepemilikan');
        }

        $data['pengajuan'] = $this->db->query('select * from tbl_pengajuan_kredit a, tbl_jenis_kredit c, 
            tbl_nasabah b, user d where a.id_nasabah = b.id_nasabah 
            and a.id_nasabah ='.$id_nasabah.' and c.id_jenis_kredit = a.id_jenis_kredit 
            and d.id_user = b.id_user and a.id_pengajuan='.$id_pengajuan.' order by a.id_pengajuan ASC;')->row_array();

        if(!empty($data['pengajuan'])){
            $data['daftar_jaminan'] = $this->db->query('select * from tbl_daftar_jaminan a, tbl_jaminan b
            where a.id_jaminan = b.id_jaminan and a.id_pengajuan='.$id_pengajuan)->result_array();


            if(!empty($data['daftar_jaminan'])){

                if(!isset($data['daftar_foto_jaminan']) && !isset($data['daftar_foto_surat_kepemilikan'])){

                    $data['daftar_foto_jaminan'] = array();
                    $data['daftar_foto_surat_kepemilikan'] = array();
                }
                
                
                foreach($data['daftar_jaminan'] as $dt){
                        
                        $data['daftar_foto_jaminan'][]=$this->db->query('select * from tbl_daftar_foto_jaminan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array() ;
    
                        $data['daftar_foto_surat_kepemilikan'][]=$this->db->query('select * from tbl_daftar_foto_surat_kepemilikan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array();
                }

            }
        }
        echo json_encode($data);
    }

    public function hapusfotojaminan ()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_nasabah = $this->input->post('id_nasabah');
        $id_daftar_foto_jaminan = $this->input->post('id_daftar_foto_jaminan');

        $data['request'] = [
            'id_pengajuan' => $id_pengajuan,
            'id_nasabah' => $id_nasabah,
            'id_daftar_foto_jaminan' => $id_daftar_foto_jaminan,
        ];

        // delete foto surat kendaraan
        if(!empty($id_daftar_foto_jaminan)){
            $this->db->where('id_daftar_foto_jaminan', $id_daftar_foto_jaminan);
            $this->db->delete('tbl_daftar_foto_jaminan');
        }

        $data['pengajuan'] = $this->db->query('select * from tbl_pengajuan_kredit a, tbl_jenis_kredit c, 
            tbl_nasabah b, user d where a.id_nasabah = b.id_nasabah 
            and a.id_nasabah ='.$id_nasabah.' and c.id_jenis_kredit = a.id_jenis_kredit 
            and d.id_user = b.id_user and a.id_pengajuan='.$id_pengajuan.' order by a.id_pengajuan ASC;')->row_array();

        if(!empty($data['pengajuan'])){
            $data['daftar_jaminan'] = $this->db->query('select * from tbl_daftar_jaminan a, tbl_jaminan b
            where a.id_jaminan = b.id_jaminan and a.id_pengajuan='.$id_pengajuan)->result_array();


            if(!empty($data['daftar_jaminan'])){

                if(!isset($data['daftar_foto_jaminan']) && !isset($data['daftar_foto_surat_kepemilikan'])){

                    $data['daftar_foto_jaminan'] = array();
                    $data['daftar_foto_surat_kepemilikan'] = array();
                }
                
                
                foreach($data['daftar_jaminan'] as $dt){
                        
                        $data['daftar_foto_jaminan'][]=$this->db->query('select * from tbl_daftar_foto_jaminan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array() ;
    
                        $data['daftar_foto_surat_kepemilikan'][]=$this->db->query('select * from tbl_daftar_foto_surat_kepemilikan a
                            where a.id_daftar_jaminan='.$dt['id_daftar_jaminan'].' order by a.id_daftar_jaminan ASC;')->result_array();
                }

            }
        }
        
        echo json_encode($data);
    }

    // cari kendaraan json
     public function carikendaraan()
    {
        $nama = $this->input->post('nama');
        $roda = $this->input->post('roda');
        $pabrikan = $this->input->post('pabrikan');

        if($nama == 'SHM/SHGB'){
            $data['kendaraan']=$this->db->query("select * from tbl_jaminan where merk LIKE '".$nama."%'")->result_array();
            

        }else{
            $data['request'] = [
                'nama'=>$nama,
                'roda'=>$roda,
                'pabrikan'=>$pabrikan
            ];
    
            $data['kendaraan']=$this->db->query("select * from tbl_jaminan where merk LIKE '".$pabrikan."%' and roda LIKE '".$roda."%' and nama_jaminan LIKE '%".$nama."%'")->result_array();
        }

        echo json_encode($data);
    }

    // memnambahkan pengajuan kredit dari menu list pengajuan kredit
    public function listPengajuanKredit()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'List Pengajuan Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit;")->result_array();
        $data['dataNasabah'] = $this->db->query("select * from tbl_nasabah a inner join user b on a.id_user = b.id_user;")->result_array();
        $data['ao'] = $this->db->query("select * from user where user.role_id = 4")->result_array();

        $data['pengajuanKredit'] = $this->db->query('SELECT * from tbl_pengajuan_kredit a INNER JOIN tbl_daftar_jaminan b 
                    ON a.id_pengajuan = b.id_pengajuan INNER JOIN tbl_jaminan c ON b.id_jaminan = c.id_jaminan 
                    INNER JOIN tbl_nasabah d ON a.id_nasabah = d.id_nasabah INNER JOIN USER e ON e.id_user = d.id_user 
                    INNER JOIN tbl_jenis_kredit f ON a.id_jenis_kredit = f.id_jenis_kredit ORDER by a.id_pengajuan DESC')->result_array();
        
        $this->form_validation->set_rules('jumlah_pinjaman', 'Jumlah', 'required');
        $this->form_validation->set_rules('id_nasabah', 'Id Nasabah', 'required');
        $this->form_validation->set_rules('id_jenis_kredit', 'Id Jenis Kredit', 'required');
        $this->form_validation->set_rules('nomor_surat_kepemilikan', 'Nomor BPKB', 'required');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'required');
        $this->form_validation->set_rules('dimiliki_tahun', 'Dimiliki Tahun', 'required');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
        $this->form_validation->set_rules('diperoleh_dengan', 'Diperoleh Dengan', 'required');

   

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/list_pengajuan_kredit.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            

                $id_pengajuan = $this->input->post('id_pengajuan');
                $id_nasabah = $this->input->post('id_nasabah');
                $id_jenis_kredit = $this->input->post('id_jenis_kredit');
                $jumlah_pinjaman = $this->input->post('jumlah_pinjaman');
                $id_jaminan = $this->input->post('id_jaminan');           
                $id_jaminan_shm = $this->input->post('id_jaminan_shm');           
                $luas_tanah = $this->input->post('luastanah');
                $nomor_surat_kepemilikan = $this->input->post('nomor_surat_kepemilikan');           
                $atas_nama = $this->input->post('atas_nama');           
                $dimiliki_tahun = $this->input->post('dimiliki_tahun');           
                $harga_beli = $this->input->post('harga_beli');           
                $diperoleh_dengan = $this->input->post('diperoleh_dengan');       
     
            if($id_pengajuan){
                    // for insert or update(edit data pengajuan pinjaman)
                    $data['pengajuan'] = $this->db->query('select * from tbl_pengajuan_kredit a, tbl_daftar_jaminan b, tbl_jaminan c 
                        where a.id_pengajuan = b.id_pengajuan and c.id_jaminan = b.id_jaminan and a.id_pengajuan='.$id_pengajuan)->row_array();

                    // get data id SHM for update jaminan
                    $data['id_jaminan_shm'] = $this->db->query("select a.id_jaminan from tbl_jaminan a where a.kode_jaminan = 'SHM/SHGB' ")->row_array();

            }

            if(!empty($data['pengajuan'])){
                    // update data   
                             
    
                    $id_pengajuan = $data['pengajuan']['id_pengajuan'];
                    $id_daftar_jaminan = $data['pengajuan']['id_daftar_jaminan'];
                    $old_kode_jaminan = $data['pengajuan']['id_jaminan'];
                    $kode_jaminan_shm = $data['id_jaminan_shm']['id_jaminan'];

                    if ($_FILES['foto_bpkb']['size'][0]  != 0 || $_FILES['foto_jaminan']['size'][0]  != 0 
                    || $_FILES['foto_stnk']['size'][0]  != 0 || $_FILES['foto_shm']['size'][0] != 0 ) {
                        // var_dump($_FILES);
                        // die;

                        $config['upload_path'] = './assets/img/pengajuan/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size']     = '2048';
        
                        $this->load->library('upload', $config);

                        $foto_bpkb = array();

                        if($_FILES['foto_bpkb']['size'][0]  != 0){
                            
                                                    foreach($_FILES['foto_bpkb']['name']  as $key => $image ){
                                                        
                                                        $_FILES['foto_bpkb[]']['name']= $_FILES['foto_bpkb']['name'][$key];
                                                        $_FILES['foto_bpkb[]']['type']= $_FILES['foto_bpkb']['type'][$key];
                                                        $_FILES['foto_bpkb[]']['tmp_name']= $_FILES['foto_bpkb']['tmp_name'][$key];
                                                        $_FILES['foto_bpkb[]']['error']= $_FILES['foto_bpkb']['error'][$key];
                                                        $_FILES['foto_bpkb[]']['size']= $_FILES['foto_bpkb']['size'][$key];
                            
                            
                                                        $fileName = $image;
                            
                                                        $config['file_name'] = $fileName;
                            
                                                        $this->upload->initialize($config);
                            
                                                        if ($this->upload->do_upload('foto_bpkb[]')) {
                                                            $gbr = $this->upload->data();
                                                            $foto_bpkb[] = $gbr['file_name'];
                                                        } else {
                                                            return false;
                                                        }
                                                    }

                        }

                        $foto_jaminan = array();

                        if( $_FILES['foto_jaminan']['size'][0]  != 0){

                            foreach($_FILES['foto_jaminan']['name']  as $key => $image ){
                                $_FILES['foto_jaminan[]']['name']= $_FILES['foto_jaminan']['name'][$key];
                                $_FILES['foto_jaminan[]']['type']= $_FILES['foto_jaminan']['type'][$key];
                                $_FILES['foto_jaminan[]']['tmp_name']= $_FILES['foto_jaminan']['tmp_name'][$key];
                                $_FILES['foto_jaminan[]']['error']= $_FILES['foto_jaminan']['error'][$key];
                                $_FILES['foto_jaminan[]']['size']= $_FILES['foto_jaminan']['size'][$key];
    
                                $fileName = $image;
    
                                $config['file_name'] = $fileName;
    
                                $this->upload->initialize($config);
    
                                if ($this->upload->do_upload('foto_jaminan[]')) {
                                    $gbr = $this->upload->data();
                                    $foto_jaminan[] = $gbr['file_name'];
                                } else {
                                    return false;
                                }
                            }
                        }
                        

                        $foto_stnk = array();

                        if( $_FILES['foto_stnk']['size'][0]  != 0){

                            foreach($_FILES['foto_stnk']['name']  as $key => $image ){
                                $_FILES['foto_stnk[]']['name']= $_FILES['foto_stnk']['name'][$key];
                                $_FILES['foto_stnk[]']['type']= $_FILES['foto_stnk']['type'][$key];
                                $_FILES['foto_stnk[]']['tmp_name']= $_FILES['foto_stnk']['tmp_name'][$key];
                                $_FILES['foto_stnk[]']['error']= $_FILES['foto_stnk']['error'][$key];
                                $_FILES['foto_stnk[]']['size']= $_FILES['foto_stnk']['size'][$key];
    
                                $fileName = $image;
    
                                $config['file_name'] = $fileName;
    
                                $this->upload->initialize($config);
    
                                if ($this->upload->do_upload('foto_stnk[]')) {
                                    $gbr = $this->upload->data();
                                    $foto_stnk[] = $gbr['file_name'];
                                } else {
                                    return false;
                                }
                            }
                        }

                        $foto_shm = array();

                        if( $_FILES['foto_shm']['size'][0]  != 0){

                            foreach($_FILES['foto_shm']['name']  as $key => $image ){
                                $_FILES['foto_shm[]']['name']= $_FILES['foto_shm']['name'][$key];
                                $_FILES['foto_shm[]']['type']= $_FILES['foto_shm']['type'][$key];
                                $_FILES['foto_shm[]']['tmp_name']= $_FILES['foto_shm']['tmp_name'][$key];
                                $_FILES['foto_shm[]']['error']= $_FILES['foto_shm']['error'][$key];
                                $_FILES['foto_shm[]']['size']= $_FILES['foto_shm']['size'][$key];

                                $fileName = $image;

                                $config['file_name'] = $fileName;

                                $this->upload->initialize($config);

                                if ($this->upload->do_upload('foto_shm[]')) {
                                    $gbr = $this->upload->data();
                                    $foto_shm[] = $gbr['file_name'];
                                }else {
                                    return false;
                                } 
                            }

                        }


    
                        // rubah tgl pengajuan menjadi format angka
                        $tgl_pengajuan=time();

                        $this->db->set([
                                'id_nasabah' => $id_nasabah,
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'jumlah_pinjaman' => $jumlah_pinjaman,
                                'tgl_pengajuan' => $tgl_pengajuan,
                                'keterangan_pengajuan' => 0,
                            ]
                            
                        );
                        
                        $this->db->where('id_pengajuan',$id_pengajuan);
                        $this->db->update('tbl_pengajuan_kredit');


                        if($id_jaminan_shm != ''){

                            if($id_jaminan_shm == $old_kode_jaminan){
                                // jaminan sama SHM
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan_shm,
                                    'luas_tanah' => $luas_tanah,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }else{
                                // jaminan yg di upload sblumnya adalah kendaraan
                                // hapus daftar foto surat jaminan terlebih dahulu
                                $this->db->delete('tbl_daftar_foto_surat_kepemilikan',['id_daftar_jaminan'=> $id_daftar_jaminan]);

                                // set update data daftar jaminan
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan_shm,
                                    'luas_tanah' => $luas_tanah,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }

                        }else{

                            if($old_kode_jaminan == $kode_jaminan_shm ){
                                // jaminan berubah dari SHM ke kendaraan 
                                // hapus daftar foto surat jaminan terlebih dahulu
                                $this->db->delete('tbl_daftar_foto_surat_kepemilikan',['id_daftar_jaminan'=> $id_daftar_jaminan]);

                                $this->db->set([
                                    'id_jaminan' => $id_jaminan,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }else{

                                // set update data daftar jaminan
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }
                        }
                        
                        $this->db->where('id_daftar_jaminan',$id_daftar_jaminan);
                        $this->db->update('tbl_daftar_jaminan');


                        foreach($foto_jaminan as $nama){
                            $this->db->insert('tbl_daftar_foto_jaminan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'foto_jaminan' => $nama,
                            ]);
                        }

                        foreach($foto_bpkb as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'BPKB',
                                'foto_surat' => $nama,
                            ]);
                        }
                        
                        foreach($foto_stnk as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'STNK',
                                'foto_surat' => $nama,
                            ]);
                        }

                        foreach($foto_shm as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'SHM/SHGB',
                                'foto_surat' => $nama,
                            ]);
                        }

                    } else {
                        // rubah tgl pengajuan menjadi format angka
                        $tgl_pengajuan=time();

                        $this->db->set([
                                'id_nasabah' => $id_nasabah,
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'jumlah_pinjaman' => $jumlah_pinjaman,
                                'tgl_pengajuan' => $tgl_pengajuan,
                                'keterangan_pengajuan' => 0,
                            ]
                            
                        );
                        
                        $this->db->where('id_pengajuan',$id_pengajuan);
                        $this->db->update('tbl_pengajuan_kredit');


                        if($id_jaminan_shm != ''){

                            if($id_jaminan_shm == $old_kode_jaminan){
                                // jaminan sama SHM
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan_shm,
                                    'luas_tanah' => $luas_tanah,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }else{
                                // jaminan yg di upload sblumnya adalah kendaraan
                                // hapus daftar foto surat jaminan terlebih dahulu
                                $this->db->delete('tbl_daftar_foto_jaminan',['id_daftar_jaminan'=> $id_daftar_jaminan]);

                                // set update data daftar jaminan
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan_shm,
                                    'luas_tanah' => $luas_tanah,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }

                        }else{

                            if($old_kode_jaminan == $kode_jaminan_shm ){
                                // jaminan berubah dari SHM ke kendaraan 
                                // hapus daftar foto surat jaminan terlebih dahulu
                                $this->db->delete('tbl_daftar_foto_jaminan',['id_daftar_jaminan'=> $id_daftar_jaminan]);

                                $this->db->set([
                                    'id_jaminan' => $id_jaminan,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }else{

                                // set update data daftar jaminan
                                $this->db->set([
                                    'id_jaminan' => $id_jaminan,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                                ]);

                            }
                        }
                        
                        $this->db->where('id_daftar_jaminan',$id_daftar_jaminan);
                        $this->db->update('tbl_daftar_jaminan');
                    }

                    // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    your data has been edited!
                    </div><br>');
        
                    redirect('kredit/listPengajuanKredit');

                    
                }else{

                    // insert data
                    if ($_FILES['foto_jaminan']['name'][0] && $_FILES['foto_bpkb']['name'][0] && $_FILES['foto_stnk']['name'][0] || $_FILES['foto_shm']['name'][0]) {
                        $config['upload_path'] = './assets/img/pengajuan/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size']     = '2048';
        
                        $this->load->library('upload', $config);

                        $foto_bpkb = array();

                        foreach($_FILES['foto_bpkb']['name']  as $key => $image ){
                            
                            $_FILES['foto_bpkb[]']['name']= $_FILES['foto_bpkb']['name'][$key];
                            $_FILES['foto_bpkb[]']['type']= $_FILES['foto_bpkb']['type'][$key];
                            $_FILES['foto_bpkb[]']['tmp_name']= $_FILES['foto_bpkb']['tmp_name'][$key];
                            $_FILES['foto_bpkb[]']['error']= $_FILES['foto_bpkb']['error'][$key];
                            $_FILES['foto_bpkb[]']['size']= $_FILES['foto_bpkb']['size'][$key];


                            $fileName = $image;

                            $config['file_name'] = $fileName;

                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('foto_bpkb[]')) {
                                $gbr = $this->upload->data();
                                $foto_bpkb[] = $gbr['file_name'];
                            } 
                        }

                        $foto_jaminan = array();

                        foreach($_FILES['foto_jaminan']['name']  as $key => $image ){
                            $_FILES['foto_jaminan[]']['name']= $_FILES['foto_jaminan']['name'][$key];
                            $_FILES['foto_jaminan[]']['type']= $_FILES['foto_jaminan']['type'][$key];
                            $_FILES['foto_jaminan[]']['tmp_name']= $_FILES['foto_jaminan']['tmp_name'][$key];
                            $_FILES['foto_jaminan[]']['error']= $_FILES['foto_jaminan']['error'][$key];
                            $_FILES['foto_jaminan[]']['size']= $_FILES['foto_jaminan']['size'][$key];

                            $fileName = $image;

                            $config['file_name'] = $fileName;

                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('foto_jaminan[]')) {
                                $gbr = $this->upload->data();
                                $foto_jaminan[] = $gbr['file_name'];
                            } 
                        }
                        

                        

                        $foto_stnk = array();

                        foreach($_FILES['foto_stnk']['name']  as $key => $image ){
                            $_FILES['foto_stnk[]']['name']= $_FILES['foto_stnk']['name'][$key];
                            $_FILES['foto_stnk[]']['type']= $_FILES['foto_stnk']['type'][$key];
                            $_FILES['foto_stnk[]']['tmp_name']= $_FILES['foto_stnk']['tmp_name'][$key];
                            $_FILES['foto_stnk[]']['error']= $_FILES['foto_stnk']['error'][$key];
                            $_FILES['foto_stnk[]']['size']= $_FILES['foto_stnk']['size'][$key];

                            $fileName = $image;

                            $config['file_name'] = $fileName;

                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('foto_stnk[]')) {
                                $gbr = $this->upload->data();
                                $foto_stnk[] = $gbr['file_name'];
                            } 
                        }

                        $foto_shm = array();

                        foreach($_FILES['foto_shm']['name']  as $key => $image ){
                            $_FILES['foto_shm[]']['name']= $_FILES['foto_shm']['name'][$key];
                            $_FILES['foto_shm[]']['type']= $_FILES['foto_shm']['type'][$key];
                            $_FILES['foto_shm[]']['tmp_name']= $_FILES['foto_shm']['tmp_name'][$key];
                            $_FILES['foto_shm[]']['error']= $_FILES['foto_shm']['error'][$key];
                            $_FILES['foto_shm[]']['size']= $_FILES['foto_shm']['size'][$key];

                            $fileName = $image;

                            $config['file_name'] = $fileName;

                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('foto_shm[]')) {
                                $gbr = $this->upload->data();
                                $foto_shm[] = $gbr['file_name'];
                            } 
                        }

    
                        // rubah tgl pengajuan menjadi format angka
                        $tgl_pengajuan=time();
                        
                        $this->db->insert('tbl_pengajuan_kredit', [
                                'id_nasabah' => $id_nasabah,
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'jumlah_pinjaman' => $jumlah_pinjaman,
                                'tgl_pengajuan' => $tgl_pengajuan,
                                'keterangan_pengajuan' => 0,
                            ]);
                        
                        $id_pengajuan = $this->db->insert_id();

                        if($id_jaminan_shm != ''){
                            $this->db->insert('tbl_daftar_jaminan', [
                                    'id_pengajuan' => $id_pengajuan,
                                    'id_jaminan' => $id_jaminan_shm,
                                    'luas_tanah' => $luas_tanah,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                            ]);

                        }else{

                            $this->db->insert('tbl_daftar_jaminan', [
                                    'id_pengajuan' => $id_pengajuan,
                                    'id_jaminan' => $id_jaminan,
                                    'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                    'atas_nama' => $atas_nama,
                                    'dimiliki_tahun' => $dimiliki_tahun,
                                    'harga_beli' => $harga_beli,
                                    'diperoleh_dengan' => $diperoleh_dengan,
                            ]);
                        }
                        
                        $id_daftar_jaminan = $this->db->insert_id();

                        foreach($foto_jaminan as $nama){
                            $this->db->insert('tbl_daftar_foto_jaminan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'foto_jaminan' => $nama,
                            ]);
                        }

                        foreach($foto_bpkb as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'BPKB',
                                'foto_surat' => $nama,
                            ]);
                        }
                        
                        foreach($foto_stnk as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'STNK',
                                'foto_surat' => $nama,
                            ]);
                        }

                        foreach($foto_shm as $nama){
                            $this->db->insert('tbl_daftar_foto_surat_kepemilikan', [
                                'id_daftar_jaminan' => $id_daftar_jaminan,
                                'nama_surat' => 'SHM/SHGB',
                                'foto_surat' => $nama,
                            ]);
                        }

                        //update diajukan
                        $dataHist = $this->db->query('SELECT * FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b 
                            ON a.id_nasabah = b.id_nasabah INNER JOIN tbl_penawaran_kredit c 
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$id_nasabah.'
                            AND c.id_jenis_kredit = '.$id_jenis_kredit)->row_array();
                        
                        if(!empty($dataHist)){
                            $this->db->set([
                            'diajukan'=> 1
                            ]);
                            $this->db->where('id_history',$dataHist['id_history']);
                            $this->db->update('tbl_history_penawaran');

                        }

                    } else {
                        // rubah tgl pengajuan menjadi format angka
                        $tgl_pengajuan=time();
                        
                        $this->db->insert('tbl_pengajuan_kredit', [
                                'id_nasabah' => $id_nasabah,
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'jumlah_pinjaman' => $jumlah_pinjaman,
                                'tgl_pengajuan' => $tgl_pengajuan,
                                'keterangan_pengajuan' => 0,
                            ]);
                        
                        $id_pengajuan = $this->db->insert_id();

                        $this->db->insert('tbl_daftar_jaminan', [
                                'id_pengajuan' => $id_pengajuan,
                                'id_jaminan' => $id_jaminan,
                                'nomor_surat_kepemilikan' => $nomor_surat_kepemilikan,
                                'atas_nama' => $atas_nama,
                                'dimiliki_tahun' => $dimiliki_tahun,
                                'harga_beli' => $harga_beli,
                                'diperoleh_dengan' => $diperoleh_dengan,
                        ]);

                    }

                    //update diajukan
                        $dataHist = $this->db->query('SELECT * FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b 
                            ON a.id_nasabah = b.id_nasabah INNER JOIN tbl_penawaran_kredit c 
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$id_nasabah.'
                            AND c.id_jenis_kredit = '.$id_jenis_kredit)->row_array();
                        
                        if(!empty($dataHist)){
                            $this->db->set([
                            'diajukan'=> 1
                            ]);
                            $this->db->where('id_history',$dataHist['id_history']);
                            $this->db->update('tbl_history_penawaran');

                        }
                        
                    // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    your data has been added!
                    </div><br>');
        
                    redirect('kredit/listPengajuanKredit');

                }
           
            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            your data has been added!
            </div><br>');

            redirect('kredit/listPengajuanKredit');
        }
    }

    // detail pengajuan kredit sama dengan di user
    public function pengajuanKreditDetail()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_nasabah = $this->input->post('id_nasabah');
        
        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_nasabah'=>$id_nasabah])->row_array();

        $data['user'] = $this->db->get_where('user', [
            'id_user' =>  $data['nasabah']['id_user'],
        ])->row_array();


        $data['pengajuan'] = $this->db->query('SELECT * from tbl_nasabah,tbl_pengajuan_kredit,user,tbl_jenis_kredit
                where tbl_pengajuan_kredit.id_pengajuan='.$id_pengajuan.' 
                AND user.id_user = tbl_nasabah.id_user 
                AND tbl_pengajuan_kredit.id_nasabah = tbl_nasabah.id_nasabah
                AND tbl_jenis_kredit.id_jenis_kredit = tbl_pengajuan_kredit.id_jenis_kredit'
                )->row_array();
        $data['daftar_jaminan'] = $this->db->query('SELECT * from tbl_daftar_jaminan a INNER JOIN tbl_jaminan b ON a.id_jaminan = b.id_jaminan 
                INNER JOIN tbl_daftar_foto_jaminan c on c.id_daftar_jaminan = a.id_daftar_jaminan WHERE a.id_pengajuan = '.$id_pengajuan
                )->result_array();

        $data['daftar_surat_jaminan'] = $this->db->query('SELECT * from tbl_daftar_jaminan a INNER JOIN tbl_daftar_foto_surat_kepemilikan c 
                on c.id_daftar_jaminan = a.id_daftar_jaminan WHERE a.id_pengajuan = '.$id_pengajuan
                )->result_array();

        $data['pengajuan']['tgl_pengajuan'] = date('d-m-Y',$data['pengajuan']['tgl_pengajuan']);

        echo json_encode($data);
    }

    public function lihatDetailPengajuan()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $data_pengajuan = $this->db->query('SELECT * from tbl_nasabah,tbl_pengajuan_kredit,user,tbl_jenis_kredit
                where tbl_pengajuan_kredit.id_pengajuan='.$id_pengajuan.' 
                AND user.id_user = tbl_nasabah.id_user 
                AND tbl_pengajuan_kredit.id_nasabah = tbl_nasabah.id_nasabah
                AND tbl_jenis_kredit.id_jenis_kredit = tbl_pengajuan_kredit.id_jenis_kredit'
                )->row_array();
        
        $data_pengajuan['tgl_pengajuan'] = date('d-m-Y',$data_pengajuan['tgl_pengajuan']);

        echo json_encode($data_pengajuan);
    }

    //validasi pengajuan kredit
    public function validasiPengajuanKredit()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        // $id_ao = $this->input->post('id_ao');

        $this->db->set([
            'keterangan_pengajuan' => 3,
            // 'id_ao' =>$id_ao
        ]);

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->update('tbl_pengajuan_kredit');


        // cek apakah kredit promo
        $data['pengajuan'] = $this->db->query('SELECT * FROM tbl_pengajuan_kredit a 
                INNER JOIN tbl_jenis_kredit b ON a.id_jenis_kredit = b.id_jenis_kredit 
                INNER JOIN tbl_penawaran_kredit c on c.id_jenis_kredit = a.id_jenis_kredit
                WHERE b.status = 1 AND a.id_pengajuan = '.$id_pengajuan)->row_array();
    
        
        // // update pengajuan promo
        // if(!empty($data['pengajuan'])){
        //     $this->db->set([
        //         'terealisasi'=>1
        //     ]);
        //     $this->db->where([
        //         'id_nasabah'=>$data['pengajuan']['id_nasabah'],
        //         'id_penawaran'=>$data['pengajuan']['id_penawaran']
        //     ]);
        //     $this->db->update('tbl_history_penawaran');
        // }

        // //insert into tbl_kredit
        // $this->db->insert('tbl_kredit', [
        //     'id_pengajuan' => $id_pengajuan,
        //     'lunas' => 0,
        //     'tgl_realisasi_kredit' => time(), //ini buat apa?
        // ]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Berhasil validasi 1 pengajuan kredit!
        </div><br>');

        // membuat pemberitahuan pendaftaran admin untuk super admin
            $data['pengajuan_kredit'] = $this->db->get_where('tbl_pengajuan_kredit',['id_pengajuan'=>$id_pengajuan])->row_array();
            $data['user'] = $this->db->get_where('tbl_nasabah',['id_nasabah'=>$data['pengajuan_kredit']['id_nasabah']])->row_array();

            $this->db->insert('notifikasi', [
                'id_user' => $data['user']['id_user'],
                'judul' => 'Pengajuan Kredit',
                'url' => 'Pelayanan/tambahPengajuanKredit',
                'keterangan' => 'Pengajuan Kredit valid.',
                'icon' => "fas fa-hand-holding-usd"
            ]);

            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );

            $pusher = new Pusher\Pusher(
                '8459db692d2df931dcd7',
                'ddd443ba03d8e782dde8',
                '1444015',
                $options
            );

            $pesan['message'] = 'Validasi Pengajuan Kredit';
            $pusher->trigger('my-channel2', 'my-event2', $pesan);

        redirect('kredit/listPengajuanKredit');
    }

    //tidak validasi pengajuan kredit
    public function tidakvalidasiPengajuanKredit()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->set('keterangan_pengajuan', 4);
        $this->db->update('tbl_pengajuan_kredit');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Satu pengajuan kredit tidak valid!
        </div><br>');

        redirect('kredit/listPengajuanKredit');
    }

    //terima pengajuan kredit
    public function terimaPengajuanKredit()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $id_ao = $this->input->post('id_ao');

        $this->db->set([
            'keterangan_pengajuan' => 1,
            'id_ao' =>$id_ao
        ]);

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->update('tbl_pengajuan_kredit');


        // cek apakah kredit promo
        $data['pengajuan'] = $this->db->query('SELECT * FROM tbl_pengajuan_kredit a 
                INNER JOIN tbl_jenis_kredit b ON a.id_jenis_kredit = b.id_jenis_kredit 
                INNER JOIN tbl_penawaran_kredit c on c.id_jenis_kredit = a.id_jenis_kredit
                WHERE b.status = 1 AND a.id_pengajuan = '.$id_pengajuan)->row_array();
    
        
        // update pengajuan promo
        if(!empty($data['pengajuan'])){
            $this->db->set([
                'terealisasi'=>1
            ]);
            $this->db->where([
                'id_nasabah'=>$data['pengajuan']['id_nasabah'],
                'id_penawaran'=>$data['pengajuan']['id_penawaran']
            ]);
            $this->db->update('tbl_history_penawaran');
        }

        //insert into tbl_kredit
        $this->db->insert('tbl_kredit', [
            'id_pengajuan' => $id_pengajuan,
            'lunas' => 0,
            'tgl_realisasi_kredit' => time(), //ini buat apa?
        ]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        berhasil menerima 1 pengajuan kredit!
        </div><br>');

        // membuat pemberitahuan pendaftaran admin untuk super admin
            $data['pengajuan_kredit'] = $this->db->get_where('tbl_pengajuan_kredit',['id_pengajuan'=>$id_pengajuan])->row_array();
            $data['user'] = $this->db->get_where('tbl_nasabah',['id_nasabah'=>$data['pengajuan_kredit']['id_nasabah']])->row_array();

            $this->db->insert('notifikasi', [
                'id_user' => $data['user']['id_user'],
                'judul' => 'Pengajuan Kredit',
                'url' => 'Pelayanan/tambahPengajuanKredit',
                'keterangan' => 'Pengajuan Kredit diterima.',
                'icon' => "fas fa-hand-holding-usd"
            ]);

            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );

            $pusher = new Pusher\Pusher(
                '8459db692d2df931dcd7',
                'ddd443ba03d8e782dde8',
                '1444015',
                $options
            );

            $pesan['message'] = 'Terima Pengajuan Kredit';
            $pusher->trigger('my-channel2', 'my-event2', $pesan);

        redirect('kredit/listPengajuanKredit');
    }

    //tolak pengajuan kredit
    public function tolakPengajuanKredit()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->set('keterangan_pengajuan', 2);
        $this->db->update('tbl_pengajuan_kredit');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        berhasil menolak 1 pengajuan kredit!
        </div><br>');

        redirect('kredit/listPengajuanKredit');
    }

    //batalkan pengajuan kredit
    public function batalkanPengajuanKredit()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');

        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->set('keterangan_pengajuan', 0);
        $this->db->update('tbl_pengajuan_kredit');
        
        $this->db->where('id_pengajuan', $id_pengajuan);
        $this->db->delete('tbl_kredit');

        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
        berhasil mambatalkan 1 proses pengajuan kredit!
        </div><br>');

        redirect('kredit/listPengajuanKredit');
    }

    public function listKreditActiveDetail()
    {

        $id_kredit = $this->input->post('id_transaksi_kredit');
        $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
        inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
        on e.id_jenis_kredit = b.id_jenis_kredit where a.id_transaksi_kredit='.$id_kredit.' order by id_transaksi_kredit ASC;')->row_array();

        $data['kreditActive']['tgl_pengajuan'] = date('d-m-Y',$data['kreditActive']['tgl_pengajuan']);
        $data['kreditActive']['tgl_realisasi_kredit'] = date('d-m-Y',$data['kreditActive']['tgl_realisasi_kredit']);

        if($data['kreditActive']['lunas'] == 0){

            $data['kreditActive']['lunas'] = 'Belum Lunas';
        }else{
            
            $data['kreditActive']['lunas'] = 'Sudah Lunas';
        }


        echo json_encode($data['kreditActive']);
    }

    public function getDataChartKreditActive(){
        $tahun_ini = strtotime('01-01-'.date('Y'));

        $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
            inner join tbl_jenis_kredit e on e.id_jenis_kredit = b.id_jenis_kredit and a.tgl_realisasi_kredit >= '.$tahun_ini.' 
            order by id_transaksi_kredit DESC;')->result_array();

        $monthName = [
            "January", "February", "March",
            "April", "May", "June",
            "July", "August", "September",
            "October", "November", "December"
        ];

        foreach( $monthName as $mn){

            $totalRegular   =   0 ;
            $totalPromo     =   0 ;
            $totalSemua     =   0 ;

            if(!isset($jumlah[$mn])){
                $jumlah[$mn] = [];
            }

            foreach($data['kreditActive'] as $ka){

                if(date('F',$ka['tgl_realisasi_kredit']) == $mn ){

                    if($ka['status'] == 1){
                        $totalPromo += $ka['jumlah_pinjaman'];
                        
                    }else{
                        $totalRegular += $ka['jumlah_pinjaman'];
                        
                    }
                }
            }

            $totalSemua = $totalPromo+$totalRegular;

            $jumlah[$mn]['regular'] = $totalRegular;
            $jumlah[$mn]['promo'] = $totalPromo;
            $jumlah[$mn]['semua'] = $totalSemua;

        }


        echo json_encode($jumlah);       

    }

    public function listKreditActive()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Kredit Active (Berjalan)';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        // jika data nasabah sudah ada
        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit")->result_array(); //hanya kredit yang bukan promo yang muncul di pengajuan kredit
            
        $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
        inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
        on e.id_jenis_kredit = b.id_jenis_kredit order by id_transaksi_kredit DESC;')->result_array();

         // mancari data kredit bermasalah
         // data untuk menentukan persentase kemacetan
         $data['total_terealisasikan'] = 0;
         $data['total_kredit_lancar'] = 0;
         $data['total_kredit_macet'] = 0;
         $data['persentase_kemacetan'] = 0;

         $i =0;
        foreach($data['kreditActive'] as $ka){

            $kredit_bunga = 'Kredit Bunga-Bunga 6 Bulan';
            $tgl_realisasi = $ka['tgl_realisasi_kredit'];
            $bunga_persen = $ka['jumlah_bunga_persen'];
            $denda_persen = $ka['denda_kredit'];
            $total_bulan_angsuran = $ka['total_angsuran_bulan'];

            $daftar_angsuran = $this->db->get_where('tbl_angsuran_kredit', [
                'id_transaksi_kredit'=>$ka['id_transaksi_kredit'],
                'keterangan_angsuran'=> 1
            ])->result_array();

            $jumlah_mengangsur_real = count($daftar_angsuran); // jumlah angsuran
            $data['kreditActive'][$i]['jumlah_mengangsur_nasabah'] = $jumlah_mengangsur_real;
            
            $tgl_jatuh_tempo = strtotime('+'.($jumlah_mengangsur_real+1).' months', $tgl_realisasi); // tgl jatuh tempo int 1988721987
            $data['kreditActive'][$i]['tgl_jatuh_tempo'] = date('d-M-Y',$tgl_jatuh_tempo);

            $bulan_realisasi = date('n', $tgl_realisasi);
            $tahun_realisasi = date('Y', $tgl_realisasi);
            $bulan_ini = date('n', time());
            $tahun_ini = date('Y', time());

            $jumlah_mengangsur_seharusnya = ($tahun_ini - $tahun_realisasi) * 12 + ($bulan_ini - $bulan_realisasi);
            if($jumlah_mengangsur_seharusnya > $total_bulan_angsuran ){
                $jumlah_mengangsur_seharusnya = $total_bulan_angsuran;
            }
            $data['kreditActive'][$i]['jumlah_mengangsur_seharusnya'] = $jumlah_mengangsur_seharusnya;

            $telat_bulan = $jumlah_mengangsur_seharusnya - $jumlah_mengangsur_real; // banyak bulan nunggak
             if($telat_bulan <=0 ){
                $telat_bulan = 0;
            }

            // kredit hanya akan masuk dalam kemacetan apabila sudah menunggak selama 3 bulan
            if($telat_bulan >= 3){

                $data['total_kredit_macet'] += $ka['jumlah_pinjaman'];
                $data['total_terealisasikan'] += $ka['jumlah_pinjaman'];
            }else{

                $data['total_kredit_lancar'] += $ka['jumlah_pinjaman'];
                $data['total_terealisasikan'] += $ka['jumlah_pinjaman'];
            }

            $data['persentase_kemacetan'] = $data['total_kredit_macet'] / $data['total_terealisasikan']*100;

            $data['kreditActive'][$i]['telat_bulan'] = $telat_bulan;

            $secondsInDay = 60 * 60 * 24; // Jumlah detik dalam satu hari
            
            $telat_hari = floor((time()-$tgl_jatuh_tempo)/$secondsInDay);
            if($telat_hari <=0 ){
                $telat_hari = 0;
            }
            $data['kreditActive'][$i]['telat_hari'] = $telat_hari;


            $total_tunggakan_angsuran_pokok = 0;
            $total_tunggakan_angsuran_bunga = 0;
            $total_tunggakan_angsuran_bulanan = 0;
            $total_tunggakan_angsuran_semuanya = 0;

            if($ka['nama_kredit'] == $kredit_bunga){
                // kredit bunga2 6 bulan

                $jumlah_pokok = 0;
                $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;
                $denda_perhari = $jumlah_bayar_perbulan*$denda_persen/100;
                $denda_pokok = 0;
                
                for($a = $jumlah_mengangsur_real+1;$a <= $jumlah_mengangsur_seharusnya; $a++){

                    if($a == 6){
                        // angsuran terakhir plus pokok
                        $jumlah_pokok_akhir = $ka['jumlah_pinjaman'];
                        $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                        $jumlah_bayar_perbulan_akhir =  $jumlah_pokok_akhir+$jumlah_bunga;

                        $tgl_jatuh_tempo_pokok = strtotime('+6 months', $tgl_realisasi);
                        $telat_bayar_pokok_hari = floor((time()-$tgl_jatuh_tempo_pokok)/$secondsInDay);
                        if($telat_bayar_pokok_hari <=0 ){
                            $telat_bayar_pokok_hari = 0;
                        }
                        $data['kreditActive'][$i]['telat_bayar_pokok_hari'] = $telat_bayar_pokok_hari;
                        $data['kreditActive'][$i]['tgl_jatuh_tempo_pokok'] = date('d-M-Y',$tgl_jatuh_tempo_pokok);

                        $denda_pokok = $telat_bayar_pokok_hari*($jumlah_pokok_akhir*$denda_persen/100);

                        $total_tunggakan_angsuran_pokok += $jumlah_pokok_akhir;
                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan_akhir;

                    }else{

                        $jumlah_pokok = 0;
                        $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                        $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;

                        $total_tunggakan_angsuran_pokok += $jumlah_pokok;
                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan;

                    }
                }

                $data['kreditActive'][$i]['jumlah_pokok'] =  $jumlah_pokok;
                $data['kreditActive'][$i]['jumlah_bunga'] = $jumlah_bunga;
                $data['kreditActive'][$i]['jumlah_bayar_perbulan'] = $jumlah_bayar_perbulan;
                $data['kreditActive'][$i]['denda_perhari'] = $denda_perhari;

                $data['kreditActive'][$i]['total_tunggakan_angsuran_pokok'] = $total_tunggakan_angsuran_pokok;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bunga'] = $total_tunggakan_angsuran_bunga;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bulanan'] = $total_tunggakan_angsuran_bulanan;

                $total_denda = ($denda_perhari * $telat_hari) + $denda_pokok;
                $data['kreditActive'][$i]['total_denda'] = $total_denda;

                $total_tunggakan_angsuran_semuanya = $total_tunggakan_angsuran_bulanan + $total_denda;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_semuanya'] = $total_tunggakan_angsuran_semuanya;

            }else{
                // kredit reguler
                
                $jumlah_pokok = $ka['jumlah_pinjaman'] / $total_bulan_angsuran;
                $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;
                $denda_perhari = $jumlah_bayar_perbulan*$denda_persen/100;

                for($a = $jumlah_mengangsur_real+1;$a <= $jumlah_mengangsur_seharusnya; $a++){


                        $total_tunggakan_angsuran_pokok += $jumlah_pokok;

                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan;
                  
                }

                $data['kreditActive'][$i]['jumlah_pokok'] =  $jumlah_pokok;
                $data['kreditActive'][$i]['jumlah_bunga'] = $jumlah_bunga;
                $data['kreditActive'][$i]['jumlah_bayar_perbulan'] = $jumlah_bayar_perbulan;
                $data['kreditActive'][$i]['denda_perhari'] = $denda_perhari;

                $data['kreditActive'][$i]['total_tunggakan_angsuran_pokok'] = $total_tunggakan_angsuran_pokok;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bunga'] = $total_tunggakan_angsuran_bunga;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bulanan'] = $total_tunggakan_angsuran_bulanan;

                $total_denda = $denda_perhari * $telat_hari;
                $data['kreditActive'][$i]['total_denda'] = $total_denda;

                $total_tunggakan_angsuran_semuanya = $total_tunggakan_angsuran_bulanan + $total_denda;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_semuanya'] = $total_tunggakan_angsuran_semuanya;
            }
            

            
            $i++;
        }


        $data['ao'] = $this->db->get_where('user',['role_id' => 4])->result_array();

        $this->form_validation->set_rules('total_angsuran_bulan', 'Angsuran', 'required');
        $this->form_validation->set_rules('jumlah_bunga_persen', 'Bunga', 'required');
        $this->form_validation->set_rules('nama_kredit', 'Kredit', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/kredit_active.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            $id_jenis_kredit = $this->input->post('id_jenis_kredit');
            $total_angsuran_bulan = $this->input->post('total_angsuran_bulan');
            $jumlah_bunga_persen = $this->input->post('jumlah_bunga_persen');
            $nama_kredit = $this->input->post('nama_kredit');

            $this->db->insert('tbl_jenis_kredit', [
                'total_angsuran_bulan' => $total_angsuran_bulan,
                'jumlah_bunga_persen' => $jumlah_bunga_persen,
                'nama_kredit' => $nama_kredit,
            ]);
            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            your data has been added!
            </div><br>');

            redirect('kredit/listKreditActive');
        }
    }

    function lihatbukupinjaman($id_transaksi_kredit = null,$id_nasabah = null){
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();

        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' 
            order by tanggal desc limit 6;')->result_array();

        // mengambil daftar mesin
        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_nasabah'=>$id_nasabah])->row_array();
        
        $data['kredit'] = $this->db->query('select * from tbl_nasabah a, tbl_pengajuan_kredit b, tbl_kredit c , tbl_jenis_kredit e 
                                            where a.id_nasabah = b.id_nasabah and b.id_pengajuan = c.id_pengajuan 
                                            and b.id_jenis_kredit = e.id_jenis_kredit 
                                            and a.id_nasabah ='. $data['nasabah']['id_nasabah'] .'  
                                            and c.id_transaksi_kredit ='.$id_transaksi_kredit)->row_array();

        $data['angsuran'] = $this->db->query('select * from tbl_nasabah a, tbl_pengajuan_kredit b, tbl_kredit c, 
                                            tbl_angsuran_kredit d , tbl_jenis_kredit e 
                                            where a.id_nasabah = b.id_nasabah and b.id_pengajuan = c.id_pengajuan 
                                            and b.id_jenis_kredit = e.id_jenis_kredit and c.id_transaksi_kredit=d.id_transaksi_kredit 
                                            and a.id_nasabah ='. $data['nasabah']['id_nasabah'] .'  
                                            and c.id_transaksi_kredit ='.$id_transaksi_kredit.'  
                                            and d.keterangan_angsuran=1 ORDER by d.id_angsuran ASC')->result_array();

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Buku Angsuran-" . $data['user']['name'] . "-" . date('m-d-Y',time()) . ".pdf";
        $this->pdf->load_view('buku_pinjaman', $data);
    }

    public function angsuranKredit()
    {
        
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Angsuran Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah, user where tbl_nasabah.id_user=user.id_user ;')->result_array();
       

        $data['angsuranKredit'] = $this->db->query('select * from tbl_angsuran_kredit a INNER JOIN tbl_kredit b 
                        ON a.id_transaksi_kredit = b.id_transaksi_kredit INNER JOIN tbl_pengajuan_kredit c ON b.id_pengajuan = c.id_pengajuan 
                        INNER JOIN tbl_nasabah d ON d.id_nasabah = c.id_nasabah INNER JOIN user e 
                        ON e.id_user = d.id_user order by a.id_angsuran DESC;')->result_array();

        $this->form_validation->set_rules('id_transaksi_kredit', 'id_transaksi_kredit', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('kredit/angsuran_kredit.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            $id_transaksi_kredit = $this->input->post('id_transaksi_kredit');
            $tanggal = $this->input->post('tgl_mengangsur');
            $jumlah_pokok = $this->input->post('jumlah_pokok_angsuran');
            $jumlah_bunga = $this->input->post('jumlah_bunga_angsuran');
            $denda = $this->input->post('denda_total');
            $tgl_jatuh_tempo = $this->input->post('tgl_jatuh_tempo');
            $status_keterlambatan = $this->input->post('status_keterlambatan');

            $data_kredit = $this->db->query('select * from tbl_kredit where id_transaksi_kredit='.$id_transaksi_kredit.';')->row_array();
            // $angsuran_ke = $this->db->query('select count(id_angsuran) as total_angsuran from tbl_angsuran_kredit where id_transaksi_kredit ='.$data_kredit['id_transaksi_kredit'])->row_array();
        
            $upload_image = $_FILES["bukti_angsuran"];
            $nama_image = $upload_image['name'];

            if ($nama_image) {
                $config['upload_path'] = './assets/img/angsuran/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('bukti_angsuran')) {
                    // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data

                    $gbr = $this->upload->data();

                    $this->db->insert('tbl_angsuran_kredit', [
                        'id_transaksi_kredit' => $id_transaksi_kredit,
                        'tanggal' => strtotime($tanggal),// ubah tgl kebentuk integer
                        'jumlah_pokok' => intval($jumlah_pokok),
                        'jumlah_bunga' => intval($jumlah_bunga),
                        'denda' => intval($denda),
                        'bukti_angsuran' =>  $gbr['file_name'],
                        'tgl_jatuh_tempo' => strtotime($tgl_jatuh_tempo),
                        'status_keterlambatan' =>  $status_keterlambatan,
                        'keterangan_angsuran' => 0,
                    ]);

                    // $data = $this->getDataTagihanPembayaran($id_transaksi_kredit,'data');


                    // update status_keterlambatan
                    $insert_id = $this->db->insert_id();

                    

                    // echo('tgl jatuh tempo :'.date('Y-m-d',$tgl_jatuh_tempo).'<br>');
                    // echo('tgl bayar :'.$tanggal_bayar.'<br>');
                    // echo('jumlah_keterlambatan_hari :'.$jumlah_keterlambatan_hari.'<br>');
                    // die;

                    

                    // $this->db->set([
                    //     'status_keterlambatan' =>  $data['angsuran']['status_keterlambatan'],
                    //     'tgl_jatuh_tempo' => $data['angsuran']['tgl_jatuh_tempo'],
                    // ]);

                    // $this->db->where([
                    //     'id_angsuran' => $insert_id
                    // ]);

                    // $this->db->update('tbl_angsuran_kredit');

                    redirect('kredit/angsuranKredit');

                } else {
                    echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
            } else {
            
                // $this->db->insert('tbl_angsuran_kredit', [
                //     'id_transaksi_kredit' => $id_transaksi_kredit,
                //     'tanggal' => $tanggal,
                //     'jumlah_pokok' => $jumlah_pokok,
                //     'jumlah_bunga' => $jumlah_bunga,
                //     'denda' => $denda,
                //     'bukti_angsuran' =>  $gbr['file_name'],
                //     'keterangan_angsuran' => 0,
                // ]);

            redirect('kredit/angsuranKredit');
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            berhasil membayar angsuran!
            </div><br>');

            redirect('kredit/angsuranKredit');
        }
    }

    public function carikredit()
    {
        $id_nasabah = $this->input->post('id_nasabah');

        $data_kredit = $this->db->query('SELECT * from tbl_kredit,tbl_nasabah,tbl_pengajuan_kredit,tbl_jenis_kredit, user
        where tbl_kredit.id_pengajuan = tbl_pengajuan_kredit.id_pengajuan and 
        tbl_pengajuan_kredit.id_nasabah = tbl_nasabah.id_nasabah and 
        tbl_pengajuan_kredit.id_jenis_kredit = tbl_jenis_kredit.id_jenis_kredit and 
        user.id_user = tbl_nasabah.id_user and 
        tbl_nasabah.id_nasabah ='.$id_nasabah.' order by tbl_kredit.id_transaksi_kredit DESC;')->result_array();

        // echo json_encode($id_nasabah);
        // var_dump($data_kredit);
        // die;
        echo json_encode($data_kredit);
    }

     public function getDataModalPembayaran()
    {
        $id_transaksi_kredit = $this->input->post('id_transaksi_kredit');
        $id_angsuran = $this->input->post('id_angsuran');
        // $id_transaksi_kredit = 12;
  
        $data = $this->getDataTagihanPembayaran($id_transaksi_kredit,'json',$id_angsuran);

        echo json_encode($data);
    }

    public function getDataTagihanPembayaran($idkredit,$tipeNeeded,$id_angsuran=null){
        
        $idkredit = $idkredit;
        $data['kredit'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
                        inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
                        on e.id_jenis_kredit = b.id_jenis_kredit where a.id_transaksi_kredit='.$idkredit.'
                        order by a.id_transaksi_kredit DESC;')->row_array();

        $data['angsuran'] = $this->db->query('select COUNT(tbl_angsuran_kredit.id_angsuran) as jumlahmengangsur, 
                        sum(tbl_angsuran_kredit.jumlah_pokok) as totalpokok, sum(tbl_angsuran_kredit.jumlah_bunga) as totalbunga, 
                        sum(tbl_angsuran_kredit.denda) as totaldenda from tbl_angsuran_kredit 
                        where tbl_angsuran_kredit.keterangan_angsuran=1 and tbl_angsuran_kredit.id_transaksi_kredit ='.$data['kredit']['id_transaksi_kredit'])->row_array();

        $status_konfirmasi_angsuran_terakhir = $this->db->query('select keterangan_angsuran from tbl_angsuran_kredit where id_transaksi_kredit='.$data['kredit']['id_transaksi_kredit'].' order by id_angsuran DESC limit 1;')->row_array();
        
        $data['angsuran']['angsuran_ke'] = intval( $data['angsuran']['jumlahmengangsur'])+1;

        // data untuk edit angsuran
       if($id_angsuran != null){

            // mencari data angsuran keberapa
            $data_angsuran = $this->db->get_where('tbl_angsuran_kredit',['id_angsuran'=>$id_angsuran])->row_array();

            $data_semua_angsuran_diterima = $this->db->query('select * from tbl_angsuran_kredit a 
                        where a.keterangan_angsuran=1 and 
                        a.id_transaksi_kredit='.$data['kredit']['id_transaksi_kredit'].' order by a.id_angsuran ASC;')->result_array();
            $count = 1;

            if($data_angsuran['keterangan_angsuran'] != 2){

                // data edit karena angsuran tidak ditolak
                foreach($data_semua_angsuran_diterima as $dt){

                    if($dt['id_angsuran'] == $id_angsuran){
                        $data['angsuran']['angsuran_ke'] = $count;
                        break;
                    }

                    $count ++;
                
                }
            }else{

                // angsuran ditolak ket = 2
                $data['angsuran']['angsuran_ke'] = 'Angsuran Ditolak';
            }
            
            

            $data['angsuran_for_edit'] = $this->db->get_where('tbl_angsuran_kredit',['id_angsuran'=>$id_angsuran])->row_array();

            if($data['angsuran_for_edit']['tanggal'] > $data['angsuran_for_edit']['tgl_jatuh_tempo']){

                $data['angsuran_for_edit']['jumlah_keterlambatan_hari'] =   ($data['angsuran_for_edit']['tanggal'] - $data['angsuran_for_edit']['tgl_jatuh_tempo'])/60*60*24;
                
                $data['angsuran_for_edit']['tanggal'] = date('d-F-Y', $data['angsuran_for_edit']['tanggal']);
                $data['angsuran_for_edit']['tgl_jatuh_tempo'] = date('d-F-Y', $data['angsuran_for_edit']['tgl_jatuh_tempo']);
            }else{
                $data['angsuran_for_edit']['jumlah_keterlambatan_hari'] =  0;
                
                $data['angsuran_for_edit']['tanggal'] = date('d-F-Y', $data['angsuran_for_edit']['tanggal']);
                $data['angsuran_for_edit']['tgl_jatuh_tempo'] = date('d-F-Y', $data['angsuran_for_edit']['tgl_jatuh_tempo']);
            }
       }

        if($status_konfirmasi_angsuran_terakhir){
            $data['angsuran']['keterangan_angsuran_terakhir'] = $status_konfirmasi_angsuran_terakhir['keterangan_angsuran'];
        }else{
            $data['angsuran']['keterangan_angsuran_terakhir'] = 0;
        }

        // ['tgljatuhtempo'] ini tidak bisa mendapatkan tanggal yang tepat 22-06-2022
        // $data['angsuran']['tgljatuhtempo'] = intval( $data['kredit']['tgl_realisasi_kredit']) + 60*60*24*30*((intval($data['angsuran']['jumlahmengangsur']))+1);
                
        $bulan = ((intval(date('m',$data['kredit']['tgl_realisasi_kredit']))) + ((intval($data['angsuran']['jumlahmengangsur']))+1))%12;
        if($bulan == 0){
            $bulan = 12;
        }

        $tanggal = date('d',$data['kredit']['tgl_realisasi_kredit']);

        $tahun = intval(date('Y',intval($data['kredit']['tgl_realisasi_kredit'])+60*60*24*30*(intval($data['angsuran']['jumlahmengangsur'])+1)));
        $data['angsuran']['tgl_jatuh_tempo'] = strtotime($tanggal.'-'.$bulan.'-'.$tahun);
        $data['angsuran']['jumlah_keterlambatan_hari'] = floor((time() - $data['angsuran']['tgl_jatuh_tempo'])/(60*60*24));

        if($data['angsuran']['jumlah_keterlambatan_hari'] > 0){
                    $data['angsuran']['status_keterlambatan'] = 0;
        }else{
                    $data['angsuran']['status_keterlambatan'] = 1;
                    $data['angsuran']['jumlah_keterlambatan_hari'] = 0;
        }

        // membuat data detail angsuran
        $data['detailangsuran']['angsuran'] = array();

        if($data['kredit']['nama_kredit'] == 'Kredit Bunga-Bunga 6 Bulan'){
            $data['angsuran']['jumlah_bunga_angsuran'] =  ceil($data['kredit']['jumlah_bunga_persen']*$data['kredit']['jumlah_pinjaman']/100);

            if((int)$data['angsuran']['jumlahmengangsur'] == 5){
                $data['angsuran']['jumlah_pokok_angsuran'] = $data['kredit']['jumlah_pinjaman'];
                
            }else{
                $data['angsuran']['jumlah_pokok_angsuran'] = 0;

            }

            // menambahkan data daftar angsuran 
            $data['detailangsuran']['angsuran'][] = '5 X Rp. '.number_format($data['angsuran']['jumlah_bunga_angsuran'],0,',','.',);
            $data['detailangsuran']['angsuran'][] = '1 X Rp. '.number_format($data['kredit']['jumlah_pinjaman']+$data['angsuran']['jumlah_bunga_angsuran'],0,',','.',);
            
            $data['detailangsuran']['pokokpinjaman'] = number_format($data['kredit']['jumlah_pinjaman'],0,',','.',);
            $data['detailangsuran']['bunga'] = number_format($data['angsuran']['jumlah_bunga_angsuran']*$data['kredit']['total_angsuran_bulan'],0,',','.',);
            $data['detailangsuran']['totalpinjaman'] = number_format($data['angsuran']['jumlah_bunga_angsuran']*$data['kredit']['total_angsuran_bulan']+$data['kredit']['jumlah_pinjaman'],0,',','.',);

        }else{
            $data['angsuran']['jumlah_bunga_angsuran'] =  ceil($data['kredit']['jumlah_bunga_persen']*$data['kredit']['jumlah_pinjaman']/100);
            $data['angsuran']['jumlah_pokok_angsuran'] = ceil($data['kredit']['jumlah_pinjaman']/$data['kredit']['total_angsuran_bulan']);   
            
            // menambahkan data daftar angsuran 
            $data['detailangsuran']['angsuran'][] = $data['kredit']['total_angsuran_bulan'].' X Rp. '.number_format($data['angsuran']['jumlah_bunga_angsuran']+$data['angsuran']['jumlah_pokok_angsuran'],0,',','.',);
            
            $data['detailangsuran']['pokokpinjaman'] = number_format($data['kredit']['jumlah_pinjaman'],0,',','.',);
            $data['detailangsuran']['bunga'] = number_format($data['angsuran']['jumlah_bunga_angsuran']*$data['kredit']['total_angsuran_bulan'],0,',','.',);
            $data['detailangsuran']['totalpinjaman'] = number_format($data['angsuran']['jumlah_bunga_angsuran']*$data['kredit']['total_angsuran_bulan']+$data['kredit']['jumlah_pinjaman'],0,',','.',);

            
        }
        
        $data['angsuran']['denda_perhari'] = ceil(($data['angsuran']['jumlah_bunga_angsuran']+$data['angsuran']['jumlah_pokok_angsuran'])*(float)$data['kredit']['denda_kredit']/100);
     
        $data['angsuran']['denda_total'] = $data['angsuran']['denda_perhari'] * $data['angsuran']['jumlah_keterlambatan_hari'];
        $data['angsuran']['jumlah_total_angsuran'] = ceil(($data['angsuran']['jumlah_pokok_angsuran'])+($data['kredit']['jumlah_bunga_persen']*$data['kredit']['jumlah_pinjaman']/100)+($data['angsuran']['denda_perhari'] * $data['angsuran']['jumlah_keterlambatan_hari']));
        
        // menambahkan bulan kedalam tanggal
        // $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));
        $data['detailangsuran']['mulaitanggalangs'] =  date('d-m-Y',$data['kredit']['tgl_realisasi_kredit'] ).' s/d '.date('d-m-Y', strtotime("+".$data['kredit']['total_angsuran_bulan']." months", $data['kredit']['tgl_realisasi_kredit']));
        

        // merubah data timenumber menjadi data tanggal pada permintaan json
        if($tipeNeeded == 'json'){
            $data['angsuran']['tgl_jatuh_tempo'] = date('d-m-Y',$data['angsuran']['tgl_jatuh_tempo']);
            $data['angsuran']['tgl_mengangsur'] = date('d-m-Y',time());
            $data['kredit']['tgl_pengajuan'] = date('d-m-Y',$data['kredit']['tgl_pengajuan'] );
            $data['kredit']['tgl_realisasi_kredit'] = date('d-m-Y',$data['kredit']['tgl_realisasi_kredit'] );

        }


        return $data;
    }


    //terima angsuran
    public function terimaAngsuran()
    {
        $id_angsuran = $this->input->post('id_angsuran');

        
        $this->db->where('id_angsuran', $id_angsuran);
        $this->db->set('keterangan_angsuran', 1);
        $this->db->update('tbl_angsuran_kredit');

        $id_transaksi_kredit = $this->db->query('select id_transaksi_kredit from tbl_angsuran_kredit where id_angsuran='.$id_angsuran)->row_array();

        $angsuran_kredit_tepat = $this->db->query('select count(status_keterlambatan) as total from tbl_angsuran_kredit where status_keterlambatan=1 and keterangan_angsuran=1 and id_transaksi_kredit='.$id_transaksi_kredit['id_transaksi_kredit'])->row_array();
        $angsuran_kredit_telat = $this->db->query('select count(status_keterlambatan) as total from tbl_angsuran_kredit where status_keterlambatan=0 and keterangan_angsuran=1 and id_transaksi_kredit='.$id_transaksi_kredit['id_transaksi_kredit'])->row_array();
        
        $persentase_kemacetan = ($angsuran_kredit_tepat['total']/($angsuran_kredit_tepat['total']+$angsuran_kredit_telat['total']))*100;

        $data['jumlah_angsuran'] = $this->db->query('select a.jumlah_pinjaman , sum(c.jumlah_pokok) as jumlah_angsuran_pokok 
                                from tbl_pengajuan_kredit a, tbl_kredit b, tbl_angsuran_kredit c 
                                where a.id_pengajuan = b.id_pengajuan and b.id_transaksi_kredit = c.id_transaksi_kredit 
                                and c.keterangan_angsuran=1 and 
                                c.id_transaksi_kredit='.$id_transaksi_kredit['id_transaksi_kredit'])->row_array();
        
        $jumlah_pokok =   $data['jumlah_angsuran']['jumlah_pinjaman'];
        $jumlah_angsuran_pokok =   $data['jumlah_angsuran']['jumlah_angsuran_pokok'];
        $sisa_pokok = $jumlah_pokok-$jumlah_angsuran_pokok;

        $data['user'] = $this->db->query('SELECT * FROM tbl_kredit a INNER JOIN tbl_pengajuan_kredit b 
            ON a.id_pengajuan = b.id_pengajuan INNER JOIN tbl_nasabah c ON b.id_nasabah =c.id_nasabah 
            INNER JOIN user d on c.id_user = d.id_user WHERE a.id_transaksi_kredit ='.$id_transaksi_kredit['id_transaksi_kredit'])->row_array();


        if($sisa_pokok < 1000){
            $lunas = 1;

            // membuat pemberitahuan pendaftaran admin untuk super admin
            $this->db->insert('notifikasi', [
                'id_user' => $data['user']['id_user'],
                'judul' => 'Pembayaran Angsuran',
                'url' => 'pelayanan/listKreditActive',
                'keterangan' => 'Angsuran diterima, Kredit anda telah lunas.',
                'icon' => "fas fa-check-double"
            ]);

            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );

            $pusher = new Pusher\Pusher(
                '8459db692d2df931dcd7',
                'ddd443ba03d8e782dde8',
                '1444015',
                $options
            );

            $pesan['message'] = 'Pendaftaran Nasabah Baru';
            $pusher->trigger('my-channel2', 'my-event2', $pesan);
            
        }else{
            $lunas = 0;

            // membuat pemberitahuan pendaftaran admin untuk super admin
            $this->db->insert('notifikasi', [
                'id_user' => $data['user']['id_user'],
                'judul' => 'Pembayaran Angsuran',
                'url' => 'pelayanan/angsuranKredit',
                'keterangan' => 'Pembayaran Angsuran diterima.',
                'icon' => "fas fa-check-double"
            ]);

            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );

            $pusher = new Pusher\Pusher(
                '8459db692d2df931dcd7',
                'ddd443ba03d8e782dde8',
                '1444015',
                $options
            );

            $pesan['message'] = 'Pendaftaran Nasabah Baru';
            $pusher->trigger('my-channel2', 'my-event2', $pesan);

        }

        $this->db->where('id_transaksi_kredit', $id_transaksi_kredit['id_transaksi_kredit']);
        $this->db->set([
            'keterangan_kredit' => $persentase_kemacetan,
            'lunas' => $lunas
        ]);
        $this->db->update('tbl_kredit');

        // mencari id_user
        $data['user'] = $this->db->query('SELECT * from tbl_angsuran_kredit a INNER JOIN tbl_kredit b 
        ON a.id_transaksi_kredit = b.id_transaksi_kredit INNER JOIN tbl_pengajuan_kredit c 
        on b.id_pengajuan = c.id_pengajuan INNER JOIN tbl_nasabah d ON d.id_nasabah = c.id_nasabah 
        INNER JOIN USER e ON e.id_user = d.id_user WHERE a.id_angsuran = '.$id_angsuran)->row_array();

        
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        berhasil menerima 1 angsuran!
        </div><br>');

        redirect('kredit/angsuranKredit');
    }

    //terima pengajuan kredit
    public function tolakAngsuran()
    {
        $id_angsuran = $this->input->post('id_angsuran');

        $this->db->where('id_angsuran', $id_angsuran);
        $this->db->set('keterangan_angsuran', 2);
        $this->db->update('tbl_angsuran_kredit');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        berhasil tolak 1 angsuran!
        </div><br>');

        redirect('kredit/angsuranKredit');
    }

    public function exportkredit($id_ao = null)
    {
        // jika data nasabah sudah ada
        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit")->result_array(); //hanya kredit yang bukan promo yang muncul di pengajuan kredit
           
        if($id_ao == 'all'){
            
            $data['kreditActive'] = $this->db->query('select a.id_transaksi_kredit, a.tgl_realisasi_kredit, a.lunas , 
            a.keterangan_kredit, b.id_pengajuan, b.id_jenis_kredit, b.jumlah_pinjaman, b.tgl_pengajuan, b.id_ao, 
            b.keterangan_pengajuan, c.id_nasabah, c.no_hp, c.alamat_ktp,c.lattitude, c.longitude,d.id_user, d.name, 
            d.email,e.id_jenis_kredit, e.total_angsuran_bulan, e.jumlah_bunga_persen, e.admin, e.denda_kredit, 
            e.nama_kredit, e.status from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
            inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
            on e.id_jenis_kredit = b.id_jenis_kredit order by id_transaksi_kredit DESC;')->result_array();

        }else{
            
            $data['kreditActive'] = $this->db->query('select a.id_transaksi_kredit, a.tgl_realisasi_kredit, a.lunas , 
            a.keterangan_kredit, b.id_pengajuan, b.id_jenis_kredit, b.jumlah_pinjaman, b.tgl_pengajuan, b.id_ao, 
            b.keterangan_pengajuan, c.id_nasabah, c.no_hp, c.alamat_ktp,c.lattitude, c.longitude,d.id_user, d.name, 
            d.email,e.id_jenis_kredit, e.total_angsuran_bulan, e.jumlah_bunga_persen, e.admin, e.denda_kredit, 
            e.nama_kredit, e.status from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
            inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
            on e.id_jenis_kredit = b.id_jenis_kredit where b.id_ao ='.$id_ao.' order by id_transaksi_kredit DESC;')->result_array();

        }

          // mancari data kredit bermasalah
        $i =0;

          foreach($data['kreditActive'] as $ka){

            $kredit_bunga = 'Kredit Bunga-Bunga 6 Bulan';
            $tgl_realisasi = $ka['tgl_realisasi_kredit'];
            $bunga_persen = $ka['jumlah_bunga_persen'];
            $denda_persen = $ka['denda_kredit'];
            $total_bulan_angsuran = $ka['total_angsuran_bulan'];

            $daftar_angsuran = $this->db->get_where('tbl_angsuran_kredit', [
                'id_transaksi_kredit'=>$ka['id_transaksi_kredit'],
                'keterangan_angsuran'=> 1
            ])->result_array();

            $jumlah_mengangsur_real = count($daftar_angsuran); // jumlah angsuran
            $data['kreditActive'][$i]['jumlah_mengangsur_nasabah'] = $jumlah_mengangsur_real;
            
            $tgl_jatuh_tempo = strtotime('+'.($jumlah_mengangsur_real+1).' months', $tgl_realisasi); // tgl jatuh tempo int 1988721987
            $data['kreditActive'][$i]['tgl_jatuh_tempo'] = date('d-M-Y',$tgl_jatuh_tempo);

            $bulan_realisasi = date('n', $tgl_realisasi);
            $tahun_realisasi = date('Y', $tgl_realisasi);
            $bulan_ini = date('n', time());
            $tahun_ini = date('Y', time());

            $jumlah_mengangsur_seharusnya = ($tahun_ini - $tahun_realisasi) * 12 + ($bulan_ini - $bulan_realisasi);
            if($jumlah_mengangsur_seharusnya > $total_bulan_angsuran ){
                $jumlah_mengangsur_seharusnya = $total_bulan_angsuran;
            }
            $data['kreditActive'][$i]['jumlah_mengangsur_seharusnya'] = $jumlah_mengangsur_seharusnya;

            $telat_bulan = $jumlah_mengangsur_seharusnya - $jumlah_mengangsur_real; // banyak bulan nunggak
             if($telat_bulan <=0 ){
                $telat_bulan = 0;
            }
            $data['kreditActive'][$i]['telat_bulan'] = $telat_bulan;

            $secondsInDay = 60 * 60 * 24; // Jumlah detik dalam satu hari
            
            $telat_hari = floor((time()-$tgl_jatuh_tempo)/$secondsInDay);
            if($telat_hari <=0 ){
                $telat_hari = 0;
            }
            $data['kreditActive'][$i]['telat_hari'] = $telat_hari;

            

            $total_tunggakan_angsuran_pokok = 0;
            $total_tunggakan_angsuran_bunga = 0;
            $total_tunggakan_angsuran_bulanan = 0;
            $total_tunggakan_angsuran_semuanya = 0;

            if($ka['nama_kredit'] == $kredit_bunga){
                // kredit bunga2 6 bulan

                $jumlah_pokok = 0;
                $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;
                $denda_perhari = $jumlah_bayar_perbulan*$denda_persen/100;
                $denda_pokok = 0;
                
                for($a = $jumlah_mengangsur_real+1;$a <= $jumlah_mengangsur_seharusnya; $a++){

                    if($a == 6){
                        // angsuran terakhir plus pokok
                        $jumlah_pokok_akhir = $ka['jumlah_pinjaman'];
                        $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                        $jumlah_bayar_perbulan_akhir =  $jumlah_pokok_akhir+$jumlah_bunga;

                        $tgl_jatuh_tempo_pokok = strtotime('+6 months', $tgl_realisasi);
                        $telat_bayar_pokok_hari = floor((time()-$tgl_jatuh_tempo_pokok)/$secondsInDay);
                        if($telat_bayar_pokok_hari <=0 ){
                            $telat_bayar_pokok_hari = 0;
                        }
                        $data['kreditActive'][$i]['telat_bayar_pokok_hari'] = $telat_bayar_pokok_hari;
                        $data['kreditActive'][$i]['tgl_jatuh_tempo_pokok'] = date('d-M-Y',$tgl_jatuh_tempo_pokok);

                        $denda_pokok = $telat_bayar_pokok_hari*($jumlah_pokok_akhir*$denda_persen/100);

                        $total_tunggakan_angsuran_pokok += $jumlah_pokok_akhir;
                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan_akhir;

                    }else{

                        $jumlah_pokok = 0;
                        $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                        $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;

                        $total_tunggakan_angsuran_pokok += $jumlah_pokok;
                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan;

                    }
                }

                $data['kreditActive'][$i]['jumlah_pokok'] =  $jumlah_pokok;
                $data['kreditActive'][$i]['jumlah_bunga'] = $jumlah_bunga;
                $data['kreditActive'][$i]['jumlah_bayar_perbulan'] = $jumlah_bayar_perbulan;
                $data['kreditActive'][$i]['denda_perhari'] = $denda_perhari;

                $data['kreditActive'][$i]['total_tunggakan_angsuran_pokok'] = $total_tunggakan_angsuran_pokok;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bunga'] = $total_tunggakan_angsuran_bunga;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bulanan'] = $total_tunggakan_angsuran_bulanan;

                $total_denda = ($denda_perhari * $telat_hari) + $denda_pokok;
                $data['kreditActive'][$i]['total_denda'] = $total_denda;

                $total_tunggakan_angsuran_semuanya = $total_tunggakan_angsuran_bulanan + $total_denda;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_semuanya'] = $total_tunggakan_angsuran_semuanya;

            }else{
                // kredit reguler
                
                $jumlah_pokok = $ka['jumlah_pinjaman'] / $total_bulan_angsuran;
                $jumlah_bunga = $ka['jumlah_pinjaman'] * $bunga_persen/100;
                $jumlah_bayar_perbulan =  $jumlah_pokok+$jumlah_bunga;
                $denda_perhari = $jumlah_bayar_perbulan*$denda_persen/100;

                for($a = $jumlah_mengangsur_real+1;$a <= $jumlah_mengangsur_seharusnya; $a++){


                        $total_tunggakan_angsuran_pokok += $jumlah_pokok;

                        $total_tunggakan_angsuran_bunga += $jumlah_bunga;
                        
                        $total_tunggakan_angsuran_bulanan += $jumlah_bayar_perbulan;
                  
                }

                $data['kreditActive'][$i]['jumlah_pokok'] =  $jumlah_pokok;
                $data['kreditActive'][$i]['jumlah_bunga'] = $jumlah_bunga;
                $data['kreditActive'][$i]['jumlah_bayar_perbulan'] = $jumlah_bayar_perbulan;
                $data['kreditActive'][$i]['denda_perhari'] = $denda_perhari;

                $data['kreditActive'][$i]['total_tunggakan_angsuran_pokok'] = $total_tunggakan_angsuran_pokok;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bunga'] = $total_tunggakan_angsuran_bunga;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_bulanan'] = $total_tunggakan_angsuran_bulanan;

                $total_denda = $denda_perhari * $telat_hari;
                $data['kreditActive'][$i]['total_denda'] = $total_denda;

                $total_tunggakan_angsuran_semuanya = $total_tunggakan_angsuran_bulanan + $total_denda;
                $data['kreditActive'][$i]['total_tunggakan_angsuran_semuanya'] = $total_tunggakan_angsuran_semuanya;
            }
            

            
            $i++;
        }
        
        usort($data['kreditActive'], function($a, $b) {
            return $b['telat_bulan'] - $a['telat_bulan'];
        });


        $data['ao'] = array();  

        if( $id_ao != 'all'){
            $data['ao'] = $this->db->get_where('user',['id_user' => $id_ao])->row_array();

        }else{
            $data['ao']['name'] = '';
        }

        
       
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
        $sheet->setCellValue('A1', "Data Kredit Active (".$id_ao. ' - ' .$data['ao']['name'].")"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "Id Pengajuan"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "Id Transaksi Kredit"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "Nama Kredit"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "Jenis Kredit"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F3', "Id Nasabah"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "Nama Nasabah"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "Tgl. Realisasi"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "Jumlah Pinjaman"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "Bunga (persen)"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K3', "Denda (persen)"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('L3', "Status Lunas"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('M3', "Id AO"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('N3', "Kelancaran Angsuran (persen)"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('O3', "Jumlah Pokok"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('P3', "Jumlah Bunga"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('Q3', "Total Angs/bln"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('R3', "Denda/hr"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('S3', "Telat (hari)"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('T3', "Telat (bulan)"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('U3', "Tunggakan Pokok"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('V3', "Tunggakan Bunga"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('W3', "Tunggakan Angs/bln"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('X3', "Total Tunggakan"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('Y3', "Tgl. Jatuh Tempo"); // Set kolom E3 dengan tulisan "ALAMAT"


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
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);
        $sheet->getStyle('R3')->applyFromArray($style_col);
        $sheet->getStyle('S3')->applyFromArray($style_col);
        $sheet->getStyle('T3')->applyFromArray($style_col);
        $sheet->getStyle('U3')->applyFromArray($style_col);
        $sheet->getStyle('V3')->applyFromArray($style_col);
        $sheet->getStyle('W3')->applyFromArray($style_col);
        $sheet->getStyle('X3')->applyFromArray($style_col);
        $sheet->getStyle('Y3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        // $data = $this->db->query("select * from data_penjualan_mesin join customer on customer.id_customer = data_penjualan_mesin.id_customer WHERE data_penjualan_mesin.id_user=" . $id_user . ";")->result_array();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data['kreditActive'] as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['id_pengajuan']);
            $sheet->setCellValue('C' . $numrow, $data['id_transaksi_kredit']);
            $sheet->setCellValue('D' . $numrow, $data['nama_kredit']);

            if($data['status'] == 1) {
                   $sheet->setCellValue('E' . $numrow, 'Kredit Promo');
            }else{
                   $sheet->setCellValue('E' . $numrow, 'Kredit Regular');
            }
            
            $sheet->setCellValue('F' . $numrow, $data['id_nasabah']);
            $sheet->setCellValue('G' . $numrow, $data['name']);
            $sheet->setCellValue('H' . $numrow, date('d-m-Y',$data['tgl_realisasi_kredit']));
            $sheet->setCellValue('I' . $numrow, $data['jumlah_pinjaman']);
            $sheet->setCellValue('J' . $numrow, $data['jumlah_bunga_persen']);
            $sheet->setCellValue('K' . $numrow, $data['denda_kredit']);
            if($data['lunas'] == 1) { 
             $sheet->setCellValue('L' . $numrow, 'Lunas');    
            }else {
              $sheet->setCellValue('L' . $numrow, 'Belum Lunas');    
            }
            
            $sheet->setCellValue('M' . $numrow, $data['id_ao']);
            if( ($data['keterangan_kredit']) != null ) { 
                $sheet->setCellValue('N' . $numrow, $data['keterangan_kredit']);
            } else { 
                $sheet->setCellValue('N' . $numrow, 'Belum Ada Angsuran');}
            

            $sheet->setCellValue('O'. $numrow, $data['jumlah_pokok']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('P'. $numrow, $data['jumlah_bunga']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('Q'. $numrow, $data['jumlah_bayar_perbulan']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('R'. $numrow, $data['denda_perhari']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('S'. $numrow, $data['telat_hari']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('T'. $numrow, $data['telat_bulan']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('U'. $numrow, $data['total_tunggakan_angsuran_pokok']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('V'. $numrow, $data['total_tunggakan_angsuran_bunga']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('W'. $numrow, $data['total_tunggakan_angsuran_bulanan']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('X'. $numrow, $data['total_tunggakan_angsuran_semuanya']); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('Y'. $numrow, $data['tgl_jatuh_tempo']); // Set kolom E3 dengan tulisan "ALAMAT"

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
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('R' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('S' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('T' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('U' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('W' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('X' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Y' . $numrow)->applyFromArray($style_row);

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
        $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('N')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('O')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('P')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('Q')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('R')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('S')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('T')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('U')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('V')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('W')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('X')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('Y')->setWidth(30); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle( "Data Kredit Active");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kredit Active.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }


}