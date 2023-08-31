<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>

    

        <!-- chart js -->
          <div class="col text-center p-0 mt-5" id="cardDaftarPembayaran">
        <div class="shadow card">
            <div class="card-header bg-primary"> 
                <div class="row">

                    <span class="text-light text-center align-bottom" id="titlepromo">Kredit Active </span>
    
                    <!-- <div class="col">
                        <div class="col text-right">
                            
                            <a href="<?= base_url('promo/exportpromo/all')?>" class=" btn btn-success btn-icon-split" id="btngenerateexcel">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-export" style="color: white;"></i>
                                        </span>
                                        <span class="text">Export History</span>
                            </a>
                               
                        </div>
                    </div> -->
                     
                </div>
                
            </div>        
        
            <div class="card-body">    
                <div class="row">

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Terealisasikan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="terkirimtop"><?= 
                                                    'Rp. '.number_format($total_terealisasikan,0,',','.');
                                                ?></div>
                                            </div>
                                            <!-- <div class="col-auto">
                                                <i class="far fa-paper-plane fa-2x text-gray-300"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Kredit Lancar</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="dikliktop"><?= 
                                                    'Rp. '.number_format($total_kredit_lancar,0,',','.');
                                                ?></div>
                                            </div>
                                            <!-- <div class="col-auto">
                                                <i class="far fa-hand-point-up fa-2x text-gray-300"></i> 
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kredit Macet
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col text-center">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="diajukantop"><?= 
                                                    'Rp. '.number_format($total_kredit_macet,0,',','.');
                                                ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-auto">
                                                 <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Persentase Kemacetan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="terealisasitop"><?=
                                                    ceil($persentase_kemacetan).' %'
                                                ?></div>
                                            </div>
                                            <!-- <div class="col-auto">
                                                <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <div class="col">
                                            <!-- chart bar -->
                                            <div class="chart-bar">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class="">

                                                        </div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class="">

                                                        </div>
                                                    </div>
                                                </div>
                                            <canvas id="myBarChart2" width="668" height="320" style="display: block; width: 668px; height: 320px;" class="chartjs-render-monitor"></canvas>
                                            </div>
                                            
                        </div>
            </div>
        </div>
    </div>
    

        <!-- akhir chart -->
 
    <div class="shadow card boder-primary mt-4">

          <div class="card-header bg-primary"> 
                <div class="row">

                    <span class="text-light text-center align-bottom text-lg" id="">Daftar Kredit Active</span>
    
                    <div class="col">
                        <div class="col text-right">
                            

                            <a   class=" btn btn-success btn-icon-split" data-toggle="modal" data-target="#mdlExportKredit" >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-export" style="color: white;"></i>
                                        </span>
                                        <span class="text">Export Daftar Kredit</span>
                            </a>
                               
                        </div>
                    </div>
                </div>
                
            </div>

        <div class="card-body ">
            <table id="tblNasabah" class="table table-responsive thead-dark table-striped table-bordered text-center" style="width: 100%;">
               <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pengajuan</th>
                        <th>ID Transaksi Kredit</th>
                        <th>Nama Kredit</th>
                        <th>Jenis Kredit</th>
                        <th>ID Nasabah</th>
                        <th>Nama Nasabah</th>
                        <th>Tgl. Realisasi</th>
                        <th>Tgl. JatuhTempo</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Bunga (persen)</th>
                        <th>Denda (persen)</th>
                        <th>Status Lunas</th> 
                        <th>ID Petugas (AO)</th> 
                        <th>Kelancaran Angsuran(persen)</th> 
                        <th>Jumlah Pokok</th> 
                        <th>Jumlah Bunga</th> 
                        <th>Total Angs/bln</th> 
                        <th>Denda/hr</th> 
                        <th>Telat (hari)</th> 
                        <th>Telat (bulan)</th> 
                        <th>Tunggakan Pokok</th> 
                        <th>Tunggakan Bunga</th> 
                        <th>Tunggakan Angs/bln</th> 
                        <th>Tunggakan Denda</th> 
                        <th>Total Tunggakan</th> 

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kreditActive as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_pengajuan'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_transaksi_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_kredit'] ?></td>
                            <?php if($br['status'] == 1) {?>
                                <td class="font-weight-normal text-light bg-success" style="color: black; font-size:smaller;"> Kredit Promo</td>
                            <?php }else{?>
                                <td class="font-weight-normal" style="color: black; font-size:smaller;"> Kredit Regular</td>
                            <?php }?>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_nasabah'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-M-Y',$br['tgl_realisasi_kredit']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['tgl_jatuh_tempo'] ?>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_pinjaman'],0,',','.',)  ?></td>       
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=$br['jumlah_bunga_persen'].' %'  ?></td>       
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=$br['denda_kredit'].' %'  ?></td>       
                            <?php if($br['lunas'] == 1) { ?> 
                                <td class="font-weight-normal text-light bg-success" >Lunas</td>    
                            <?php }else { ?> 
                                <td class="font-weight-normal text-light bg-warning" >Belum Lunas</td>    
                            <?php }?>   
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_ao']  ?></td>    
                            <td class="font-weight-normal" style="color: black; font-size:smaller;">
                            <?php if( ($br['keterangan_kredit']) != null ) { echo $br['keterangan_kredit'].' %'; } else { echo 'Belum Ada Angsuran';}?>   
                            </td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_pokok'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_bunga'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_bayar_perbulan'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format(ceil($br['denda_perhari']),0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=  $br['telat_hari']  ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=  $br['telat_bulan']  ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['total_tunggakan_angsuran_pokok'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['total_tunggakan_angsuran_bunga'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format( $br['total_tunggakan_angsuran_bulanan'],0,',','.')  ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['total_denda'],0,',','.')   ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['total_tunggakan_angsuran_semuanya'],0,',','.')   ?></td>

                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <a href="<?= base_url('kredit/lihatbukupinjaman/'.$br['id_transaksi_kredit'].'/'.$br['id_nasabah']) ?>"  target="_blank">
                                                    <button class="lihatbukupinjaman btn btn-secondary btn-sm btn-block mb-1" data-toggle="modal" data-target="#lihatbuku_pinjaman" 
                                                    data-id-transaksi-kredit="<?=$br['id_transaksi_kredit']?>">
                                                    Print</button>
                                    </a>
                                </div>
                                <div class="col">
                                    <button class="detailPengajuanKredit btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#mdldetailPengajuanKredit" 
                                    data-id-transaksi-kredit="<?= $br['id_transaksi_kredit'] ?>" 
                                    data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>">Details</button>
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

