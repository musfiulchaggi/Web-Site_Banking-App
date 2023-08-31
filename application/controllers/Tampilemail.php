<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Thumbnails;

class Tampilemail extends CI_Controller
{
    public function __construct() 
    {
        // cek masuk terlebih dahulu
        parent::__construct();

        
    }

    public function viewemail()
    {
        
        // data yang dikirim adalah arrray dan yg digunakan mulai index 1 bukan 0
        $data['title'] = 'Buat Promo';
        // $data['user'] = $this->db->get_where('user', [
        //     'email' => $this->session->userdata('email')
        // ])->row_array();
        // $data['notifikasi'] = $this->db->query('select * from notifikasi where id_user=' . $data['user']['id_user'] . ' order by tanggal desc limit 6;')->result_array();
        

        // $data['promoKredit'] = $this->db->query('SELECT * from tbl_penawaran_kredit a inner join tbl_jenis_kredit b on a.id_jenis_kredit = b.id_jenis_kredit where b.status=1 order by a.id_penawaran DESC;')->result_array();
        
        $data['email']['linkurl'] = $this->input->post('linkurl');
        $data['email']['namapromo']= $this->input->post('namapromo');
        $data['email']['bunga']= $this->input->post('bunga');
        $data['email']['totalangs']= $this->input->post('totalangs');
        $data['email']['textpenawaran']= $this->input->post('textpenawaran');
        $data['email']['tgl_dimulai']= date('d-F-Y', strtotime($this->input->post('tgl_dimulai')));
        $data['email']['tgl_berakhir']= date('d-F-Y', strtotime($this->input->post('tgl_berakhir')));
        $data['email']['linkpromo']= base_url('pelayanan/promoKredit');

        $theHTMLResponse    = $this->load->view('promo/email.php', $data, true);

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html'=> $theHTMLResponse)));


        
    }


   
}