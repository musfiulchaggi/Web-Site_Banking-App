<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>

     <div class="row justify-content-end">
        <div class="col">
            <button  class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#mdlTambahAngs">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text">Tambahkan Angsuran Kredit</span>
            </button>

        </div>
    </div>

    <div class="card boder-primary mt-4">
        <div class="card-body ">
            <table id="tblNasabah" class="table table-responsive thead-dark table-striped table-bordered " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Nasabah</th>
                        <th>Nama</th>
                        <th>ID Pengajuan</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal Byr</th>
                        <th>Jatuh Tempo</th>
                        <th>Jumlah Pokok</th> 
                        <th>Jumlah Bunga</th> 
                        <th>Denda</th> 
                        <th>Bukti Angsuran</th> 
                        <th>Keterangan Angsuran</th> 
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($angsuranKredit as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_nasabah'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_pengajuan'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_transaksi_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('m-d-Y',$br['tanggal']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('m-d-Y',$br['tgl_jatuh_tempo']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_pokok'] ,0,',','.',)?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_bunga'],0,',','.',) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['denda'],0,',','.',) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;"> 
                                <a href="<?= base_url('assets/img/angsuran/' . $br['bukti_angsuran']) ?>" target="blank">
                                <img class="img-fluid" src="<?= base_url('assets/img/angsuran/' . $br['bukti_angsuran']) ?>" style="width:50px"></a>
                            </td>
                            
                            <?php if($br['keterangan_angsuran'] == 1) { ?>
                                <td class="bg-success text-light text-center" style=" font-size:medium;"> 
                                Diterima 
                                </td>
                             <?php } else if ($br['keterangan_angsuran'] == 2) { ?> 
                                <td class="bg-danger text-light text-center" style=" font-size:medium;"> 
                                Ditolak 
                                </td>
                             <?php }else { ?> 
                                <td class="bg-warning text-light text-center" style=" font-size:medium;"> 
                                Menunggu Konfirmasi 
                                </td>
                            <?php }?>
                            
                            <?php
                                if($br['keterangan_angsuran'] == 0)
                                { ?>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                        <div class="col">
                                            <button class="terimaAgs btn btn-success btn-sm btn-block " data-toggle="modal" data-target="#mdlTerimaAngsuran" 
                                            data-id-angsuran="<?= $br['id_angsuran'] ?>">Terima</button>

                                            <button class="tolakAgs btn btn-danger btn-sm btn-block " data-toggle="modal" data-target="#mdlTolakAngsuran" 
                                            data-id-angsuran="<?= $br['id_angsuran'] ?>">Tolak</button>

                                            <button class="detailangsadmin btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#mdlDetailAngsuran" 
                                            data-id_transaksi_kredit="<?= $br['id_transaksi_kredit'] ?>"
                                            data-id_angsuran="<?= $br['id_angsuran'] ?>" 
                                            onclick="$('#mdlDetailAngsuran #id_transaksi_kredit').attr('value', $(this).data('id_transaksi_kredit'))
                                            $('#mdlDetailAngsuran #id_angsuran').attr('value', $(this).data('id_angsuran'))">Details</button>
                                        </div>
                                    </td>
                                <?php } 
                                else
                                { ?>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                        <div class="col">
                                            <button class="detailangsadmin btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#mdlDetailAngsuran" 
                                            data-id_transaksi_kredit="<?= $br['id_transaksi_kredit'] ?>"
                                            data-id_angsuran="<?= $br['id_angsuran'] ?>" 
                                            onclick="$('#mdlDetailAngsuran #id_transaksi_kredit').attr('value', $(this).data('id_transaksi_kredit'))
                                            $('#mdlDetailAngsuran #id_angsuran').attr('value', $(this).data('id_angsuran'))">Details</button>
                                        </div>
                                    </td>
                                <?php }
                            ?>
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
<!-- Terima Angsuran -->
<div class="modal fade" id="mdlTerimaAngsuran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success">
                <h5 class="modal-title text-light" id="">Apakah anda yakin ingin menerima angsuran ini?</h5>
            </div>
            <?= form_open_multipart('kredit/terimaAngsuran', ['id' => 'formterimaangsuran']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_angsuran" name="id_angsuran" value="" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formterimaangsuran')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-success" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak Angsuran -->
<div class="modal fade" id="mdlTolakAngsuran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Apakah anda yakin ingin menerima pengajuan kredit ini?</h5>
            </div>
            <?= form_open_multipart('kredit/tolakAngsuran', ['id' => 'formtolakangsuran']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_angsuran" name="id_angsuran" value="" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formtolakangsuran')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak Angsuran -->
<div class="modal fade" id="mdlTambahAngs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success">
                <h5 class="modal-title text-light" id="">Pilih Nasabah</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row justify-content-end">
                    <label for="id_jenis_kredit" class="col-sm-3 col-form-label ">Daftar Nasabah</label>
                    <div class="col-sm-6 ">
                        <select class="form-control" name="id_nasabah" id="id_nasabah_select" required>
                            <option value="" selected disabled="">-Pilih Nasabah-</option>
                            <?php foreach ($nasabah as $row ) {?>
                            <option value="<?php echo $row['id_nasabah'] ?>" ><?php echo strtoupper($row['id_nasabah']).'-'.$row['name']?></option>
                            <?php } ?>
                        </select>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('id_jenis_kredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                    <div class="col-3">
                        <button type="submit" id="btncarikredit" class="btn btn-success btn-sm btn-block">Cari Kredit</button>
                    </div>
                </div>
                <div class="modal-footer d-block">
                    <div class="col" id="daftarkredit">

                    </div>

                    <div class="col-3">

                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" onclick="$('#formcarikredit')[0].reset();">Batal</button>
                        <!-- <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal Bayar Angsuran -->
<div class="modal fade" id="mdlBayarAngsuran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-secondary">
                <h3 style="color: white;">Bayar Angsuran</h3>
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
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                            Angsuran Ke-
                                </div>
                                        
                                <div id="mdlangsuranke" class="col-7 text-right font-weight-bold">
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
                    <?= form_open_multipart('kredit/angsuranKredit',['id'=>'formtambahangsuran']) ?>
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
                                <div class="row">

                                    <div class="col-6">
                                        
                                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" onclick="$('#formtambahangsuran')[0].reset();">Close</button>
                                    </div>
                                    <div class="col-6">
                                        
                                        <button type="submit" class="btn btn-success btn-block"><b>Bayar</b></button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <?= form_close() ?>
            </div>
           
        </div>
    </div>
</div>

<!-- modal detail Angsuran Kredit -->
<div class="modal fade" id="mdlDetailAngsuran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <div class="row my-1 border-bottom border-primary mx-2 px-0">
                                <div class="col-5" style=" color:black;">
                               
                                            Angsuran Ke-
                                </div>
                                        
                                <div id="mdlangsuranke" class="col-7 text-right font-weight-bold">
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
                            <label for="id_transaksi_kredit" class="col-sm-4 col-form-label ">ID Angsuran Kredit</label>
                            <div class="col-sm-8 ">
                                <input type="text" class="form-control text-right " id="id_angsuran" name="id_angsuran">
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
                                    <img src="" class="img-thumbnail" id="bukti_trans_edit">

                                </div>
                        </div>
                        <!-- mangakali bootstrap row rata kanan justify-content-end-->
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-8 " id="footertambahangsuran">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formtambahangsuran')[0].reset();">Close</button>
                            </div>
                        </div> 
                    </div>
                    <?= form_close() ?>
            </div>
           
        </div>
    </div>
</div>
