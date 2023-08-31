<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet

use phpDocumentor\Reflection\Type;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use phpDocumentor\Reflection\Types\This;
use SebastianBergmann\Environment\Console;

class Pelayanan extends CI_Controller
{
    public function __construct()
    {
        // cek masuk terlebih dahulu
        parent::__construct();

        // cek masuk terlebih dahulu
        // memanggil fungsi yang ada di helper musfiul_helper.php
        $id_penawaran = $this->input->get('id_penawaran');
        $token = $this->input->get('token');
     
        sudah_masuk($id_penawaran,$token);
    }

  
    function lihatbukupinjaman($id_transaksi_kredit){
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        // mengambil daftar mesin
        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_user'=>$data['user']['id_user']])->row_array();
        
        $data['kredit'] = $this->db->query('select * from tbl_nasabah a, tbl_pengajuan_kredit b, tbl_kredit c , tbl_jenis_kredit e 
                                            where a.id_nasabah = b.id_nasabah and b.id_pengajuan = c.id_pengajuan 
                                            and b.id_jenis_kredit = e.id_jenis_kredit and a.id_nasabah ='. $data['nasabah']['id_nasabah'] .'  
                                            and c.id_transaksi_kredit ='.$id_transaksi_kredit)->row_array();

        $data['angsuran'] = $this->db->query('select * from tbl_nasabah a, tbl_pengajuan_kredit b, tbl_kredit c, tbl_angsuran_kredit d , tbl_jenis_kredit e 
                                            where a.id_nasabah = b.id_nasabah and b.id_pengajuan = c.id_pengajuan 
                                            and b.id_jenis_kredit = e.id_jenis_kredit and c.id_transaksi_kredit=d.id_transaksi_kredit 
                                            and a.id_nasabah ='. $data['nasabah']['id_nasabah'] .'  and c.id_transaksi_kredit ='.$id_transaksi_kredit.'  
                                            and d.keterangan_angsuran=1 ORDER by d.id_angsuran ASC')->result_array();

        // var_dump($data['angsuran']);
        // die;

        // $this->load->view('buku_pinjaman',$data);

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Buku Angsuran-" . $data['user']['name'] . "-" . date('m-d-Y',time()) . ".pdf";
        $this->pdf->load_view('buku_pinjaman', $data);
    }


    public function index()
    {

        $data['title'] = 'Data Diri Nasabah';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        // mengambil daftar mesin
        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_user'=>$data['user']['id_user']])->row_array();

        $this->form_validation->set_rules('income', 'Income', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('no_ktp', 'Nomor KTP', 'required');
        $this->form_validation->set_rules('alamat_ktp', 'Alamat Sesuai KTP', 'required');
        $this->form_validation->set_rules('nama_ibu_kandung', 'Nama Ibu Kandung', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('pelayanan/nasabah.php', $data);
            $this->load->view('templates/footer_dashboard', $data); 
        }else{
            
            $id_user = $data['user']['id_user'];
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

     
            if($data['nasabah']){

                   
                        
                    $nama_foto_ktp = $data['nasabah']['foto_ktp'];
                    $nama_foto_kk = $data['nasabah']['foto_kk'];
                    $nama_foto_ktp_pasangan = $data['nasabah']['foto_ktp_pasangan'];
                    $nama_foto_buku_nikah = $data['nasabah']['foto_buku_nikah'];
        
                        if ($this->upload->do_upload('foto_ktp')) {
                            // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                            $gbr = $this->upload->data();
                            $nama_foto_ktp = $gbr['file_name'];        
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }
    
                        if ($this->upload->do_upload('foto_kk')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();
                        $nama_foto_kk = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }
    
                        if ($this->upload->do_upload('foto_ktp_pasangan')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();
                        $nama_foto_ktp_pasangan = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }

                        if ($this->upload->do_upload('foto_buku_nikah')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();
                        $nama_foto_buku_nikah = $gbr['file_name'];                    
                        } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                        }
                        // rubah tgl pengajuan menjadi format angka
                        $date_birth_pasangan=strtotime($date_birth_pasangan);
                        if($pendidikan == "Pilih Pendidikan Terakhir"){
                            $pendidikan = $data['nasabah']['pendidikan'];
                        }
                        
                        if($status == "Pilih Status"){
                            $status = $data['nasabah']['status'];
                        }elseif($status == "Belum Menikah"){
                            $date_birth_pasangan  = null;
                            $nama_pasangan = null;
                            $pekerjaan_pasangan = null;
                            $no_ktp_pasangan = null; 
                            $jumlah_anak  = null;
                            $nama_foto_ktp_pasangan = null;
                            $nama_foto_buku_nikah = null;
                        }

                     
                        
                        $this->db->where('id_nasabah',$data['nasabah']['id_nasabah']);
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
                            // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                            $gbr = $this->upload->data();
                            $nama_foto_ktp = $gbr['file_name'];        
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
    
                if ($this->upload->do_upload('foto_kk')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();
                        $nama_foto_kk = $gbr['file_name'];                    
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
    
                if ($this->upload->do_upload('foto_ktp_pasangan')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();
                        $nama_foto_ktp_pasangan = $gbr['file_name'];                    
                } else {
                            echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }

                if ($this->upload->do_upload('foto_buku_nikah')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
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

            redirect('pelayanan');

        }
        
       
    }

    public function pengajuanKreditDetail()
    {
        $id_pengajuan = $this->input->post('id_pengajuan');
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();

        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_user'=>$data['user']['id_user']])->row_array();

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

        $data['request'] =[
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


    public function tambahPengajuanKredit($id_jenis_kredit = null)
    {

        
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Pengajuan Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ';')->row_array();
        

        if($data['nasabah']){            

            // jika data nasabah sudah ada
            $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit WHERE status = 0;")->result_array(); //hanya kredit yang bukan promo yang muncul di pengajuan kredit
            
            // manambahkan kredit promo jika sudah di klik
            $data['jenisKreditpromo'] = $this->db->query("SELECT * FROM tbl_history_penawaran a INNER JOIN 
                            tbl_penawaran_kredit b ON a.id_penawaran = b.id_penawaran AND a.id_nasabah =".$data['nasabah']['id_nasabah']." INNER JOIN 
                            tbl_jenis_kredit c on b.id_jenis_kredit = c.id_jenis_kredit AND a.diklik = 1 AND b.tgl_berakhir > ".time())->result_array();

            // menggabungkan data kredit normal dan promo
            $data['jenisKredit'] = array_merge($data['jenisKredit'],$data['jenisKreditpromo']); 

            $data['pengajuanKredit'] = $this->db->query('select * from tbl_pengajuan_kredit a, tbl_jenis_kredit c, tbl_nasabah b, user d where a.id_nasabah = b.id_nasabah 
            and a.id_nasabah ='.$data['nasabah']['id_nasabah'].' and c.id_jenis_kredit = a.id_jenis_kredit 
            and d.id_user = b.id_user order by id_pengajuan DESC;')->result_array();
            
            $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
            where b.id_nasabah =' . $data['nasabah']['id_nasabah'] . ' AND b.keterangan_pengajuan = 1 AND a.lunas = 0;')->result_array();
            
            $data['kreditDiajukan'] = $this->db->query('select * from tbl_pengajuan_kredit where id_nasabah =' . $data['nasabah']['id_nasabah'] . '
             AND keterangan_pengajuan = 0;')->row_array();

            // get daftar jaminan
            if($data['pengajuanKredit']){
                $data['daftar_jaminan'] = $this->db->query('select * from tbl_daftar_jaminan, tbl_daftar_foto_jaminan, 
                tbl_daftar_foto_surat_kepemilikan WHERE tbl_daftar_jaminan.id_pengajuan = 16 and 
                tbl_daftar_jaminan.id_daftar_jaminan = tbl_daftar_foto_surat_kepemilikan.id_daftar_jaminan and 
                tbl_daftar_foto_jaminan.id_daftar_jaminan = tbl_daftar_jaminan.id_daftar_jaminan 
                order BY tbl_daftar_jaminan.id_daftar_jaminan;');
            }
            
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
                $this->load->view('pelayanan/tambah_pengajuan_kredit.php', $data);
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
        
                    redirect('pelayanan/tambahPengajuanKredit');

                    
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
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$data['nasabah']['id_nasabah'].'
                            AND c.id_jenis_kredit = '.$id_jenis_kredit)->row_array();
                        
                        if(!empty($dataHist)){
                            $this->db->set([
                            'diajukan'=> 1
                            ]);
                            $this->db->where('id_history',$dataHist['id_history']);
                            $this->db->update('tbl_history_penawaran');

                        }

                        // notifikasi
                       // membuat pemberitahuan pengajuan kredit nasabah untuk admin
                        $this->db->insert('notifikasi', [
                            'id_user' => '1',
                            'judul' => 'Pengajuan Kredit',
                            'url' => 'kredit/listPengajuanKredit',
                            'keterangan' => 'Pengajuan Kredit - '. $data['user']['name'].' - Rp. '.number_format($jumlah_pinjaman,0,',','.'),
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

                        $pesan['message'] = 'Pendaftaran Kredit';
                        $pusher->trigger('my-channel', 'my-event', $pesan);

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
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$data['nasabah']['id_nasabah'].'
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
        
                    redirect('pelayanan/tambahPengajuanKredit');

                }
               
                
            }
        }else{
            // jika data nasabah belum ada.
                // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please add your data first!
                </div><br>');
    
                redirect('pelayanan/');
        }

    }
 
    function deletepengajuan() {
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ';')->row_array();
        
        $id_pengajuan = $this->input->post('id_pengajuan');
        $data_pengajuan = $this->db->get_where('tbl_pengajuan_kredit',[
            'id_pengajuan'=>$id_pengajuan,
            'id_nasabah' => $data['nasabah']['id_nasabah']
        ]);

        if($data_pengajuan){
             $this->db->where('id_pengajuan', $id_pengajuan);
            $this->db->delete('tbl_pengajuan_kredit');
        }
            // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    your data has been deleted!
                    </div><br>');
        
                    redirect('pelayanan/tambahPengajuanKredit');
    }


    public function loaddaftar()
    {
        $data['jenisKredit'] = $this->db->query("select * tbl_from tbl_jenis_kredit;
         ")->result_array();

        if ($data['jenisKredit']) {
            echo json_encode($data['jenisKredit']);
        } else {
            echo json_encode(['message' => 'Data Kosong']);
        }
    }

    

    public function angsuranKredit()
    {
        
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Angsuran Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ';')->row_array();

        $data['message'] = $this->session->flashdata('message');

        // $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
        //         inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
        //         on e.id_jenis_kredit = b.id_jenis_kredit where c.id_user = ' . $data['user']['id_user'] . '
        //         order by a.id_transaksi_kredit DESC;')->result_array();
        
        $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
                inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
                on e.id_jenis_kredit = b.id_jenis_kredit where c.id_user = ' . $data['user']['id_user'] . ' and a.lunas = 0 
                order by a.id_transaksi_kredit DESC;')->row_array();
        
        
   
        if($data['nasabah']){
            $data['angsuranKredit'] = $this->db->query('select * from tbl_angsuran_kredit a, tbl_nasabah b, tbl_pengajuan_kredit c, tbl_kredit d, tbl_jenis_kredit e
                where a.id_transaksi_kredit = d.id_transaksi_kredit and d.id_pengajuan =  c.id_pengajuan and b.id_nasabah = c.id_nasabah and 
                c.id_jenis_kredit = e.id_jenis_kredit and c.id_nasabah ='.$data['nasabah']['id_nasabah'].' order by id_angsuran DESC;')->result_array();

            // var_dump($data['angsuranKredit']);
            // die;

            $this->form_validation->set_rules('jumlah_pinjaman', 'Jumlah', 'required');
            // $this->form_validation->set_rules('foto_ktp', 'KTP', 'required');
            // $this->form_validation->set_rules('foto_kk', 'KK', 'required');
            // $this->form_validation->set_rules('foto_jaminan', 'Jaminan', 'required');
            // $this->form_validation->set_rules('foto_surat_jaminan', 'Surat', 'required');
            // $this->form_validation->set_rules('tgl_pengajuan', 'Tanggal', 'required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header_dashboard', $data);
                $this->load->view('templates/sidebar_dashboard', $data);
                $this->load->view('templates/topbar_dashboard', $data);
                $this->load->view('pelayanan/angsuran_kredit.php', $data);
                $this->load->view('templates/footer_dashboard', $data);;
            } else {
                // var_dump("tes");
                $id_jenis_kredit = $this->input->post('id_pengajuan');
                $id_nasabah = $this->input->post('id_nasabah');
                $id_jenis_kredit = $this->input->post('id_jenis_kredit');
                $jumlah_pinjaman = $this->input->post('jumlah_pinjaman');
                $foto_ktp = $this->input->post('foto_ktp');
                $foto_kk = $this->input->post('foto_kk');
                $foto_jaminan = $this->input->post('foto_jaminan');
                $foto_surat_jaminan = $this->input->post('foto_surat_jaminan');
                $tgl_pengajuan = $this->input->post('tgl_pengajuan');
                //$keterangan_pengajuan = $this->input->post('keterangan_pengajuan');

                // cek jika ada gambar yang diupload
                // maka akan ada $_FILES
                $upload_foto_ktp = $_FILES['foto_ktp'];
                $nama_foto_ktp = $upload_foto_ktp['name'];
                // $upload_foto_kk = $_FILES['foto_kk'];
                // $nama_foto_kk = $upload_foto_kk['name'];
                // $upload_foto_jaminan = $_FILES['foto_jaminan'];
                // $nama_foto_jaminan = $upload_foto_jaminan['name'];
                // $upload_foto_surat = $_FILES['foto_surat_jaminan'];
                // $nama_foto_surat = $upload_foto_surat['name'];

                if ($nama_foto_ktp) {
                    $config['upload_path'] = './assets/img/pengajuan/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']     = '2048';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('foto_ktp')) {
                        // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                        $gbr = $this->upload->data();

                        if ($gbr['file_size'] >= 100) {

                            $config['image_library'] = 'gd2';
                            $config['source_image'] = './assets/img/pengajuan/' . $gbr['file_name'];

                            $config['create_thumb'] = FALSE;
                            $config['maintain_ratio'] = FALSE;
                            $config['quality'] = '80%';
                            $config['width'] = 400;
                            $config['height'] = 400;
                            $config['new_image'] = './assets/img/pengajuan/' . 'new_' . $gbr['file_name'];

                            $old_gbr = $gbr['file_name'];
                            $gbr['file_name'] = 'new_' . $gbr['file_name'];

                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();

                            unlink(FCPATH . 'assets/img/pengajuan/' . $old_gbr);
                        }

                        $this->db->insert('tbl_pengajuan_kredit', [
                            'id_nasabah' => $id_nasabah,
                            'id_jenis_kredit' => $id_jenis_kredit,
                            'jumlah_pinjaman' => $jumlah_pinjaman,
                            'foto_ktp' =>  $gbr['file_name'],
                            'foto_kk' =>  "tes.jpg",
                            'foto_jaminan' =>  "tes.jpg",
                            'foto_surat_jaminan' =>  "tes.jpg",
                            'tgl_pengajuan' => $tgl_pengajuan,
                            'keterangan_pengajuan' => 0,
                        ]);
                    } else {
                        echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                    }
                } else {
                    $this->db->insert('tbl_pengajuan_kredit', [
                        'id_nasabah' => $id_nasabah,
                        'id_jenis_kredit' => $id_jenis_kredit,
                        'jumlah_pinjaman' => $jumlah_pinjaman,
                        'foto_ktp' =>  $gbr['file_name'],
                        'foto_kk' =>  "tes.jpg",
                        'foto_jaminan' =>  "tes.jpg",
                        'foto_surat_jaminan' =>  "tes.jpg",
                        'tgl_pengajuan' => $tgl_pengajuan,
                        'keterangan_pengajuan' => 0,
                    ]);
                }
            
                // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                your data has been added!
                </div><br>');

                redirect('pelayanan/angsuranKredit');
            }
        }else{
            // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please add your data first!
                </div><br>');

                redirect('pelayanan/');
        }

        
    }

    public function hapusangsuran(){
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        
        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_user'=>$data['user']['id_user']])->row_array();

        $id_transaksi_kredit = $this->input->post('id_transaksi_kredit');
        $id_angsuran = $this->input->post('id_angsuran');

        if($id_transaksi_kredit && $id_angsuran && $data['nasabah']){

            $data_kredit = $this->db->query('SELECT * FROM tbl_pengajuan_kredit a INNER JOIN tbl_kredit b ON a.id_pengajuan = b.id_pengajuan WHERE a.id_nasabah ='.$data['nasabah']['id_nasabah'].' AND b.lunas = 0 ')->row_array();

            if($data_kredit){
                $angs = $this->db->get_where('tbl_angsuran_kredit',[
                    'id_transaksi_kredit'=> $id_transaksi_kredit,
                    'id_angsuran'=> $id_angsuran,
                    'keterangan_angsuran' => 0
                ]);
    
                if($angs){
                    $this->db->where('id_angsuran', $id_angsuran);
                    $this->db->delete('tbl_angsuran_kredit');

                    // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                    Berhasil menghapus satu angsuran.
                    </div><br>');
        
                    redirect('pelayanan/angsuranKredit');
                }

            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Gagal menghapus angsuran.
                    </div><br>');
        
                    redirect('pelayanan/angsuranKredit');
    }

    public function getDataModalPembayaran()
    {
        $id_transaksi_kredit = $this->input->post('id_transaksi_kredit');
        $id_angsuran = $this->input->post('id_angsuran');
        // $id_transaksi_kredit = 12;
  
        $data = $this->getDataTagihanPembayaran($id_transaksi_kredit,'json',$id_angsuran);

        echo json_encode($data);
    }

    public function listKreditActive()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Kredit Active (Berjalan)';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['nasabah'] = $this->db->get_where('tbl_nasabah',['id_user'=>$data['user']['id_user']])->row_array();

        if(empty($data['nasabah'])){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please add your data first!
                </div><br>');
            
            redirect('pelayanan/');
        }

        $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
        inner join tbl_nasabah c on b.id_nasabah = c.id_nasabah inner join user d on c.id_user = d.id_user inner join tbl_jenis_kredit e
        on e.id_jenis_kredit = b.id_jenis_kredit where c.id_user = ' . $data['user']['id_user'] . '
        order by a.id_transaksi_kredit DESC;')->result_array();
 
        // jika data nasabah sudah ada
        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit WHERE status = 0;")->result_array(); //hanya kredit yang bukan promo yang muncul di pengajuan kredit
            
        // manambahkan kredit promo jika sudah di klik
        $data['jenisKreditpromo'] = $this->db->query("SELECT * FROM tbl_history_penawaran a INNER JOIN 
                    tbl_penawaran_kredit b ON a.id_penawaran = b.id_penawaran AND a.id_nasabah =".$data['nasabah']['id_nasabah']." INNER JOIN 
                    tbl_jenis_kredit c on b.id_jenis_kredit = c.id_jenis_kredit AND a.diklik = 1 AND b.tgl_berakhir > ".time())->result_array();

        // menggabungkan data kredit normal dan promo
        $data['jenisKredit'] = array_merge($data['jenisKredit'],$data['jenisKreditpromo']); 
        

        $this->form_validation->set_rules('total_angsuran_bulan', 'Angsuran', 'required');
        $this->form_validation->set_rules('jumlah_bunga_persen', 'Bunga', 'required');
        $this->form_validation->set_rules('nama_kredit', 'Kredit', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('pelayanan/kredit_active.php', $data);
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

            redirect('pelayanan/listKreditActive');
        }
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

    //terima pengajuan kredit
    public function bayarAngsuran()
    {

        $id_transaksi_kredit = $this->input->post('id_transaksi_kredit');
        $id_angsuran = $this->input->post('id_angsuran');

        $tanggal = $this->input->post('tgl_mengangsur');
        $jumlah_pokok = $this->input->post('jumlah_pokok_angsuran');
        $jumlah_bunga = $this->input->post('jumlah_bunga_angsuran');
        $denda = $this->input->post('denda_total');
        $tgl_jatuh_tempo = $this->input->post('tgl_jatuh_tempo');
        $status_keterlambatan = $this->input->post('status_keterlambatan');

        $data['kredit'] = $this->db->query('select * from tbl_kredit a INNER JOIN tbl_pengajuan_kredit b ON a.id_pengajuan = b.id_pengajuan 
        where id_transaksi_kredit='.$id_transaksi_kredit.';')->row_array();

        $data['nasabah'] = $this->db->query('SELECT * FROM tbl_nasabah a INNER JOIN USER b on a.id_user = b.id_user 
        WHERE a.id_nasabah = '.$data['kredit']['id_nasabah'].';')->row_array();
        // $angsuran_ke = $this->db->query('select count(id_angsuran) as total_angsuran from tbl_angsuran_kredit where id_transaksi_kredit ='.$data_kredit['id_transaksi_kredit'])->row_array();
    
        $upload_image = $_FILES['bukti_angsuran']; 
        $nama_image = $upload_image['name'];

        if ($nama_image) {
            $config['upload_path'] = './assets/img/angsuran/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']     = '2048';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_angsuran')) {

                $gbr = $this->upload->data();
                
                
                if($id_angsuran){

                    // update
                    $this->db->set([
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
                    $this->db->where('id_angsuran', $id_angsuran);

                    $this->db->update('tbl_angsuran_kredit');

                    // notifikasi
                    // membuat pemberitahuan pengajuan kredit nasabah untuk admin
                        $this->db->insert('notifikasi', [
                                'id_user' => '1',
                                'judul' => 'Edit Bayar Angsuran',
                                'url' => 'kredit/angsuranKredit',
                                'keterangan' => 'Edit Bayar Angsuran Kredit - '. $data['nasabah']['name'].' - Rp. '.number_format( $jumlah_pokok+$jumlah_bunga+$denda,0,',','.'),
                                'icon' => 'fas fa-money-check-alt'
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

                            $pesan['message'] = 'Edit Pembayaran Angsuran Kredit';
                            $pusher->trigger('my-channel', 'my-event', $pesan);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                            Berhasil mengedit angsuran!
                            </div><br>');

                    redirect('pelayanan/angsuranKredit');

                }else{

                    // insert
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

                    // notifikasi
                    // membuat pemberitahuan pengajuan kredit nasabah untuk admin
                        $this->db->insert('notifikasi', [
                                'id_user' => '1',
                                'judul' => 'Bayar Angsuran',
                                'url' => 'kredit/angsuranKredit',
                                'keterangan' => 'Bayar Angsuran Kredit - '. $data['nasabah']['name'].' - Rp. '.number_format( $jumlah_pokok+$jumlah_bunga+$denda,0,',','.'),
                                'icon' => 'fas fa-money-check-alt'
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

                            $pesan['message'] = 'Pembayaran Angsuran Kredit';
                            $pusher->trigger('my-channel', 'my-event', $pesan);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    berhasil membayar angsuran!
                    </div><br>');

                    redirect('pelayanan/angsuranKredit');
                }

                

            } else {
                echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
            }
        } 
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Gagal berhasil membayar angsuran!
                </div><br>');
        

        redirect('pelayanan/listKreditActive');
    }

    public function daftarNasabah()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Pendaftaran Nasabah';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ' order by id_nasabah ASC;')->row_array();
        $data['users'] = $this->db->query('select * from user where role_id = 2 order by id_user ASC;')->result_array();

        $this->form_validation->set_rules('income', 'Income', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
        $this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            if($data['nasabah'] != null)
            {
                $this->load->view('pelayanan/edit_nasabah.php', $data);
            }
            else
            {
                $this->load->view('pelayanan/tambah_nasabah.php', $data);
            }
            $this->load->view('templates/footer_dashboard', $data);;
        } else {
            $id_user = $this->input->post('id_user');
            $income = $this->input->post('income');
            $status = $this->input->post('status');
            $pendidikan = $this->input->post('pendidikan');
            $pengeluaran = $this->input->post('pengeluaran');

            //jika user sudah mendaftar, maka data yang dimasukkan adalah update an data bukan pendaftaran ulang ke tabel nasabah
            if($data['nasabah'] != null)
            {
                $this->db->update('tbl_nasabah', [
                    'id_user' => $id_user,
                    'income' => $income,
                    'status' => $status,
                    'pendidikan' => $pendidikan,
                    'pengeluaran' => $pengeluaran,
                ], ['id_user' => $id_user]);
            }
            else
            {
                $this->db->insert('tbl_nasabah', [
                    'id_user' => $id_user,
                    'income' => $income,
                    'status' => $status,
                    'pendidikan' => $pendidikan,
                    'pengeluaran' => $pengeluaran,
                    'kemacetan_kredit' => 850,
                    'kategori_nasabah' => 1,
                ]);
            }
            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            your data has been added!
            </div><br>');

            redirect('pelayanan/daftarNasabah');
        }
    }

    public function editNasabah()
    {
        $id_nasabah = $this->input->post('id_nasabah');
        $id_user = $this->input->post('id_user');
        $income = $this->input->post('income');
        $status = $this->input->post('status');
        $pendidikan = $this->input->post('pendidikan');
        $pengeluaran = $this->input->post('pengeluaran');
        $kemacetan_kredit = $this->input->post('kemacetan_kredit');
        $kategori_nasabah = $this->input->post('kategori_nasabah');

        $this->db->update('tbl_nasabah', [
            'id_user' => $id_user,
            'income' => $income,
            'status' => $status,
            'pendidikan' => $pendidikan,
            'pengeluaran' => $pengeluaran,
            'kemacetan_kredit' => $kemacetan_kredit,
            'kategori_nasabah' => $kategori_nasabah,
        ], ['id_nasabah' => $id_nasabah]);
        // membuat flashdata untuk menampilkan pesan
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
         your data has been edited!
         </div><br>');

        redirect('pelayanan/tambahNasabah');
    }

    public function promoKredit() 
    {

        $id_penawaran = $this->input->get('id_penawaran');
        $token = $this->input->get('token');

        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Promo Kredit';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ';')->row_array();

        if(empty($data['nasabah'])){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please add your data first!
                </div><br>');

            redirect('pelayanan/');
        }

        $data['promoKredit'] = $this->db->query('select DISTINCT a.id_nasabah , c.id_penawaran, c.gambar_penawaran, 
                            c.text_penawaran, c.tgl_penawaran, c.tgl_berakhir, b.terkirim, d.id_jenis_kredit, c.text_penawaran, c.urlgambar, 
                            d.total_angsuran_bulan, d.jumlah_bunga_persen,  d.nama_kredit, e.keterangan_pengajuan , b.id_history 
                            from tbl_nasabah a inner JOIN tbl_history_penawaran b on a.id_nasabah = b.id_nasabah 
                            INNER JOIN tbl_penawaran_kredit c ON b.id_penawaran = c.id_penawaran 
                            INNER join tbl_jenis_kredit d ON c.id_jenis_kredit = d.id_jenis_kredit 
                            LEFT JOIN tbl_pengajuan_kredit e ON d.id_jenis_kredit= e.id_jenis_kredit  
                            where a.id_nasabah='.$data['nasabah']['id_nasabah'] .' order by b.id_history DESC;')->result_array();
                            // .' and e.id_nasabah = '.$data['nasabah']['id_nasabah']
        // to show pop up modal pengajuan
        $data['aksespromo']['akses'] = '0';

        // user mengklik dari email
        if(!empty($id_penawaran)){
            $dataPenawaran = $this->db->get_where('tbl_penawaran_kredit',['id_penawaran'=>$id_penawaran])->row_array();
            $dataHist = $this->db->query('Select * from tbl_history_penawaran a where 
            a.id_penawaran ='.$dataPenawaran['id_penawaran'].' and a.id_nasabah = '.$data['nasabah']['id_nasabah'])->row_array();

            if($dataHist){
                $this->db->set([
                    'diklik'=> 1, // diklik oleh user (Promo)
                ]);
                $this->db->where('id_history',$dataHist['id_history']);
                $this->db->update('tbl_history_penawaran');

                $data['aksespromo']['akses'] = '1';
                $data['aksespromo']['id_penawaran'] = $dataPenawaran['id_penawaran'];
                $data['aksespromo']['token'] = $token;
                $data['aksespromo']['id_history'] = $dataHist['id_history'];
                $data['aksespromo']['id_nasabah'] = $data['nasabah']['id_nasabah'];

            }else{
                $data['aksespromo']['akses'] = '0';
            }

        }elseif(!empty($this->session->flashdata('promo'))){
            $promo = $this->session->flashdata('promo');
                
            $id_penawaran = $promo['id_penawaran'];
            $token = $promo['token'];

            $dataPenawaran = $this->db->get_where('tbl_penawaran_kredit',['id_penawaran'=>$id_penawaran])->row_array();
            $dataHist = $this->db->query('Select * from tbl_history_penawaran a where 
            a.id_penawaran ='.$dataPenawaran['id_penawaran'].' and a.id_nasabah = '.$data['nasabah']['id_nasabah'])->row_array();

            if($dataHist){
                $this->db->set([
                    'diklik'=> 1, // diklik oleh user (Promo)
                ]);
                $this->db->where('id_history',$dataHist['id_history']);
                $this->db->update('tbl_history_penawaran');

                $data['aksespromo']['akses'] = '1';
                $data['aksespromo']['id_penawaran'] = $dataPenawaran['id_penawaran'];
                $data['aksespromo']['token'] = $token;
                $data['aksespromo']['id_history'] = $dataHist['id_history'];
                $data['aksespromo']['id_nasabah'] = $data['nasabah']['id_nasabah'];

            }else{
                $data['aksespromo']['akses'] = '0';
            }
            
        }



        $data['jenisKredit'] = $this->db->query("select * from tbl_jenis_kredit WHERE status = 0;")->result_array(); //hanya kredit yang bukan promo yang muncul di pengajuan kredit
            
        // manambahkan kredit promo jika sudah di klik
        $data['jenisKreditpromo'] = $this->db->query("SELECT * FROM tbl_history_penawaran a INNER JOIN 
                            tbl_penawaran_kredit b ON a.id_penawaran = b.id_penawaran AND a.id_nasabah =".$data['nasabah']['id_nasabah']." INNER JOIN 
                            tbl_jenis_kredit c on b.id_jenis_kredit = c.id_jenis_kredit AND b.tgl_berakhir > ".time())->result_array();

        // menggabungkan data kredit normal dan promo
        $data['jenisKredit'] = array_merge($data['jenisKredit'],$data['jenisKreditpromo']);

        

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
            $this->load->view('pelayanan/promo_kredit.php', $data);
            $this->load->view('templates/footer_dashboard', $data);
        } else {
            //$id_pengajuan = $this->input->post('id_pengajuan');
            $id_nasabah = $this->input->post('id_nasabah');
            $id_jenis_kredit = $this->input->post('id_jenis_kredit');
            $jumlah_pinjaman = $this->input->post('jumlah_pinjaman');
            $tgl_pengajuan = $this->input->post('tgl_pengajuan');


            $data['kreditActive'] = $this->db->query('select * from tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan
            where b.id_nasabah =' . $data['nasabah']['id_nasabah'] . ' AND b.keterangan_pengajuan = 1 AND a.lunas = 0;')->result_array();
            
            $data['kreditDiajukan'] = $this->db->query('select * from tbl_pengajuan_kredit 
            where id_nasabah =' . $id_nasabah . ' AND keterangan_pengajuan = 0;')->row_array();
           
        //    cek apakah memiliki kredit yang sedang berjalan
            if( $data['kreditActive'] == null && $data['kreditDiajukan'] == null)
            {
                
                
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

                        if($id_jaminan_shm != 0) {
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
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$data['nasabah']['id_nasabah'].'
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

                        if(!empty($id_jaminan_shm)){
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

                        //update diajukan
                        $dataHist = $this->db->query('SELECT * FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b 
                            ON a.id_nasabah = b.id_nasabah INNER JOIN tbl_penawaran_kredit c 
                            on a.id_penawaran = c.id_penawaran WHERE b.id_nasabah = '.$data['nasabah']['id_nasabah'].'
                            AND c.id_jenis_kredit = '.$id_jenis_kredit)->row_array();
                        
                        if(!empty($dataHist)){
                            $this->db->set([
                            'diajukan'=> 1
                            ]);
                            $this->db->where('id_history',$dataHist['id_history']);
                            $this->db->update('tbl_history_penawaran');

                        }


                    }
                    // membuat flashdata untuk menampilkan pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Selamat, Data pengajuan promo anda berhasil terkirim.
                    </div><br>');
        
                    redirect('pelayanan/tambahPengajuanKredit');
            }else{
                // membuat flashdata untuk menampilkan pesan
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                I\'m sorry you can\'t apply for credit because you still have unfinished credit!
                </div><br>');

                redirect('pelayanan/promoKredit');
            }

        }

    }

    public function insertclick(){
         $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ' order by id_nasabah ASC;')->row_array();

        $id_jenis_kredit = $this->input->post('id_jenis_kredit');

        if(!empty($id_jenis_kredit) ){

            $datahist = $this->db->query('select * from tbl_history_penawaran a INNER join tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
            INNER JOIN tbl_penawaran_kredit c ON a.id_penawaran = c.id_penawaran 
            WHERE a.id_nasabah = '.$data['nasabah']['id_nasabah'].' AND c.id_jenis_kredit = '.$id_jenis_kredit)->row_array();
        }

        if(isset($datahist)) {

            if(!empty($datahist)){
                if($datahist['diklik'] == 0){
                    $this->db->set([
                        'diklik'=> 1, // diklik oleh user (Promo)
                    ]);
                    $this->db->where('id_history',$datahist['id_history']);
                    $this->db->update('tbl_history_penawaran');
    
                    echo json_encode(array('success'=>true));
    
                    return;
                }

            }
        }

        echo json_encode(array('success'=>false));
        
        return;
    }

    public function getdatapromo(){

        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['nasabah'] = $this->db->query('select * from tbl_nasabah where id_user=' . $data['user']['id_user'] . ' order by id_nasabah ASC;')->row_array();
        
        $id_history = htmlspecialchars($this->input->post('id_history', true));

        $id_nasabah = $data['nasabah']['id_nasabah'];

        $data_promo = $this->db->query('SELECT * from tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                            AND a.id_nasabah ='.$id_nasabah.' AND a.id_history='.$id_history.'
                            INNER JOIN tbl_penawaran_kredit c ON a.id_penawaran = c.id_penawaran  
                            INNER JOIN tbl_jenis_kredit d ON d.id_jenis_kredit = c.id_jenis_kredit')->row_array();
        if(!empty($data_promo)){
            echo json_encode($data_promo);
        }else{
            echo json_encode(array('result'=>'data kosong'));
        }

    }

    public function tampil_notif()
    {
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Member';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email'),
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $this->load->view('pelayanan/tampil_notif', $data);
    }

}