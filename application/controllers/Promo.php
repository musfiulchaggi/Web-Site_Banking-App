<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Thumbnails;

class Promo extends CI_Controller
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



    public function promokredit()
    {
        $this->form_validation->set_rules('jumlah_bunga_persen', 'Bunga Kredit', 'required');
        $this->form_validation->set_rules('total_angsuran_bulan', 'Jumlah Angsuran', 'required');
        $this->form_validation->set_rules('nama_kredit', 'nama kredit', 'required');
        $this->form_validation->set_rules('tgl_berakhir', 'Teks Penawaran', 'required');

        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Buat Promo';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

       
        // $data['promoKredit'] = $this->db->query('SELECT tbl_penawaran_kredit.id_penawaran, 
        //         tbl_penawaran_kredit.id_jenis_kredit, 
        //         user.name, user.email, tbl_jenis_kredit.nama_kredit, 
        //         tbl_penawaran_kredit.gambar_penawaran, tbl_penawaran_kredit.tgl_penawaran, 
        //         tbl_penawaran_kredit.dikonfirmasi from user, tbl_penawaran_kredit, tbl_nasabah, tbl_jenis_kredit 
        //         WHERE tbl_penawaran_kredit.id_nasabah=tbl_nasabah.id_nasabah 
        //         and user.id_user = tbl_nasabah.id_user 
        //         and tbl_jenis_kredit.id_jenis_kredit=tbl_penawaran_kredit.id_jenis_kredit 
        //         order by tbl_penawaran_kredit.id_penawaran DESC;')->result_array();

        $data['promoKredit'] = $this->db->query('SELECT * from tbl_penawaran_kredit a inner join tbl_jenis_kredit b on a.id_jenis_kredit = b.id_jenis_kredit where b.status=1  ORDER by a.tgl_berakhir ASC;')->result_array();
        
        

        if ($this->form_validation->run() == false) {
 
            
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('promo/buatpromo.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {

            $jumlah_bunga_persen = (float) $this->input->post('jumlah_bunga_persen');
            $total_angsuran_bulan = $this->input->post('total_angsuran_bulan');
            $nama_kredit = $this->input->post('nama_kredit');
            $urlgambar = $this->input->post('urlgambar');
            $text_penawaran = $this->input->post('text_penawaran');
            $text_penawaran_edit = $this->input->post('text_penawaran_edit');
            $admin = (float) $this->input->post('admin');
            $denda = (float) $this->input->post('denda');
            $keterangan_jenis_kredit = $this->input->post('keterangan_jenis_kredit');
            $tgl_berakhir = strtotime($this->input->post('tgl_berakhir'));
            $tgl_penawaran = strtotime($this->input->post('tgl_penawaran'));

            $id_penawaran = $this->input->post('id_penawaran');
            $id_jenis_kredit = $this->input->post('id_jenis_kredit');
            
            $upload_gambarPenawaran = $_FILES['gambarpenawaran'];
            $gambar_penawaran = $upload_gambarPenawaran['name'];

            if (empty($id_penawaran)) {

                // insert data
                
                $config['upload_path'] = './assets/img/promo_kredit/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambarpenawaran')) {
                    // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                    $gbr = $this->upload->data();
                    $gambar_penawaran = $gbr['file_name'];
                } else {
                    echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }

                $data = $this->db->insert('tbl_jenis_kredit', [
                        'jumlah_bunga_persen' => $jumlah_bunga_persen,
                        'total_angsuran_bulan' => $total_angsuran_bulan,
                        'nama_kredit' => $nama_kredit,
                        'keterangan_jenis_kredit' => $keterangan_jenis_kredit,
                        'denda_kredit' => $denda,
                        'admin' => $admin,
                        'status' => 1,
                    ]);

                    // insert tabel tbl_penawaran_kredit
                    // kirim email
                    if($data){

                        // get insert id by last insert
                        $id_jenis_kredit = $this->db->insert_id();

                        $token_promo = base64_encode(random_bytes(10));

                        // insert data to penawaran
                        $data = $this->db->insert('tbl_penawaran_kredit', [
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'gambar_penawaran' => $gambar_penawaran,
                                'urlgambar' => $urlgambar,
                                'text_penawaran' => $text_penawaran,
                                'tgl_penawaran' => $tgl_penawaran,
                                'tgl_berakhir' => $tgl_berakhir,
                                'token_promo' => urlencode($token_promo),
                                
                        ]);

                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                            Berhasil menambahkan satu promo kredit. 
                            </div><br>');
                        
                        redirect('promo/promokredit');
                    }
            }else{
                // update data promo
                $config['upload_path'] = './assets/img/promo_kredit/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambarpenawaran')) {
                    // data['file_name'] merupakan fungsi yang ada di ci untuk mengambila data
                    $gbr = $this->upload->data();
                    $gambar_penawaran = $gbr['file_name'];
                } else {
                    $datagambar = $this->db->get_where('tbl_penawaran_kredit',['id_penawaran'=>$id_penawaran])->row_array(); 
                    $gambar_penawaran = $datagambar['gambar_penawaran'];
                    echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }

                // update tbl_jenis_kredit
                $this->db->set([
                        'jumlah_bunga_persen' => $jumlah_bunga_persen,
                        'total_angsuran_bulan' => $total_angsuran_bulan,
                        'nama_kredit' => $nama_kredit,
                        'keterangan_jenis_kredit' => $keterangan_jenis_kredit,
                        'denda_kredit' => $denda,
                        'admin' => $admin,
                        'status' => 1,
                ]);

                $this->db->where('id_jenis_kredit', $id_jenis_kredit);

                $data = $this->db->update('tbl_jenis_kredit' );

                    // update tabel tbl_penawaran_kredit
                    // kirim email
                    if($data){

                        // update tbl_penawaran_kredit
                        $this->db->set([
                                'id_jenis_kredit' => $id_jenis_kredit,
                                'gambar_penawaran' => $gambar_penawaran,
                                'urlgambar' => $urlgambar,
                                'text_penawaran' => $text_penawaran_edit,
                                'tgl_penawaran' => $tgl_penawaran,
                                'tgl_berakhir' => $tgl_berakhir,
                        ]);

                        $this->db->where('id_penawaran', $id_penawaran);

                        $data = $this->db->update('tbl_penawaran_kredit' );


                        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                            Berhasil edit satu promo kredit. 
                            </div><br>');
                        
                        redirect('promo/promokredit');
                    }
            }

            redirect('promo/promokredit');
        }
    }

    public function deletePenawaran()
    {
        $id_penawaran = $this->input->post('id_penawaran');

        $this -> db -> where('id_penawaran', $id_penawaran);
        $this -> db -> delete('tbl_penawaran_kredit'); 

        // membuat flashdata untuk menampilkan pesan
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
         Berhasil menghapus 1 penawaran kredit.
         </div><br>');

        redirect('promo/promokredit');
    }

    public function kirimpromo()
    {
        $this->form_validation->set_rules('jumlahBunga', 'Bunga Kredit', 'required');
        $this->form_validation->set_rules('totalAngsuran', 'Jumlah Angsuran', 'required');
        $this->form_validation->set_rules('namaKredit', 'nama kredit', 'required');
        $this->form_validation->set_rules('text_penawaran', 'Teks Penawaran', 'required');
        $this->form_validation->set_rules('tgl_berakhir', 'Teks Penawaran', 'required');

        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Kirim Promo';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['promoKredit'] = $this->db->query('SELECT * from tbl_penawaran_kredit a inner join tbl_jenis_kredit b on a.id_jenis_kredit = b.id_jenis_kredit where b.status=1  and a.tgl_berakhir >= '.time().' ORDER by a.tgl_berakhir ASC;')->result_array();
      
        $data['nasabahpromo'] = $this->db->query('select * from tbl_nasabah a , user b where a.kategori_nasabah=1 and a.id_user = b.id_user order by a.id_nasabah ASC;')->result_array();

        if ($this->form_validation->run() == false) {
 
            $this->load->view('templates/header_dashboard', $data);
            $this->load->view('templates/sidebar_dashboard', $data);
            $this->load->view('templates/topbar_dashboard', $data);
            $this->load->view('promo/kirimpromo.php', $data);
            $this->load->view('templates/footer_dashboard', $data);;
        } else {


            $jumlah_bunga_persen = (float) $this->input->post('jumlah_bunga_persen');
            $total_angsuran_bulan = $this->input->post('total_angsuran_bulan');
            $nama_kredit = $this->input->post('nama_kredit');
            $urlgambar = $this->input->post('urlgambar');
            $text_penawaran = $this->input->post('text_penawaran');
            $admin = (float) $this->input->post('admin');
            $denda = (float) $this->input->post('denda');
            $keterangan_jenis_kredit = $this->input->post('keterangan_jenis_kredit');
            $tgl_berakhir = strtotime($this->input->post('tgl_berakhir'));
            $tgl_penawaran = strtotime($this->input->post('tgl_penawaran'));
            
            $upload_gambarPenawaran = $_FILES['gambarpenawaran'];
            $nama_gambar = $upload_gambarPenawaran['name'];

            if ($nama_gambar) {
                $config['upload_path'] = './assets/img/promo_kredit/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambarpenawaran')) {

                    $gbr = $this->upload->data();

                    $data = $this->db->insert('tbl_jenis_kredit', [
                        'jumlah_bunga_persen' => $jumlah_bunga_persen,
                        'total_angsuran_bulan' => $total_angsuran_bulan,
                        'nama_kredit' => $nama_kredit,
                        'keterangan_jenis_kredit' => $keterangan_jenis_kredit,
                        'denda_kredit' => $denda,
                        'admin' => $admin,
                        'status' => 1,
                    ]);

                    // insert tabel tbl_penawaran_kredit
                    // kirim email
                    if($data){

                        // get insert id by last insert
                        $id_jenis_kredit = $this->db->insert_id();
                        $gambar_penawaran = $gbr['file_name'];

                        // insert data to penawaran
                        $data = $this->db->insert('tbl_penawaran_kredit', [
                            'id_jenis_kredit' => $id_jenis_kredit,
                            'gambar_penawaran' => $gambar_penawaran,
                            'gambar_penawaran' => $gambar_penawaran,
                            'urlgambar' => $urlgambar,
                            'text_penawaran' => $text_penawaran,
                            'tgl_penawaran' => $tgl_penawaran,
                            'tgl_berakhir' => $tgl_berakhir,
                            'tgl_pengiriman'=> time(),
                        ]);

                        $id_penawaran = $this->db->insert_id();

                        

                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                            Berhasil menambahkan satu promo kredit. 
                            </div><br>');
                        
                        redirect('promo/kirimpromo');
                    }

                } else {
                    echo $this->upload->display_errors('<p class="alert alert-danger">', '</p>');
                }
            } 

            // membuat flashdata untuk menampilkan pesan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            your data has been added!
            </div><br>');

            redirect('promo/kirimpromo');
        }
    }

    // generate semua kategori nasabah lancar dan tidak lancar
    public function generateKategori( $id_nasabah = null)
    {
           $result = $this->Nasabah_model->generateKategori($id_nasabah);

           if($result){
                redirect('promo/get_nasabah');
           }
        
    }

    public function get_nasabah(){
        $data['nasabah'] = $this->db->query("SELECT * from tbl_nasabah a, user b where a.id_user = b.id_user;")->result_array();
        echo json_encode($data['nasabah']);
    }

    // mengirimkan email ke nasabah lancar
    public function sendpromo() {

        // get promo id
        $id_penawaran = $this->input->post('id_penawaran');

        // get data nasabah lancar
        $data_nasabah = $this->db->get_where('tbl_nasabah', ['kategori_nasabah'=>1]);
                        
        // jumlah_terkirim
        $jumlah = 0;
        foreach($data_nasabah->result_array() as $dn){
            $user = $this->db->get_where('user',['id_user'=>$dn['id_user']])->row_array();

            $email = $user['email'];

            $kirim = $this->_sendEmail($id_penawaran, $email);
            
            if($kirim){
                $this->db->set([
                    'tgl_pengiriman'=> time(),
                ]);
                $this->db->where('id_penawaran', $id_penawaran);
                $this->db->update('tbl_penawaran_kredit');

                $this->db->insert('tbl_history_penawaran',[
                                    'id_nasabah'=> $dn['id_nasabah'],
                                    'id_penawaran'=> $id_penawaran,
                                    'terkirim'=> 1,
                ]);

                // membuat pemberitahuan pendaftaran admin untuk super admin
                // $data['user'] = $this->db->get_where('tbl_nasabah',['id_nasabah'=>$dn['id_nasabah']])->row_array();

                $this->db->insert('notifikasi', [
                    'id_user' => $dn['id_user'],
                    'judul' => 'Promo Kredit',
                    'url' => 'pelayanan/promoKredit',
                    'keterangan' => 'Penawaran Promo Kredit.',
                    'icon' => "fas fa-ad"
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

                $pesan['message'] = 'Promo Kredit';
                $pusher->trigger('my-channel2', 'my-event2', $pesan);


                $jumlah++;
            }
        }

        $data['terkirim'] = [
            'jumlah'=>$jumlah
        ];

        echo json_encode($data['terkirim']);
    }


    public function _sendEmail($id_penawaran, $email)
    {
        // get data email
        $dataemailhtml = $this->getdataemail($id_penawaran);

        // Konfigurasi email
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'isikan_email_anda',  // Email gmail
            'smtp_pass'   => 'isikan_password_anda',  // Password gmail
            'smtp_port'   => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

        
        // mengnisialisasi email
        $this->email->initialize($config);

        $this->email->from('191116015@mhs.stiki.ac.id', 'Achmad Musfi\'ul Chaggi');

        $this->email->to($email);

        $this->email->subject('Promo Kredit BPR AMIRA');

        $this->email->message($dataemailhtml);

        if (!$this->email->send()) {
            echo $this->email->print_debugger();
        } else {
            $this->email->send();
            return true;
        }
    }

    private function getdataemail($id_penawaran) 
    {

        $dataemail = $this->db->query('select * from tbl_penawaran_kredit a, tbl_jenis_kredit b 
                        WHERE a.id_jenis_kredit = b.id_jenis_kredit and a.id_penawaran = '.$id_penawaran. ';')->row_array();

        $data['email']['linkurl'] = $dataemail['urlgambar'];
        $data['email']['namapromo']= $dataemail['nama_kredit'];
        $data['email']['bunga']= $dataemail['jumlah_bunga_persen'];
        $data['email']['totalangs']= $dataemail['total_angsuran_bulan'];
        $data['email']['textpenawaran']= $dataemail['text_penawaran'];
        $data['email']['tgl_dimulai']= date('d-F-Y', $dataemail['tgl_penawaran']);
        $data['email']['tgl_berakhir']= date('d-F-Y', $dataemail['tgl_berakhir']);
        $data['email']['linkpromo']= base_url('pelayanan/promoKredit?id_penawaran='.$id_penawaran.'&token='.$dataemail['token_promo']);

        $theHTMLResponse    = $this->load->view('promo/email.php', $data, true);

        return $theHTMLResponse;
        
    }

    public function kirimPenawaran()
    {
        $id_penawaran = $this->input->post('id_penawaran');
        $email = $this->db->query('select * from tbl_nasabah a inner join user b on a.id_user = b.id_user where a.kategori_nasabah = 1;')->result_array();
        $data['penawaran'] = $this->db->query('select * from tbl_penawaran_kredit where id_penawaran=' . $id_penawaran . ' order by id_penawaran ASC;')->result_array();

        var_dump($email[1]['email']);
        die();
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
         your data has been edited!
         </div><br>');

        redirect('promo/kirimpromo');
    }

    public function historipromo()
    {
        $this->form_validation->set_rules('jumlahBunga', 'Bunga Kredit', 'required');
        $this->form_validation->set_rules('totalAngsuran', 'Jumlah Angsuran', 'required');
        $this->form_validation->set_rules('namaKredit', 'nama kredit', 'required');
        $this->form_validation->set_rules('text_penawaran', 'Teks Penawaran', 'required');
        $this->form_validation->set_rules('tgl_berakhir', 'Teks Penawaran', 'required');

        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Histori Promo';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();

        $data['promoKredit'] = $this->db->query('SELECT * from tbl_penawaran_kredit a inner join tbl_jenis_kredit b 
                    on a.id_jenis_kredit = b.id_jenis_kredit inner join tbl_history_penawaran c 
                    on a.id_penawaran = c.id_penawaran inner join tbl_nasabah d
                    on c.id_nasabah = d.id_nasabah inner join user e 
                    on e.id_user = d.id_user where b.status=1;')->result_array();

        $data['kreditaktif'] = $this->db->query('SELECT DISTINCT a.id_penawaran , c.nama_kredit, b.tgl_penawaran , b.tgl_berakhir, b.urlgambar 
                    FROM tbl_history_penawaran a INNER JOIN tbl_penawaran_kredit b ON a.id_penawaran = b.id_penawaran 
                    INNER JOIN tbl_jenis_kredit c ON b.id_jenis_kredit = c.id_jenis_kredit')->result_array();

        $this->load->view('templates/header_dashboard', $data);
        $this->load->view('templates/sidebar_dashboard', $data);
        $this->load->view('templates/topbar_dashboard', $data);
        $this->load->view('promo/history_promo.php', $data);
        $this->load->view('templates/footer_dashboard', $data);;
        
    }

    public function getdatapromokredit(){

        $id_penawaran = $this->input->post('id_penawaran');

        if($id_penawaran == 'all'){

            $data['nasabah'] = $this->db->query('SELECT c.name, c.email, a.terkirim, a.diklik, a.diajukan, 
                        a.terealisasi, d.id_penawaran, d.tgl_pengiriman , e.nama_kredit
                        FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN user c ON c.id_user = b.id_user 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran 
                        INNER JOIN tbl_jenis_kredit e ON e.id_jenis_kredit = d.id_jenis_kredit 
                        ORDER by b.id_nasabah')->result_array();

            $data['totalhist'] = $this->db->query('SELECT SUM(a.terkirim) as terkirim, SUM(a.diklik) as diklik , SUM(a.diajukan) as diajukan , 
                        SUM(a.terealisasi) as terealisasi FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran')->row_array();
        }else{
             $data['nasabah'] = $this->db->query('SELECT c.name, c.email, a.terkirim, a.diklik, a.diajukan, 
                        a.terealisasi, d.id_penawaran, d.tgl_pengiriman , e.nama_kredit
                        FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN user c ON c.id_user = b.id_user 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran 
                        INNER JOIN tbl_jenis_kredit e ON e.id_jenis_kredit = d.id_jenis_kredit 
                        where d.id_penawaran ='.$id_penawaran.' ORDER by b.id_nasabah')->result_array();

             $data['totalhist'] = $this->db->query('SELECT SUM(a.terkirim) as terkirim, SUM(a.diklik) as diklik , SUM(a.diajukan) as diajukan , 
                        SUM(a.terealisasi) as terealisasi FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran WHERE a.id_penawaran = '.$id_penawaran)->row_array();
        }

    
        echo json_encode($data) ;
       
    }
    

    public function exportpromo($id_penawaran = null)
    {

        $id_penawaran = $id_penawaran;
        

        if($id_penawaran == 'all'){
            $title = "All";

            $data['nasabah'] = $this->db->query('SELECT c.name, c.email, a.terkirim, a.diklik, a.diajukan, 
                        a.terealisasi, d.id_penawaran, d.tgl_pengiriman , e.nama_kredit,
                        d.tgl_penawaran, d.tgl_berakhir, e.total_angsuran_bulan, e.jumlah_bunga_persen, e.admin, e.denda_kredit
                        FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN user c ON c.id_user = b.id_user 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran 
                        INNER JOIN tbl_jenis_kredit e ON e.id_jenis_kredit = d.id_jenis_kredit 
                        ORDER by b.id_nasabah')->result_array();

            $data['totalhist'] = $this->db->query('SELECT SUM(a.terkirim) as terkirim, SUM(a.diklik) as diklik , SUM(a.diajukan) as diajukan , 
                        SUM(a.terealisasi) as terealisasi FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran')->row_array();
        }else{
             $data['nasabah'] = $this->db->query('SELECT c.name, c.email, a.terkirim, a.diklik, a.diajukan, 
                        a.terealisasi, d.id_penawaran, d.tgl_pengiriman , e.nama_kredit,
                        d.tgl_penawaran, d.tgl_berakhir, e.total_angsuran_bulan, e.jumlah_bunga_persen, e.admin, e.denda_kredit
                        FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN user c ON c.id_user = b.id_user 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran 
                        INNER JOIN tbl_jenis_kredit e ON e.id_jenis_kredit = d.id_jenis_kredit 
                        where d.id_penawaran ='.$id_penawaran.' ORDER by b.id_nasabah')->result_array();

             $data['totalhist'] = $this->db->query('SELECT SUM(a.terkirim) as terkirim, SUM(a.diklik) as diklik , SUM(a.diajukan) as diajukan , 
                        SUM(a.terealisasi) as terealisasi FROM tbl_history_penawaran a INNER JOIN tbl_nasabah b ON a.id_nasabah = b.id_nasabah 
                        INNER JOIN tbl_penawaran_kredit d ON d.id_penawaran = a.id_penawaran WHERE a.id_penawaran = '.$id_penawaran)->row_array();

            $title = $data['nasabah'][0]['nama_kredit'];
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

        $sheet->setCellValue('A1', $title); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1

        $sheet->setCellValue('A2', "Terkirim");
        $sheet->mergeCells('A2:B2'); 
        $sheet->getStyle('A2')->getFont()->setBold(true); // Set bold kolom A2
        $sheet->setCellValue('C2', $data['totalhist']['terkirim']);
        $sheet->getStyle('C2')->getFont()->setBold(true); // Set bold kolom A2
        
        $sheet->setCellValue('A3', "Diklik");
        $sheet->mergeCells('A3:B3'); 
        $sheet->getStyle('A3')->getFont()->setBold(true); // Set bold kolom A3
        $sheet->setCellValue('C3', $data['totalhist']['diklik']);
        $sheet->getStyle('C3')->getFont()->setBold(true); // Set bold kolom A3
        
        $sheet->setCellValue('A4', "Diajukan");
        $sheet->mergeCells('A4:B4'); 
        $sheet->getStyle('A4')->getFont()->setBold(true); // Set bold kolom A4
        $sheet->setCellValue('C4', $data['totalhist']['diajukan']);
        $sheet->getStyle('C4')->getFont()->setBold(true); // Set bold kolom A4
        
        $sheet->setCellValue('A5', "Terealisasi");
        $sheet->mergeCells('A5:B5'); 
        $sheet->getStyle('A5')->getFont()->setBold(true); // Set bold kolom A5
        $sheet->setCellValue('C5', $data['totalhist']['terealisasi']);
        $sheet->getStyle('C5')->getFont()->setBold(true); // Set bold kolom A5

        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A7', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B7', "Nama Nasabah"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C7', "Email"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('D7', "ID Promo"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('E7', "Nama Promo"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('F7', "Total Angsuran"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('G7', "Jumlah Bunga"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H7', "Admin"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I7', "Denda"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J7', "Tgl. Mulai"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K7', "Tgl. Berakhir"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('L7', "Tgl. Dikirim"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('M7', "Terkirim"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('N7', "Diklik"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('O7', "Diajukan"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('P7', "Terealisasi"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A7')->applyFromArray($style_col);
        $sheet->getStyle('B7')->applyFromArray($style_col);
        $sheet->getStyle('C7')->applyFromArray($style_col);
        $sheet->getStyle('D7')->applyFromArray($style_col);
        $sheet->getStyle('E7')->applyFromArray($style_col);
        $sheet->getStyle('F7')->applyFromArray($style_col);
        $sheet->getStyle('G7')->applyFromArray($style_col);
        $sheet->getStyle('H7')->applyFromArray($style_col);
        $sheet->getStyle('I7')->applyFromArray($style_col);
        $sheet->getStyle('J7')->applyFromArray($style_col);
        $sheet->getStyle('K7')->applyFromArray($style_col);
        $sheet->getStyle('L7')->applyFromArray($style_col);
        $sheet->getStyle('M7')->applyFromArray($style_col);
        $sheet->getStyle('N7')->applyFromArray($style_col);
        $sheet->getStyle('O7')->applyFromArray($style_col);
        $sheet->getStyle('P7')->applyFromArray($style_col);


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 8; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data['nasabah'] as $data) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['name']);
            $sheet->setCellValue('C' . $numrow, $data['email']);
            $sheet->setCellValue('D' . $numrow, $data['id_penawaran']);
            $sheet->setCellValue('E' . $numrow, $data['nama_kredit']);
            $sheet->setCellValue('F' . $numrow, $data['total_angsuran_bulan']);
            $sheet->setCellValue('G' . $numrow, $data['jumlah_bunga_persen']);
            $sheet->setCellValue('H' . $numrow, $data['admin']);
            $sheet->setCellValue('I' . $numrow, $data['denda_kredit']);
            $sheet->setCellValue('J' . $numrow, date('m-F-Y',$data['tgl_penawaran']));
            $sheet->setCellValue('K' . $numrow, date('m-F-Y',$data['tgl_berakhir']));
            $sheet->setCellValue('L' . $numrow, date('m-F-Y',$data['tgl_pengiriman']));
            $sheet->setCellValue('M' . $numrow, $data['terkirim']);
            $sheet->setCellValue('N' . $numrow, $data['diklik']);
            $sheet->setCellValue('O' . $numrow, $data['diajukan']);
            $sheet->setCellValue('P' . $numrow, $data['terealisasi']);

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

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(50); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(30); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(50); // Set width kolom E
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

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data History Promo");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data History Promo '.$title.'.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }    
}