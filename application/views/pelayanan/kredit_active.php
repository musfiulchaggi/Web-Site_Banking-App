<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
    <div class="card boder-primary mt-4">

        <div class="card-body ">
            <table id="tblNasabah" class="table table-responsive thead-dark table-striped table-bordered table-responsive text-center" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pengajuan</th>
                        <th>ID Transaksi Kredit</th>
                        <th>Nama Kredit</th>
                        <th>ID Nasabah</th>
                        <th>Nama Nasabah</th>
                        <th>Tgl. Realisasi</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Bunga (persen)</th>
                        <th>Denda (persen)</th>
                        <th>Status Lunas</th> 
                        <th>Kelancaran Angsuran(persen)</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kreditActive as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_pengajuan'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_jenis_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_kredit'] ?></td>

                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_nasabah'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['tgl_realisasi_kredit']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_pinjaman'],0,',','.',)  ?></td>       
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=$br['jumlah_bunga_persen'].' %'  ?></td>       
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=$br['denda_kredit'].' %'  ?></td>       
                            <?php if($br['lunas'] == 1) { ?> 
                                <td class="font-weight-normal text-light bg-success" >Lunas</td>    
                            <?php }else { ?> 
                                <td class="font-weight-normal text-light bg-warning" >Belum Lunas</td>    
                            <?php }?>   
                            <td class="font-weight-normal" style="color: black; font-size:smaller;">
                            <?php if( ($br['keterangan_kredit']) != null ) { echo $br['keterangan_kredit'].' %'; } else { echo 'Belum Ada Angsuran';}?>   
                            </td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <?php
                                        if($br['lunas'] == 0){
                                            echo ('<button class="byrAngsuran btn btn-success btn-sm btn-block mb-1" data-toggle="modal" data-target="#mdlBayarAngsuran" 
                                                    data-id-transaksi-kredit="'.$br['id_transaksi_kredit'].'" >Bayar</button>');

                                            echo ('
                                                    <a href="'.base_url('pelayanan/lihatbukupinjaman/'.$br['id_transaksi_kredit']).'"  target="_blank">
                                                    <button class="lihatbukupinjaman btn btn-secondary btn-sm btn-block mb-1" data-toggle="modal" data-target="#lihatbuku_pinjaman" 
                                                    data-id-transaksi-kredit="'.$br['id_transaksi_kredit'].'">
                                                    Print</button>
                                                    </a>
                                                    ');
                                        }else{
                                            echo ('
                                                 <a href="'.base_url('pelayanan/lihatbukupinjaman/'.$br['id_transaksi_kredit']).'"  target="_blank">
                                                    <button class="lihatbukupinjaman btn btn-secondary btn-sm btn-block mb-1" data-toggle="modal" data-target="#lihatbuku_pinjaman" 
                                                    data-id-transaksi-kredit="'.$br['id_transaksi_kredit'].'">
                                                    Print</button>
                                                    </a>
                                            
                                                ');
                                        }
                                    
                                    ?>
                                    
                                    <button class="detailPlyKredit btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#mdldetailPengajuanKredit" 
                                        data-id-transaksi-kredit="<?= $br['id_transaksi_kredit'] ?>"data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>"
                                        data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                        data-jumlah-pinjaman="<?= $br['jumlah_pinjaman'] ?>" data-foto-ktp="<?= $br['foto_ktp'] ?>"
                                        data-foto-kk="<?= $br['foto_kk'] ?>" data-tgl-pengajuan="<?= $br['tgl_pengajuan'] ?>" 
                                        data-keterangan-pengajuan="<?= $br['keterangan_pengajuan'] ?>">Details</button>
                                    
                                </div>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

    <div class="row justify-content-center">


    </div>
</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->

<!-- modal Pembayaran Angsuran Kredit -->
<div class="modal fade" id="mdlBayarAngsuran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-secondary">
                <h3 style="color: white;">Bayar Angsuran</h3>
            </div>
            <div class="col mt-2 text-center">
                <div class="alert alert-warning" role="alert">
                    <div class="col">
                        <span class="text-dark" style="font-size: medium;"> Pembayaran Transfer </span>

                    </div>
                   <span class="text-dark" style="font-size: medium;">ke - No. Rek BCA </span>
                   <span> 1238889889 </span>
                   <span> a.n BPR ARTHA MITRA RAK </span>
                </div>
            </div>
            <div class="shadow card m-1">
                <div class="card-body">
                    <div class="row" style="font-size: small;">

                        <div class="col" >
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                                
                                        Nama
                                </div>
                                        
                                <div id="mdlnama" class="col-7 text-left font-weight-bold">
                                        name
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                            Alamat
                                   
                                </div>
                                        
                                <div id="mdlalamat" class="col-7 text-left font-weight-bold">
                                        alamat_ktp
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                            No. Tlp
                                    </div>
                                  
                                        
                                <div id="notlp" class="col-7 text-left font-weight-bold">
                                        no_hp
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                        Nama kredit
                                
                                </div>

                                <div id="mdlnamakredit" class="col-7 text-left font-weight-bold">
                                        nama_kredit
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                              
                                             Angsuran
                                </div>
                                       
                                <div id="mdlangsuran" class="col-7 text-right font-weight-bold">
                                        
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                            Mulai Tanggal
                                </div>
                                        
                                <div id="mdlmulaitanggal" class="col-7 text-right font-weight-bold">
                                        jumlah_pinjaman
                                </div>
                            </div>
                             
                            
                            
                            
                        </div>
                        
                        
                        <div class="col">
                            
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                              
                                             No. Kredit
                                </div>
                                       
                                <div id="mdlnokredit" class="col-7 text-right font-weight-bold">
                                        jumlah_bunga_angsuran
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                              
                                            Pokok Pinjaman
                                </div>
                                        
                                <div id="mdlpokokpinjamn" class="col-7 text-right font-weight-bold">
                                        jumlah_keterlambatan_hari
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                           
                                            Total Bunga
                                </div>
                                        
                                <div id="mdltotalbunga" class="col-7 text-right font-weight-bold">
                                        jumlah_bunga_angsuran
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                              
                                 
                                            Total Pinjaman
                                </div>
                                        
                                <div id="mdltotalpinjaman" class="col-7 text-right font-weight-bold">
                                        jumlah_bunga_angsuran
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                          
                                            Denda/hari
                                </div>
                                        
                                <div id="mdldendaperhari" class="col-7 text-right font-weight-bold">
                                        jumlah_bunga_angsuran
                                </div>
                            </div>
                            
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                            
                                            Tanggal Pengajuan
                                </div>
                                        
                                <div id="mdltgl_pengajuan" class="col-7 text-right font-weight-bold">
                                        tgl_pengajuan
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                          
                                            Tanggal Realisasi
                              
                                </div>
                                        
                                <div id="mdltgl_realisasi_kredit" class="col-7 text-right font-weight-bold">
                                        tgl_realisasi_kredit
                                </div>
                            </div>
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                       
                                             Jatuh Tempo Bulan ini
                      
                                </div>
                                       
                                <div id="mdljatuhtempo" class="col-7 text-right font-weight-bold">
                                        tgl_jatuh_tempo
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- memunculkan formulir atau menghilangkan tergantung konfirmasi pembayaran sebelumnya -->
            <div id="htmlFormAngsuran">

                        <!-- bikin form dulu file (action, method, enctype="multipart")-->
                    <?= form_open_multipart('pelayanan/bayarAngsuran',['id'=>'formtambahangsuran']) ?>
                    <div class="modal-body">
                        <div class="form-group row" hidden>
                            <label for="id_transaksi_kredit" class="col-sm-4 col-form-label ">ID Transaksi Kredit</label>
                            <div class="col-sm-8 ">
                                <input type="text" class="form-control text-right " id="id_transaksi_kredit" name="id_transaksi_kredit">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('id_transaksi_kredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row" hidden>
                            <label for="status_keterlambatan" class="col-sm-4 col-form-label ">status_keterlambatan</label>
                            <div class="col-sm-8 ">
                                <input type="text" class="form-control text-right " id="status_keterlambatan" name="status_keterlambatan">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('status_keterlambatan', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-form-label">Tanggal Bayar</div>
                            <div class="col-sm-8">
                                <input class="form-control text-right" value="" type="text" name="tgl_mengangsur" id="tgl_mengangsur" placeholder="-" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_jatuh_tempo" class="col-sm-4 col-form-label ">Tanggal Jatuh Tempo</label>
                            <div class="col-sm-8 ">
                                <input type="text" class="form-control text-right " id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('tgl_jatuh_tempo', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_pokok" class="col-sm-4 col-form-label ">Jumlah Pokok</label>
                            <div class="col-sm-8 ">
                                <input type="text" class="form-control text-right " id="jumlah_pokok_angsuran" name="jumlah_pokok_angsuran" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('income', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_bunga" class="col-sm-4 col-form-label">Jumlah Bunga</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-right" id="jumlah_bunga_angsuran" name="jumlah_bunga_angsuran" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('jumlah_bunga', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="denda" class="col-sm-4 col-form-label">Denda Per-hari</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-right" id="dendaperhari" name="dendaperhari" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('denda', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="denda" class="col-sm-4 col-form-label">Keterlambatan (hari)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-right" id="keterlambatanhari" name="keterlambatanhari" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('denda', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="denda" class="col-sm-4 col-form-label">Total Denda</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-right" id="denda_total" name="denda_total" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('denda', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="denda" class="col-sm-4 col-form-label">Total dibayarkan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-right" id="jumlah_total_angsuran" name="jumlah_total_angsuran" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                <!-- menampilkan pesan eror -->
                                <?= form_error('denda', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-form-label" >  Upload Bukti Pembayaran  </div>
                            <div class="col-sm-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="bukti_angsuran" name="bukti_angsuran">
                                    <label id="bukti_angsuran" class="custom-file-label" for="bukti_angsuran">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <!-- mangakali bootstrap row rata kanan justify-content-end-->
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-8 " id="footertambahangsuran">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formtambahangsuran')[0].reset();">Close</button>
                                <button type="submit" class="btn btn-success"><b>Bayar</b></button>
                            </div>
                        </div> 
                    </div>
                    <?= form_close() ?>
            </div>
           
        </div>
    </div>
</div>

<!-- detail pinjaman -->
<!-- modal Detail Pengajuan Kredit -->
<div class="modal fade" id="mdldetailPengajuanKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header justify-content-center bg-secondary text-light">
                    <h3>Detail Transaksi Kredit</h3>
                </div>
                <!-- bikin form dulu file (action, method, enctype="multipart")-->
                <?= form_open_multipart('pelayanan/tambahPengajuanKredit',['id'=>'formdetailpelayanankreditedit']) ?>
                <div class="modal-body">
                    <!-- isi data nasabah -->
                    <div class="shadow rounded jumbotron jumbotron-fluid py-2 bg-info" >
                        <div class="container">
                            <div class="row text-white">
                                <div class="col-6">
                                    
                                    <div class="form-group row">
                                        <label for="id_nasabah" class="col-sm-4 col-form-label  ">Nasabah</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control disabled" id="id_nasabah_detail" name="id_nasabah" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('id_nasabah', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control text-center" id="email_detail" name="email" value="" readonly>
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="no_hp" class="col-sm-4 col-form-label">Nomor HP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_hp_detail" name="no_hp" value="" placeholder="+62" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('no_hp', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Income Per-bulan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control text-right" id="income_detail" name="income" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('income', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Pengeluaran Per-bulan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control text-right" id="pengeluaran_detail" name="pengeluaran" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('pengeluaran', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
                                
        
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Pendidikan Terakhir</label>
                                        <div class="col-sm-8">
                                            <select class="custom-select" id="pendidikan_detail" name="pendidikan" value="" disabled>
                                                <option>Pilih Pendidikan Terakhir</option>
                                                <option value="SD" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'SD'){echo ('selected');};} ?>>SD</option>
                                                <option value="SMP" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'SMP'){echo ('selected');};} ?>>SMP</option>
                                                <option value="SMA/SMK" <?php if($nasabah){ if( ($nasabah['pendidikan']) == "SMA/SMK" ){echo ('selected');};} ?>>SMA/SMK</option>
                                                <option value="S1" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S1'){echo ('selected');};} ?>>S1</option>
                                                <option value="S2" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S2'){echo ('selected');};} ?>>S2</option>
                                                <option value="S3" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S3'){echo ('selected');};} ?>>S3</option>
                                            </select>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('pendidikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Pekerjaan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pekerjaan_detail" name="pekerjaan" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('pekerjaan', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">NIK</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_ktp_detail" name="no_ktp" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('no_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
                                    
        
                                    
                                </div>
                                <div class="col-6">
                                    
        
                                    <div class="form-group row">
                                        <div class="col-sm-4">Foto KTP</div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col">
                                                    <img id="foto_ktp_detail" src="" class="img img-fluid">
        
                                                </div>
                                            </div>
        
                                        </div>
                                    </div>
        
                                    
        
                                    <div class="form-group row">
                                        <div class="col-sm-4">Foto KK</div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col">
                                                    <img id="foto_kk_detail" src=" " class="img img-fluid">
        
                                                </div>
                                               
                                            </div>
        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamat_ktp" class="col-sm-4 col-form-label">Alamat (KTP)</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="alamat_ktp_detail" rows="3" readonly></textarea>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('alamat_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_ibu_kandung_detail" name="nama_ibu_kandung" value="" readonly>
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('nama_ibu_kandung', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
        
        
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Status</label>
                                        <div class="col-sm-8">
                                            <select class="custom-select" id="status_detail" name="status" value="" disabled>
                                                <option >Pilih Status</option>
                                                <option value="Menikah" <?php if($nasabah){ if( ($nasabah['status']) == 'Menikah'){echo ('selected');};} ?>>Menikah</option>
                                                <option value="Belum Menikah" <?php if($nasabah){ if( ($nasabah['status']) == 'Belum Menikah'){echo ('selected');};} ?>>Belum Menikah</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" id="status" name="status" value="<?php if($nasabah){ echo ($nasabah['status']);}  ?>"> -->
                                            <!-- menampilkan pesan eror -->
                                            <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- akhir isi data nasabah -->

                    <div class="form-group row">
                        <div class="col-sm-8 ">
                            <input type="text" class="form-control disabled" id="id_pengajuan_detail" name="id_pengajuan" value="" hidden>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_jenis_kredit" class="col-sm-4 col-form-label  ">ID Jenis Kredit</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="id_jenis_kredit" id="id_jenis_kredit_detail" required disabled>
                                <option value="" selected disabled="">-Pilih Jenis Kredit-</option>
                                <?php foreach ($jenisKredit as $row ) {?>
                                <option value="<?php echo $row['id_jenis_kredit'] ?>" <?php if($row['status'] == "1"){
                                        echo ('class="bg-success text-white"');
                                    } ?>
                                    ><?php echo strtoupper($row['nama_kredit']).'- Angsuran: '.$row['total_angsuran_bulan'].' bulan, - Bunga : '.$row['jumlah_bunga_persen'].' persen'; ?></option>
                                <?php } ?>
                            </select>
                            
                            <!-- menampilkan pesan eror -->
                            <?= form_error('id_jenis_kredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                        </div>
                    </div>

                    <!-- jaminan kredit -->
                    <div class="form-group row" id="cari_jaminan">
                        <label for="pabrikan" class="col-sm-4 col-form-label ">Pilih Jaminan(Agunan)</label>
                        <div class="col-8">

                            <!-- awal edit -->
                            <div class="card text-center">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#" id="navkendaraan_detail">Kendaraan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" id="navshm_detail">SHM/SHGB</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                        <!-- isi dari form jaminan disini -->
                                    <!-- awal kendaraan -->
                                    <div class="col" id="inputjaminankendaraan_detail">
                                        <div class="row">
    
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="pabrikan_detail" name="pabrikan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Pabrikan</option>
                                                    <option value="honda" >Honda</option>
                                                    <option value="yamaha" >Yamaha</option>
                                                    <option value="kawasaki" >Kawasaki</option>
                                                    <option value="suzuki" >Suzuki</option>
                                                </select>
                                                <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="jenis_kendaraan_detail" name="jenis_kendaraan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Jenis Kendaraan</option>
                                                    <option value="2" >Sepeda Motor</option>
                                                    <option value="4" >Mobil</option>
                                                    </select>
                                                <!-- <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"> -->
                                            </div>
                                            <div class="col-sm-4">
                    
                                                <input type="text" class="form-control" id="merk_detail" name="merk" placeholder="Nama Kendaraan">
                                            </div>
                                            <div class="col-sm-2">
                    
                                                <button type="button" class="btn btn-success btn-block" id="btn_cari2" name="btn_cari">
                                                    <span>
                                                        <i class="fas fa-search"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <!-- ini yang dikirim -->
                                                <input type="text" class="form-control" id="id_jaminan_detail" name="id_jaminan" value="" hidden> 
                                                <input type="text" class="form-control" id="nama_kendaraan_detail" name="nama_kendaraan" value="" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="pabrikan" class="col-form-label  text-left">Taksasi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                
                                                <input type="text" class="form-control bg-warning text-light" id="taksasi_detail" name="taksasi" value="" readonly>
                                            </div>
                                        </div>
    
                                        <!-- <div class="row justify-content-end" id="dftrkendaraantbl_detail">
                                            <div class="col mt-2">
                                                <div class="shadow jumbotron p-2">
                                                    <div class="table-renponsive overflow-auto rounded" id="tbl_daftar_jaminan_detail" style=" max-height: 250px;">
                
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
    
                                        </div> -->
                                        
    
                                    </div>
                                    <!-- akhir kendaraan -->

                                     <!-- awal SHM/SHGB -->
                                    <div class="col" id="inputjaminanshm_detail" hidden>

                                            <div class="row mt-3">
                                                <div class="col-sm-6 text-left">
                                                    <!-- ini yang dikirim -->
                                                    <input type="text" class="form-control" id="id_jaminan_shm_detail" name="id_jaminan_shm" value="" hidden> 
                                                    <label for="pabrikan" class="col-form-label  text-left">Taksasi Per/ 1 m<sup>2</sup></label>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    
                                                    <input type="text" class="form-control" id="taksasishm_detail" name="taksasishm" value="" readonly>
                                                </div>
                                                
                                            </div>
        
                                            <div class="row mt-3" id="">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Input Luas Tanah (m<sup>2</sup>)</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control" id="luastanah_detail" name="luastanah" value="" readonly>
                                                            
                                                </div>
                                            
        
                                            </div>

                                            <div class="row mt-3" id="makspinjamanshm_detail">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Max. Pinjaman</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control bg-warning text-light" id="inputmaksshm_detail" name="inputmaksshm" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                                            
                                                </div>
                                            
        
                                            </div>
                                            
                                        
    
                                    </div>
                                    <!-- akhir SHM/SHGB -->
                                </div>
                            </div>
                            <!-- akhirrrrr -->
                        </div>

                        
                    </div>

                    <div class="form-group row">
                        <label for="jumlah_pinjaman" class="col-sm-4 col-form-label ">Jumlah Pinjaman</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="jumlah_pinjaman_detail" name="jumlah_pinjaman" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('jumlah_pinjaman', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-form-label ">Foto Jaminan(Agunan)</div>
                        <div class="col-sm-8">
                                <!-- multipart -->
                                

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_jaminan_detail">

                                                                                   

                                        </div>
                                    </div>
                                </div>
                                
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_surat_kepemilikan" class="col-sm-4 col-form-label " id="labelnomor_detail">Nomor BPKB</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nomor_surat_kepemilikan_detail" name="nomor_surat_kepemilikan" value="" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('nomor_surat_kepemilikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="atas_nama" class="col-sm-4 col-form-label" id="labelatasnama_detail">Atas Nama (BPKB)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="atas_nama_detail" name="atas_nama" value="" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('atas_nama', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dimiliki_tahun" class="col-sm-4 col-form-label ">Dimiliki Tahun</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="dimiliki_tahun_detail" name="dimiliki_tahun" disabled>
                                <option selected="selected">Tahun</option>
                                <?php
                                for($i=date('Y'); $i>=date('Y')-32; $i-=1){
                                echo ("<option value=".$i.">" .$i." </option>");
                                }
                                ?>
                            </select>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('dimiliki_tahun', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_beli" class="col-sm-4 col-form-label ">Harga Beli</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="harga_beli_detail" name="harga_beli" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('harga_beli', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diperoleh_dengan" class="col-sm-4 col-form-label  ">Diperoleh Dengan</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="diperoleh_dengan_detail" id="diperoleh_dengan" required disabled>                           
                                <option value="Beli" >Beli</option>
                                <option value="Warisan" >Warisan</option>
                                <option value="Hibah" >Hibah</option>
                            
                            </select>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('id_jenis_kredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-form-label ">Foto Surat Jaminan</div>
                        <div class="col-sm-8">
                            <!-- multipart -->
                            <div class="col px-0" id="suratkendaraan_detail">
                                <div class="col px-0">
                                    <span class="text-dark">BPKB Kendaraan</span>
                                </div>
                                
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_bpkb_detail">

                                                                                   

                                        </div>
                                    </div>
                                </div>
                                <div class="col px-0">
                                    <span class="text-dark">STNK Kendaraan</span>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_stnk_detail">
                                           

                                                                                  
                                        </div>

                                    </div>
                                </div>

                                

                            </div> 

                            <!-- awal surat shm -->
                            <div class="col px-0" id="suratshm_detail">
                                <div class="col text-dark">
                                    <span >SHM/SHGB</span>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_shm_detail">
                                        
                                        
                                        </div>

                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                    
                    <div class="col px-0">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formdetailpelayanankreditedit')[0].reset();">Close</button>
                           
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
</div>

</div>
