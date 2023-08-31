<?php

use GuzzleHttp\Client;

Class Nasabah_model extends CI_Model{
	private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'http://127.0.0.1:5000/'
        ]);
    }


    
	public function generateKategori($id_nasabah=null)
	{
        

        if($id_nasabah != null){
            // mencari selisih tahun dari time
            // time() || strtotime('date_format')/60/60/24/365
          
            $id_nasabah = $id_nasabah;
            $this->generateKemacetan($id_nasabah);
            
            $row  = $this->db->query("SELECT user.id_user,user.gender as Gender,user.date_birth as Age, 
                            tbl_nasabah.income as Estimated_Salary, tbl_nasabah.kemacetan_kredit as CreditScore, 
                            user.date_created as Tenure, COUNT(tbl_pengajuan_kredit.id_nasabah) as NumOfProducts,
                            tbl_nasabah.id_nasabah 
                            from user, tbl_nasabah, tbl_pengajuan_kredit, tbl_kredit 
                            WHERE user.id_user=tbl_nasabah.id_user 
                            and tbl_pengajuan_kredit.id_nasabah = tbl_nasabah.id_nasabah 
                            and tbl_kredit.id_pengajuan = tbl_pengajuan_kredit.id_pengajuan 
                            and tbl_nasabah.id_nasabah =".$id_nasabah." 
                            GROUP by tbl_nasabah.id_nasabah")->row_array();
            if($row)
            {
                
                
                $id_user = $row['id_user'];
                $data = [
                        "Gender" => $row['Gender'],
                        "CreditScore"=> $row['CreditScore'],
                        "NumOfProducts" => $row['NumOfProducts'],
                        "Tenure" => $row['Tenure'],
                        "Age" => $row['Age'],
                        "Estimated_Salary" => ceil((($row["Estimated_Salary"])*12)/10000 )//harus ke usd pertahun
                    ];  
                    
                $data["Age"] = intval((time()-$data["Age"])/60/60/24/365);
                $data["Tenure"] = intval((time()-$data["Tenure"])/60/60/24/365);
                
                // $this->db->insert('mahasiswa', $data);
                $response = $this->_client->request('POST', 'predict', [
                    'form_params' => $data
                ]);

                $result = json_decode($response->getBody()->getContents(), true);
                
                if($result['success']==200){
                    $label = $result['status'];
                    $this->db->update('tbl_nasabah', ['kategori_nasabah'=>$label], ['id_user'=>$id_user]);
                }else{
                    $message = $result['error'];
                }
                
            }else{
                $message = array('message'=>'nasabah kosong');
            }
            
            return $message;

        }else{
            
           // mencari selisih tahun dari time
            // time() || strtotime('date_format')/60/60/24/365
            
            $nasabah = $this->db->query("SELECT * from tbl_nasabah;")->result_array();
            foreach($nasabah as $ns){
                 $this->generateKemacetan($ns['id_nasabah']);
            }

            $data_nasabah  = $this->db->query("SELECT user.id_user,user.gender as Gender,user.date_birth as Age, 
                            tbl_nasabah.income as Estimated_Salary, tbl_nasabah.kemacetan_kredit as CreditScore, 
                            user.date_created as Tenure, COUNT(tbl_pengajuan_kredit.id_nasabah) as NumOfProducts,
                            tbl_nasabah.id_nasabah  
                            from user, tbl_nasabah, tbl_pengajuan_kredit, tbl_kredit 
                            WHERE user.id_user=tbl_nasabah.id_user 
                            and tbl_pengajuan_kredit.id_nasabah = tbl_nasabah.id_nasabah 
                            and tbl_kredit.id_pengajuan = tbl_pengajuan_kredit.id_pengajuan 
                            GROUP by tbl_nasabah.id_nasabah");

            $loop=1;
            
            foreach ($data_nasabah->result_array() as $row) {
                $id_user = $row['id_user'];
                $data = [
                        "Gender" => $row['Gender'],
                        "CreditScore"=> $row['CreditScore'],
                        "NumOfProducts" => $row['NumOfProducts'],
                        "Tenure" => $row['Tenure'],
                        "Age" => $row['Age'],
                        "Estimated_Salary" => ceil((($row["Estimated_Salary"])*12)/10000 )//harus ke usd pertahun
                ];  
                    
                $data["Age"] = intval((time()-$data["Age"])/60/60/24/365);
                $data["Tenure"] = intval((time()-$data["Tenure"])/60/60/24/365);
                
                var_dump($data);

                $response = $this->_client->request('POST', 'predict', [
                    'form_params' => $data
                ]);

                $result = json_decode($response->getBody()->getContents(), true);

                if($result['success']==200){
                    $label = $result['status'];
                    $confidence = $result['confidence'];
                    $this->db->update('tbl_nasabah', ['kategori_nasabah'=>$label, 'update_kategori_at' => time(), 'confidence' => $confidence], ['id_user'=>$id_user]);
                }else{
                    $message = $result['error'];
                }
                
            }
            
            return true;
            
        } 
	}

    public function generateKemacetan($id_nasabah=null)
    {
        
        if($id_nasabah != null)
        {
            $id_nasabah = $id_nasabah;
            
            $dataKredit = $this->db->query("SELECT * FROM tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan 
            where b.id_nasabah = $id_nasabah ")->result_array();

            if($dataKredit != null)
            {

                $jumlahPersentase = 0;
                $jml = count($dataKredit);

                foreach($dataKredit as $row2)
                {
                    // get data angsuran(telat || tidak)
                    $data_angsuran = $this->db->query('select * from tbl_angsuran_kredit a 
                                    WHERE a.id_transaksi_kredit ='.$row2['id_transaksi_kredit'].' 
                                    and a.keterangan_angsuran = 1')->result_array();

                    $jumlah_angsuran = count($data_angsuran);
                    $angsuran_tepat = 0;
                    foreach($data_angsuran as $row3){
                        if($row3['status_keterlambatan'] == 1){
                            $angsuran_tepat++;
                        }
                    }

                    if($jumlah_angsuran != 0){
                        
                        $keterangan_kredit = $angsuran_tepat/$jumlah_angsuran * 100;
                    }else{
                        $keterangan_kredit = 0; // angsuran tidak ada, persentase mengangsur 0
                    }

                    // update tbl_kredit.keterangan_kredit
                    $this->db->update('tbl_kredit', ['keterangan_kredit'=>$keterangan_kredit], ['id_transaksi_kredit'=>$row2['id_transaksi_kredit']]);

                    $jumlahPersentase += $keterangan_kredit;
                    
                }

                $persetase = $jumlahPersentase / $jml;
                $label = $persetase/100 * 850;

                if($label < 650)
                {
                    $label = 600;
                } else {
                    $label = $label;
                }

                $this->db->update('tbl_nasabah', ['kemacetan_kredit'=>$label], ['id_nasabah'=>$id_nasabah]);
            }else{
                $this->db->update('tbl_nasabah', ['kemacetan_kredit'=>'600'], ['id_nasabah'=>$id_nasabah]);
            }
        }else{

            $data_nasabah = $this->db->query("SELECT * from tbl_nasabah a inner join user b on a.id_user = b.id_user WHERE b.role_id = 2");
            //print(json_encode($data_nasabah->result_array()));
            foreach ($data_nasabah->result_array() as $row) {
                $id_nasabah = $row['id_nasabah'];

                $dataKredit = $this->db->query("SELECT * FROM tbl_kredit a inner join tbl_pengajuan_kredit b on a.id_pengajuan = b.id_pengajuan 
                where b.id_nasabah = $id_nasabah ");

                $jumlahPersentase = 0;
                $jml = count($dataKredit->result_array());
                foreach($dataKredit->result_array() as $row2)
                {
                    // get data angsuran(telat || tidak)
                    $data_angsuran = $this->db->query('select * from tbl_angsuran_kredit a 
                                    WHERE a.id_transaksi_kredit ='.$row2['id_transaksi_kredit'].' 
                                    and a.keterangan_angsuran = 1')->result_array();

                    $jumlah_angsuran = count($data_angsuran);
                    $angsuran_tepat = 0;
                    foreach($data_angsuran as $row3){
                        if($row3['status_keterlambatan'] == 1){
                            $angsuran_tepat++;
                        }
                    }

                    $keterangan_kredit = $angsuran_tepat/$jumlah_angsuran * 100;
                    // update tbl_kredit.keterangan_kredit
                    $this->db->update('tbl_kredit', ['keterangan_kredit'=>$keterangan_kredit], ['id_transaksi_kredit'=>$row2['id_transaksi_kredit']]);

                    $jumlahPersentase += $keterangan_kredit;
                }
                
                $persetase = $jumlahPersentase / $jml;
                $label = $persetase/100 * 850;

                if($label < 300)
                {
                    $label = 300;
                } else {
                    $label = $label;
                }

                $this->db->update('tbl_nasabah', ['kemacetan_kredit'=>$label], ['id_nasabah'=>$id_nasabah]);   
            }
            return;
        }
    }
}