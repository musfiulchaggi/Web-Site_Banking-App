<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- info kredit -->
    <div class="row">
        <div class="col">
    
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample" id="collapsejeniskredit" class="d-block card-header py-3 bg-primary" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-light">Jenis Kredit <span class="text-warning">BPR Amira</span></h6>
                    </a>
                        <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCardExample" style="">
                        <div class="card-body">
                            <!-- isi jenis kredit -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="card shadow">
                                        <div class="card-header bg-primary text-light">
                                            Kredit Flat (Angsuran)
                                        </div>
                                        <div class="card-body bg-info text-light">
                                            <h5 class="card-title"><b>Angsuran Pokok plus Bunga </b> </h5>
                                            <p class="card-text">Dengan pilihan jangka waktu mengangsur selama 6 bulan, 12 bulan, dan 24 bulan.</p>
                                            <p class="card-text">Dengan bunga sebesar 1.75 % per bulan.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card shadow">
                                        <div class="card-header bg-primary text-light">
                                            Kredit Bunga - Bunga
                                        </div>
                                        <div class="card-body bg-info text-light">
                                            <h5 class="card-title"><b>Angsuran Bunga </b> </h5>
                                            <p class="card-text">Dengan membayar bunga saja selama 6 bulan, ditambah pembayaran pokok pada angsuran bulan terakhir.</p>
                                            <p class="card-text">Dengan bunga sebesar 2.75 % per bulan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>


    <!-- informasi pengajuan kredit -->
    <?php if(!empty($pengajuanKredit) && $pengajuanKredit[0]['keterangan_pengajuan'] != 0 && $pengajuanKredit[0]['keterangan_pengajuan'] != 1 && $pengajuanKredit[0]['keterangan_pengajuan'] != 2){?>
    <div class="shadow rounded jumbotron jumbotron-fluid">
        <div class="container">
            <?php 
                if($pengajuanKredit[0]['keterangan_pengajuan'] == 3){
                    echo '<div class="alert alert-success" role="alert">
                                <span>Pengajuan kredit anda telah memenuhi syarat, mohon untuk datang ke kantor BPR Amira, serta membawa seluruh bukti yang dikirimkan sebelumnya, untuk proses validasi dan realisasi kredit.</span>
                            </div>';
                }elseif($pengajuanKredit[0]['keterangan_pengajuan'] == 4){
                    echo '<div class="alert alert-danger" role="alert">
                            <span>Mohon maaf, pengajuan kredit anda ditolak, dikarenakan tidak sesuai dengan ketentuan yang ada di BPR Amira.</span>
                        </div>';
                }        
                ?>

        </div>
    </div>
    <?php }?>

    <?php 
    if($kreditActive == null && $kreditDiajukan == null)
    {?>
    <div class="row">
        <div class="col">
            <button  class="btn btn-primary btn-icon-split" data-target="#mdlTambahPgjKredit" data-toggle="modal" onclick='$("#dftrkendaraantbl").attr("hidden",true);'>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambahkan Pengajuan Kredit</span>
            </button>
        </div>
    </div>
    <?php }
    ?>
    
    <div class="card boder-primary mt-4">

        <div class="card-body ">
            <table id="tblNasabah" class="table thead-dark table-striped table-bordered table-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Nasabah</th>
                        <th>Jenis Kredit</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Tanggal Pengajuan</th> 
                        <th>Keterangan Pengajuan</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pengajuanKredit as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['jumlah_pinjaman'],0,',','.'); ?></td>
                            <!-- <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;"> 
                                <a href="<?= base_url('assets/img/pengajuan/' . $br['foto_ktp']) ?>" target="blank">
                                <img class="img-fluid" src="<?= base_url('assets/img/pengajuan/' . $br['foto_ktp']) ?>" style="width:50px"></a>
                            </td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;"> 
                                <a href="<?= base_url('assets/img/pengajuan/' . $br['foto_kk']) ?>" target="blank">
                                <img class="img-fluid" src="<?= base_url('assets/img/pengajuan/' . $br['foto_kk']) ?>" style="width:50px"></a>
                            </td> -->

                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['tgl_pengajuan']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> 
                            <?php if($br['keterangan_pengajuan'] == 1) { ?> Diterima <?php } else if($br['keterangan_pengajuan'] == 2) { ?> Ditolak 
                            <?php } else if($br['keterangan_pengajuan'] == 3) { ?> Data Valid <?php } else if($br['keterangan_pengajuan'] == 4 ) { ?> Data Tidak Valid 
                            <?php } else { ?> Menunggu Konfirmasi <?php }?>   
                            
                            </td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <?php
                                    if($br['keterangan_pengajuan'] == 0 || $br['keterangan_pengajuan'] == 4) { ?>

                                        <button class="editPlyKredit btn btn-warning btn-sm btn-block " data-toggle="modal" data-target="#mdlEditPengajuanKredit" 
                                        data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>"
                                        data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                        data-jumlah-pinjaman="<?= $br['jumlah_pinjaman'] ?>" data-foto-ktp="<?= $br['foto_ktp'] ?>"
                                        data-foto-kk="<?= $br['foto_kk'] ?>" data-tgl-pengajuan="<?= $br['tgl_pengajuan'] ?>"
                                        data-keterangan-pengajuan="<?= $br['keterangan_pengajuan'] ?>"
                                        onclick='$("#dftrkendaraantbl2").attr("hidden",true);'>Edit</button>  

                                        <button class="hapusPlyKredit btn btn-danger btn-sm btn-block " data-toggle="modal" data-target="#mdlHapusPengajuanKredit" 
                                        data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>"
                                        data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                        data-jumlah-pinjaman="<?= $br['jumlah_pinjaman'] ?>" data-foto-ktp="<?= $br['foto_ktp'] ?>"
                                        data-foto-kk="<?= $br['foto_kk'] ?>" data-tgl-pengajuan="<?= $br['tgl_pengajuan'] ?>"
                                        data-keterangan-pengajuan="<?= $br['keterangan_pengajuan'] ?>"
                                        onclick='$("#mdlHapusPengajuanKredit #id_pengajuan").attr("value",$(this).data("id-pengajuan"));'>Hapus</button>

                                    <?php } else if ($br['keterangan_pengajuan'] == 1) { ?>
                                        <button class="detailPlyKredit btn btn-success btn-sm btn-block " data-toggle="modal" data-target="#mdldetailPengajuanKredit" 
                                        data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>"
                                        data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                        data-jumlah-pinjaman="<?= $br['jumlah_pinjaman'] ?>" data-foto-ktp="<?= $br['foto_ktp'] ?>"
                                        data-foto-kk="<?= $br['foto_kk'] ?>" data-tgl-pengajuan="<?= $br['tgl_pengajuan'] ?>"
                                        data-keterangan-pengajuan="<?= $br['keterangan_pengajuan'] ?>">Details</button>
                                    <?php }  else {?>
                                        <button class="detailPlyKredit btn btn-warning btn-sm btn-block " data-toggle="modal" data-target="#mdldetailPengajuanKredit" 
                                        data-id-pengajuan="<?= $br['id_pengajuan'] ?>" data-id-nasabah="<?= $br['id_nasabah'] ?>"
                                        data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                        data-jumlah-pinjaman="<?= $br['jumlah_pinjaman'] ?>" data-foto-ktp="<?= $br['foto_ktp'] ?>"
                                        data-foto-kk="<?= $br['foto_kk'] ?>" data-tgl-pengajuan="<?= $br['tgl_pengajuan'] ?>"
                                        data-keterangan-pengajuan="<?= $br['keterangan_pengajuan'] ?>"> Details</button>
                                    <?php }
                                    ?>
                                    
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