<!-- Modal Edit Mesin-->


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
                                                <option value="SD" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == 'SD'){echo ('selected');};} ?>>SD</option>
                                                <option value="SMP" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == 'SMP'){echo ('selected');};} ?>>SMP</option>
                                                <option value="SMA/SMK" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == "SMA/SMK" ){echo ('selected');};} ?>>SMA/SMK</option>
                                                <option value="S1" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == 'S1'){echo ('selected');};} ?>>S1</option>
                                                <option value="S2" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == 'S2'){echo ('selected');};} ?>>S2</option>
                                                <option value="S3" <?php if( isset($nasabah)){ if( ($nasabah['pendidikan']) == 'S3'){echo ('selected');};} ?>>S3</option>
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
                                                <option value="Menikah" <?php if( isset($nasabah)){ if( ($nasabah['status']) == 'Menikah'){echo ('selected');};} ?>>Menikah</option>
                                                <option value="Belum Menikah" <?php if( isset($nasabah)){ if( ($nasabah['status']) == 'Belum Menikah'){echo ('selected');};} ?>>Belum Menikah</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" id="status" name="status" value="<?php if( isset($nasabah)){ echo ($nasabah['status']);}  ?>"> -->
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
                                                <select class="custom-select" id="pabrikan_detail" name="pabrikan" value="<?php if( isset($nasabah)){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Pabrikan</option>
                                                    <option value="honda" >Honda</option>
                                                    <option value="yamaha" >Yamaha</option>
                                                    <option value="kawasaki" >Kawasaki</option>
                                                    <option value="suzuki" >Suzuki</option>
                                                </select>
                                                <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="jenis_kendaraan_detail" name="jenis_kendaraan" value="<?php if( isset($nasabah)){ echo ($nasabah['pendidikan']);}  ?>">
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

<!-- export kredit-->
<div class="modal fade" id="mdlExportKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
               <div class="card">
                    <div class="card-header bg-primary">
                        <span class="text-light">
                            Export Daftar Kredit Active
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row">
            
                                                    <div class="col-sm-9">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                
                                                                <label for="promokredit" class="col-form-label  text-center">Pilih Berdasarkan AO</label>

                                                                  <div class="col text-left mt-3">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="custom-select" id="histpromoselect" name="histpromoselect" 

                                                                onchange="  var selectedOption = $(this).find('option:selected');
                                                                            var selectedValue = selectedOption.val();
                                                                            var selectedText = selectedOption.text();
                                                                            var hrefNew = '<?= base_url('kredit/exportkredit/')?>';
                                                                            hrefNew = hrefNew+selectedValue;

                                                                            $('#btnexportkreditao').attr('href', hrefNew);

                                                                            ">

                                                                    <option value="all" >All</option>
                                                                    <?php foreach($ao as $ka) :?>
                                                                    <option value="<?= $ka['id_user']?>" >
                                                                        <?= $ka['id_user'].' - '.$ka['name'] ?>
                                                                    </option>
                                                                    <?php endforeach;?>
                                                                </select>
            
                                                            </div>
                                                            <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-3 ">
                            
                                                        <div class="row justify-content-between">
                                                          

                                                            <div class="col text-right">
                                                                <a href="<?= base_url('kredit/exportkredit/all')?>"  type="submit" id="btnexportkreditao" class="btn btn-block btn-success" onclick="">Export</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>                
                    </div>
                </div>




        </div>
    </div>
</div>