<!-- modal Tambah Pengajuan Kredit -->
<div class="modal fade" id="mdlTambahPgjKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center bg-secondary text-light">
                    <h3>Tambahkan Pengajuan Kredit</h3>
                </div>
                <!-- bikin form dulu file (action, method, enctype="multipart")-->
                <?= form_open_multipart('pelayanan/tambahPengajuanKredit',['id'=>'formtambahpelayanankredit']) ?>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="id_nasabah" class="col-sm-4 col-form-label  ">ID Nasabah</label>
                        <div class="col-sm-8 ">
                            <input type="text" class="form-control disabled" id="id_nasabah" name="id_nasabah" value="<?php echo $nasabah['id_nasabah'];?>" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('id_nasabah', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_jenis_kredit" class="col-sm-4 col-form-label  ">ID Jenis Kredit</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="id_jenis_kredit" id="id_jenis_kredit" required>
                                <option value="" selected disabled="">-Pilih Jenis Kredit-</option>
                                <?php foreach ($jenisKredit as $row ) {?>
                                    <option value="<?php echo $row['id_jenis_kredit'] ?>" 
                                    <?php if($row['status'] == "1"){
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

                            <div class="card text-center">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#" id="navkendaraan">Kendaraan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" id="navshm">SHM/SHGB</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                        <!-- isi dari form jaminan disini -->
                                    <!-- awal kendaraan -->
                                    <div class="col" id="inputjaminankendaraan">
                                        <div class="row">
    
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="pabrikan" name="pabrikan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Pabrikan</option>
                                                    <option value="honda" >Honda</option>
                                                    <option value="yamaha" >Yamaha</option>
                                                    <option value="kawasaki" >Kawasaki</option>
                                                    <option value="suzuki" >Suzuki</option>
                                                </select>
                                                <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="jenis_kendaraan" name="jenis_kendaraan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Jenis Kendaraan</option>
                                                    <option value="2" >Sepeda Motor</option>
                                                    <option value="4" >Mobil</option>
                                                    </select>
                                                <!-- <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"> -->
                                            </div>
                                            <div class="col-sm-4">
                    
                                                <input type="text" class="form-control" id="merk" name="merk" placeholder="Nama Kendaraan">
                                            </div>
                                            <div class="col-sm-2">
                    
                                                <button type="button" class="btn btn-success btn-block" id="btn_cari" name="btn_cari">
                                                    <span>
                                                        <i class="fas fa-search"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <!-- ini yang dikirim -->
                                                <input type="text" class="form-control" id="id_jaminan" name="id_jaminan" value="" hidden> 
                                                <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" value="" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="pabrikan" class="col-form-label  text-left">Taksasi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                
                                                <input type="text" class="form-control bg-warning text-light" id="taksasi" name="taksasi" value="" readonly>
                                            </div>
                                        </div>
    
                                        <div class="row justify-content-end" id="dftrkendaraantbl">
                                            <div class="col mt-2">
                                                <div class="shadow jumbotron p-2">
                                                    <div class="table-renponsive overflow-auto rounded" id="tbl_daftar_jaminan" style=" max-height: 250px;">
                
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
    
                                        </div>
                                        
    
                                    </div>
                                    <!-- akhir kendaraan -->

                                     <!-- awal SHM/SHGB -->
                                    <div class="col" id="inputjaminanshm" hidden>

                                            <div class="row mt-3">
                                                <div class="col-sm-6 text-left">
                                                    <!-- ini yang dikirim -->
                                                    <input type="text" class="form-control" id="id_jaminan_shm" name="id_jaminan_shm" value="" hidden> 
                                                    <label for="pabrikan" class="col-form-label  text-left">Taksasi Per/ 1 m<sup>2</sup></label>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    
                                                    <input type="text" class="form-control" id="taksasishm" name="taksasishm" value="" readonly>
                                                </div>
                                                
                                            </div>
        
                                            <div class="row mt-3" id="">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Input Luas Tanah (m<sup>2</sup>)</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control" id="luastanah" name="luastanah" value="" >
                                                            
                                                </div>
                                            
        
                                            </div>

                                            <div class="row mt-3" id="makspinjamanshm">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Max. Pinjaman</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control bg-warning text-light" id="inputmaksshm" name="inputmaksshm" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                                            
                                                </div>
                                            
        
                                            </div>
                                            
                                        
    
                                    </div>
                                    <!-- akhir SHM/SHGB -->
                                </div>
                            </div>

                        </div>


                        
                    </div>

                    <div class="form-group row">
                        <label for="jumlah_pinjaman" class="col-sm-4 col-form-label ">Jumlah Pinjaman</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="jumlah_pinjaman" name="jumlah_pinjaman" data-maks="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('jumlah_pinjaman', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-form-label ">Foto Jaminan(Agunan)</div>
                        <div class="col-sm-8">
                                <!-- multipart -->
                                <div class="controls multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_jaminan" name="foto_jaminan[]" type="file">
                                                    <label id="foto_jaminan" class="custom-file-label" for="foto_jaminan">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <!-- <input type="file" class="custom-file-input" id="foto_jaminan" name="foto_jaminan"> -->
                                
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_surat_kepemilikan" class="col-sm-4 col-form-label" id="labelnomor">Nomor BPKB</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nomor_surat_kepemilikan" name="nomor_surat_kepemilikan">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('nomor_surat_kepemilikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="atas_nama" class="col-sm-4 col-form-label" id="labelatasnama">Atas Nama (BPKB)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="atas_nama" name="atas_nama">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('atas_nama', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dimiliki_tahun" class="col-sm-4 col-form-label ">Dimiliki Tahun</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="dimiliki_tahun" name="dimiliki_tahun">
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
                            <input type="text" class="form-control" id="harga_beli" name="harga_beli" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('harga_beli', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diperoleh_dengan" class="col-sm-4 col-form-label  ">Diperoleh Dengan</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="diperoleh_dengan" id="diperoleh_dengan" required>                           
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
                            <div class="col px-0" id="suratkendaraan">
                                <div class="col">
                                    <span>BPKB Kendaraan</span>
                                </div>
                                <div class="controls2 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_bpkb" name="foto_bpkb[]" type="file">
                                                    <label id="foto_bpkb" class="custom-file-label" for="foto_bpkb">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add2" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <div class="col">
                                    <span>STNK Kendaraan</span>
                                </div>
                                <div class="controls3 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_stnk" name="foto_stnk[]" type="file">
                                                    <label id="foto_stnk" class="custom-file-label" for="foto_stnk">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add3" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>

                            </div>
                            <div class="col px-0" id="suratshm" hidden>
                                <div class="col">
                                    <span>SHM/SHGB</span>
                                </div>
                                <div class="controls7 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_shm" name="foto_shm[]" type="file">
                                                    <label id="foto_bpkb" class="custom-file-label" for="foto_shm">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add7" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">

                 
                    <!-- mangakali bootstrap row rata kanan justify-content-end-->
                    <div class="col-4">

                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" onclick="$('#formtambahpelayanankredit')[0].reset();">Close</button>

                            </div>
                            <div class="col">

                                <button type="submit" class="btn btn-success btn-block text-light" onclick="$('#mdlAjukanKredit #id_jenis_kredit').prop('disabled', false);"><b>Tambahkan</b></button>
                            </div>
                        
                        </div>
                    </div>

                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengajuan Kredit-->
<div class="modal fade" id="mdlEditPengajuanKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center bg-secondary text-light">
                    <h3>Edit Pengajuan Kredit</h3>
                </div>
                <!-- bikin form dulu file (action, method, enctype="multipart")-->
                <?= form_open_multipart('pelayanan/tambahPengajuanKredit',['id'=>'formeditpelayanankreditedit']) ?>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-8 ">
                            <input type="text" class="form-control disabled" id="id_pengajuan" name="id_pengajuan" value="" hidden>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_nasabah" class="col-sm-4 col-form-label  ">ID Nasabah</label>
                        <div class="col-sm-8 ">
                            <input type="text" class="form-control disabled" id="id_nasabah" name="id_nasabah" value="<?php echo $nasabah['id_nasabah'];?>" readonly>
                            <!-- menampilkan pesan eror -->
                            <?= form_error('id_nasabah', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_jenis_kredit" class="col-sm-4 col-form-label  ">ID Jenis Kredit</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="id_jenis_kredit" id="id_jenis_kredit" required>
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
                                            <a class="nav-link active" href="#" id="navkendaraanedit">Kendaraan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" id="navshmedit">SHM/SHGB</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                        <!-- isi dari form jaminan disini -->
                                    <!-- awal kendaraan -->
                                    <div class="col" id="inputjaminankendaraanedit">
                                        <div class="row">
    
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="pabrikan2" name="pabrikan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Pabrikan</option>
                                                    <option value="honda" >Honda</option>
                                                    <option value="yamaha" >Yamaha</option>
                                                    <option value="kawasaki" >Kawasaki</option>
                                                    <option value="suzuki" >Suzuki</option>
                                                </select>
                                                <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="custom-select" id="jenis_kendaraan2" name="jenis_kendaraan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                                                    <option>Jenis Kendaraan</option>
                                                    <option value="2" >Sepeda Motor</option>
                                                    <option value="4" >Mobil</option>
                                                    </select>
                                                <!-- <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"> -->
                                            </div>
                                            <div class="col-sm-4">
                    
                                                <input type="text" class="form-control" id="merk2" name="merk" placeholder="Nama Kendaraan">
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
                                                <input type="text" class="form-control" id="id_jaminan2" name="id_jaminan" value="" hidden> 
                                                <input type="text" class="form-control" id="nama_kendaraan2" name="nama_kendaraan" value="" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="pabrikan" class="col-form-label  text-left">Taksasi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                
                                                <input type="text" class="form-control bg-warning text-light" id="taksasi2" name="taksasi" value="" readonly>
                                            </div>
                                        </div>
    
                                        <div class="row justify-content-end" id="dftrkendaraantbl2">
                                            <div class="col mt-2">
                                                <div class="shadow jumbotron p-2">
                                                    <div class="table-renponsive overflow-auto rounded" id="tbl_daftar_jaminan2" style=" max-height: 250px;">
                
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
    
                                        </div>
                                        
    
                                    </div>
                                    <!-- akhir kendaraan -->

                                     <!-- awal SHM/SHGB -->
                                    <div class="col" id="inputjaminanshmedit" hidden>

                                            <div class="row mt-3">
                                                <div class="col-sm-6 text-left">
                                                    <!-- ini yang dikirim -->
                                                    <input type="text" class="form-control" id="id_jaminan_shm2" name="id_jaminan_shm" value="" hidden> 
                                                    <label for="pabrikan" class="col-form-label  text-left">Taksasi Per/ 1 m<sup>2</sup></label>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    
                                                    <input type="text" class="form-control" id="taksasishm2" name="taksasishm" value="" readonly>
                                                </div>
                                                
                                            </div>
        
                                            <div class="row mt-3" id="">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Input Luas Tanah (m<sup>2</sup>)</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control" id="luastanah2" name="luastanah" value="" >
                                                            
                                                </div>
                                            
        
                                            </div>

                                            <div class="row mt-3" id="makspinjamanshm2">

                                                <div class="col-sm-6 text-left">
    
                                                    <label for="pabrikan" class="col-form-label  text-left">Max. Pinjaman</label>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                     <input type="text" class="form-control bg-warning text-light" id="inputmaksshm2" name="inputmaksshm" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly>
                                                            
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
                            <input type="text" class="form-control" id="jumlah_pinjaman" name="jumlah_pinjaman" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('jumlah_pinjaman', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-form-label ">Foto Jaminan(Agunan)</div>
                        <div class="col-sm-8">
                                <!-- multipart -->
                                <div class="controls4 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_jaminan" name="foto_jaminan[]" type="file">
                                                    <label id="foto_jaminan" class="custom-file-label" for="foto_jaminan">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add4" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <!-- <input type="file" class="custom-file-input" id="foto_jaminan" name="foto_jaminan"> -->

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_jaminan">

                                                                                   

                                        </div>
                                    </div>
                                </div>
                                
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_surat_kepemilikan" class="col-sm-4 col-form-label " id="labelnomoredit">Nomor BPKB</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nomor_surat_kepemilikan" name="nomor_surat_kepemilikan" value="">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('nomor_surat_kepemilikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="atas_nama" class="col-sm-4 col-form-label" id="labelatasnamaedit">Atas Nama (BPKB)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="atas_nama" name="atas_nama" value="">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('atas_nama', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dimiliki_tahun" class="col-sm-4 col-form-label ">Dimiliki Tahun</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="dimiliki_tahun" name="dimiliki_tahun">
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
                            <input type="text" class="form-control" id="harga_beli" name="harga_beli" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="">
                            <!-- menampilkan pesan eror -->
                            <?= form_error('harga_beli', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diperoleh_dengan" class="col-sm-4 col-form-label  ">Diperoleh Dengan</label>
                        <div class="col-sm-8 ">
                            <select class="form-control" name="diperoleh_dengan" id="diperoleh_dengan" required>                           
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
                            <div class="col px-0" id="suratkendaraanedit">
                                <div class="col px-0">
                                    <span class="text-dark">BPKB Kendaraan</span>
                                </div>
                                <div class="controls5 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_bpkb" name="foto_bpkb[]" type="file">
                                                    <label id="foto_bpkb" class="custom-file-label" for="foto_bpkb">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add5" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_bpkb">

                                                                                   

                                        </div>
                                    </div>
                                </div>
                                <div class="col px-0">
                                    <span class="text-dark">STNK Kendaraan</span>
                                </div>
                                <div class="controls6 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_stnk" name="foto_stnk[]" type="file">
                                                    <label id="foto_stnk" class="custom-file-label" for="foto_stnk">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add6" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_stnk">
                                           

                                                                                  
                                        </div>

                                    </div>
                                </div>

                                

                            </div> 

                            <!-- awal surat shm -->
                            <div class="col px-0" id="suratshmedit">
                                <div class="col">
                                    <span>SHM/SHGB</span>
                                </div>
                                <div class="controls8 multiinput" >
                                            <div class="entry input-group upload-input-group">
                                                <div class="col-sm-10">

                                                    <input class="form-control custom-file-input" id="foto_shm" name="foto_shm[]" type="file">
                                                    <label id="foto_bpkb" class="custom-file-label" for="foto_shm">Choose file</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-upload btn-success btn-add8" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                </div>
                                            </div>

                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row" id="daftar_foto_shm">
                                        
                                        
                                        </div>

                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                    
                    <div class="col px-0">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditpelayanankreditedit')[0].reset();">Close</button>
                            <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Save</button>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- modal Detail Pengajuan Kredit -->
<div class="modal fade" id="mdldetailPengajuanKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header justify-content-center bg-secondary text-light">
                    <h3>Detail Pengajuan Kredit</h3>
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
<!-- modal hapus foto surat -->
<div class="modal" id="mdlhapusfotosurat" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-light text-center">Hapus Foto Surat Kendaraan</h5>
      </div>
      <div class="modal-body">
        <h5 class="modal-title">Hapus foto ini?</h5>
      </div>

                <div class="form-group row" hidden>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control disabled" id="id_daftar_foto_surat_kepemilikan" name="id_daftar_foto_surat_kepemilikan" value="" readonly>
                        <!-- menampilkan pesan eror -->
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-sm-8 " id="detailfotosurat">
                       
                        <!-- menampilkan pesan eror -->
                    </div>
                </div>

       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" id="btnhapusfotosurat">Hapus</button>
      </div>

    </div>
  </div>
</div>

<!-- modal hapus foto jaminan -->
<div class="modal" id="mdlhapusfotojaminan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-light text-center">Hapus Foto Jaminan (Agunan)</h5>
      </div>
      <div class="modal-body">
        <h5 class="modal-title">Hapus foto ini?</h5>
      </div>

      
                <div class="form-group row" hidden>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control disabled" id="id_daftar_foto_jaminan" name="id_daftar_foto_jaminan" value="" readonly>
                        <!-- menampilkan pesan eror -->
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-sm-8 " id="detailfotojaminan">
                       
                        <!-- menampilkan pesan eror -->
                    </div>
                </div>

       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" id="btnhapusfotojaminan">Hapus</button>
      </div>

    </div>
  </div>
</div>

<!-- modal hapus pengajuan kredit -->
<div class="modal fade" id="mdlHapusPengajuanKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Delete Pengajuan Kredit</h5>
            </div>
            <?= form_open_multipart('pelayanan/deletepengajuan', ['id' => 'formhapuspengajuan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_pengajuan" name="id_pengajuan" value="" hidden>
                    <h5 class="modal-title text-dark" id="">Apakah anda yakin ingin menghapus pengajuan kredit?</h5>
                </div>
                <!-- <div class="form-group">
                        <input type="hidden" name="kode" >
                        <select class="form-control" name="status" required>
                        <option value="" selected disabled="">-Pilih Status-</option>
                        <option value="1" >Online</option>
                        <option value="2" >Offline</option>
                        </select>
				</div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formhapusao')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>


</div>
