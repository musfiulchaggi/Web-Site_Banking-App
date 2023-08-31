<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
    

    <div class="shadow-sm border-left-primary card boder-primary mt-4" style="max-height: 500px;">

        <div class="card-header bg-primary text-light">
            <div class="row">

                <div class="col-6">
                    <span class="align-middle">Daftar Nasabah Lancar - Last Updated at ( <span class="text-center text-warning" id="spanupdateat"><?php 
                            foreach($nasabahpromo as $ktgr){
                            if(!empty($ktgr['update_kategori_at']))
                            { 
                                echo date('d-F-Y',$ktgr['update_kategori_at']); 
                            }}?></span> )</span>
                    
                </div>
                <div class="col-6 text-right">
                    <a href="" class=" btn btn-success btn-icon-split" id="btngeneratenasabahpromo">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-robot" style="color: white;"></i>
                                        </span>
                                        <span class="text">Generate Kategori</span>
                    </a>
                        
                </div>
            </div>
        </div>
        
        
        <div class="card-body overflow-auto">
            
            <table id="tblNasabah" class="table thead-dark table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Nama Nasabah</th>
                        <th>Gender</th>
                        <th>Income</th>
                        <th>Status</th>
                        <th>Pendidikan</th>
                        <!-- <th>Pengeluaran</th> -->
                        <th>Nasabah (sejak)</th>
                        <th>Skor Kredit</th>
                        <th>Confidence</th>
                        <th>Kategori Nasabah</th>
                        <!-- <th>Action</th> -->

                    </tr>
                </thead>
                <tbody id="tbodynasabahkirimpromo">
                    <?php $no = 1;
                    foreach ($nasabahpromo as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_nasabah'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['gender'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=  number_format($br['income'],0,',','.');  ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['status'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['pendidikan'] ?></td>
                            <!-- <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['pengeluaran'],0,',','.'); ?></td> -->
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('M-Y',$br['date_created']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['kemacetan_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['confidence'] ?></td>
                            <?php if($br['kategori_nasabah'] == 1) { ?> 
                                <td class="font-weight-normal text-light text-center align-middle" style="background-color:#4dff4d">Lancar</td>    
                            <?php }elseif($br['kategori_nasabah'] == 0){ ?> 
                                <td class="font-weight-normal text-light text-center align-middle" style="background-color:#fcf403">Tidak Lancar</td>    
                            <?php } else { ?> 
                                <td class="font-weight-normal bg-dark text-light text-center align-middle"  style="font-size:smaller;">tdk memiliki transaksi</td>    

                            <?php }?>
                            <!-- <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <button class="editNsb btn btn-warning btn-sm " data-toggle="modal" data-target="#mdlEditNasabah" data-idnasabah="<?= $br['id_nasabah'] ?>"
                                    data-id-user="<?= $br['id_user'] ?>" data-income="<?= $br['income'] ?>" data-status="<?= $br['status'] ?>"
                                    data-pendidikan="<?= $br['pendidikan'] ?>" data-pengeluaran="<?= $br['pengeluaran'] ?>" >Edit</button>
                                </div>
                            </td> -->
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
            
        </div>
    </div>

    <div class="shadow-sm border-left-success card mt-4">
        <div class="card-header bg-success text-light">
            Daftar Promo Aktif
        </div>
        <div class="card-body">
            <div id="carouselExampleControls" class="shadow rounded bg-secondary carousel slide p-2" data-ride="carousel">
                <div class="carousel-inner">
        
                 <?php $item = 1;
                    foreach ($promoKredit as $br) : ?>
                                
                        <?php if($item ==1 )
                        { echo '<div class="carousel-item active"><div class="row px-2">';
                        }elseif($item % 4 == 0 )
                        { echo '<div class="carousel-item"><div class="row px-2">';}?>
                        
        
                            
                                
                                <div class="col-4">
                                    <div class="card" style="height: 200px;">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="card-header bg-info">
                                                    <div class="row justify-content-between">
                                                        <div class="col-9">
                                                            
                                                            <h4 class="text-light" style="font-size: large;"><?= $br['nama_kredit'] ?></h4>
                                                        </div>
                                                        <div class="col-3">
        
                                                            <button class="btnpilihpromo btn btn-sm btn-primary" 
                                                                        data-id_penawaran="<?= $br['id_penawaran'] ?>" data-id_jenis_kredit="<?= $br['id_jenis_kredit'] ?>" 
                                                                        data-jumlah_bunga_persen="<?= $br['jumlah_bunga_persen'] ?>" 
                                                                        data-total_angsuran_bulan="<?= $br['total_angsuran_bulan'] ?>" 
                                                                        data-nama_kredit="<?= $br['nama_kredit'] ?>" data-urlgambar='<?= $br['urlgambar'] ?>' 
                                                                        data-text_penawaran="<?= $br['text_penawaran'] ?>" 
                                                                        data-admin="<?= $br['admin'] ?>" data-denda="<?= $br['denda_kredit'] ?>" 
                                                                        data-keterangan_jenis_kredit="<?= $br['keterangan_jenis_kredit'] ?>" 
                                                                        data-gambar_penawaran="<?= $br['gambar_penawaran'] ?>" 
                                                                        data-tgl_berakhir="<?= date('Y-m-d',$br['tgl_berakhir']) ?>" 
                                                                        data-tgl_penawaran="<?= date('Y-m-d',$br['tgl_penawaran'] )?>" 
                                                                        onclick="$('#carddetailpromo').show()">Pilih</button>
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <img src="<?= base_url('assets/img/promo_kredit/').$br['gambar_penawaran'] ?>" class="img-fluid" alt="Thumbnail Image">
                                            </div>
                                            <div class="col-7">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0" style="font-size: medium;"><?= $br['nama_kredit'] ?></h5>
                                                    <p class="card-text" style="font-size: small;"><?= $br['keterangan_jenis_kredit'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                      
        
                            
        
                        
                    <?php $item++;
                    if($item % 4 == 0 || count($promoKredit) == $item-1 )
                        { echo '</div></div>';}?>
                        <?php endforeach; ?>
        
        
        
                </div>
                <a class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev" style="width: 30px;color: white;">
                    <span class="" aria-hidden="true" style="color: white; font-size:x-large;"><i class="fas fa-chevron-left fa-lg"></i></span>
                    <span class="sr-only"  style="color: white;">Previous</span>
                </a>
                <a class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next" style="width: 30px;color: white;">
                    <span class="" aria-hidden="true" style="color: white; font-size:x-large;"><i class="fas fa-chevron-right fa-lg"></i></span>
                    <span class="sr-only"  style="color: white;">Next</span>
                </a>
            </div>
            
        </div>
    </div>

    <div class="shadow-sm border-left-danger card mt-4" id="carddetailpromo">
        <div class="card-header bg-danger text-light">
            Detail Promo
        </div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-4">
                         <div class="shadow jumbotron jumbotron-fluid py-3 bg-warning rounded">
                            <div class="col text-center mt-0 pt-0 mb-3  text-light">
                                    <h3>Data Promo Kredit</h3>
                                </div>
                            <div class="container ">
                                
                                <div class="row justify-content-center">
                                    <div class="col" id="detailcardtampilpromo">
                                        <!-- bikin form dulu file (action, method, enctype="multipart")-->
                                        <div class="form-group row">
                                            <img src="<?= base_url('assets/img/promo_kredit/')?>" class="card-img-top" alt="" id="gambarpenawaranpreview">
                                            
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Nama Kredit</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-dark text-center" id="nama_kredit" name="nama_kredit" value="" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Bunga</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-dark text-center" id="jumlah_bunga_persen" name="jumlah_bunga_persen" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Tot. Angsuran</label>
                                            <div class="col-sm-8 ">

                                                <input type="text" class="form-control text-dark text-center" id="total_angsuran_bulan" name="total_angsuran_bulan" value="" readonly>
                                                <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Biaya Admin</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-dark text-center" id="admin" name="admin" value="" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Denda/bulan</label >
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-dark text-center" id="denda" name="denda" value="" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Keterangan Promo</label >
                                            <div class="col-sm-8 ">
                                                <textarea type="text" class="form-control text-dark" id="keterangan_jenis_kredit" placeholder="" name="keterangan_jenis_kredit" rows="2" readonly></textarea>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Tanggal Dimulai</label>
                                            <div class="col-sm-8">
                                                <input class="form-control text-dark" data-date="09/07/2023" value="" type="date" name="tgl_penawaran" id="tgl_penawaran" placeholder="-" readonly>
        
                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label text-light" style="font-size: small;">Tanggal Berakhir</label>
                                            <div class="col-sm-8">
                                                <input class="form-control text-dark" data-date="09/07/2023" value="" type="date" name="tgl_berakhir" id="tgl_berakhir" placeholder="-" readonly>
        
                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('tgl_berakhir', '<div><small class="text-danger pl-3">', '</small></div>') ?>
        
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-8">
                            <!-- iframe preview email -->
        
                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-center">
                                        <div class="col text-center">
                                            <span class="align-middle text-dark" style="font-size:medium;"><strong>
                                                Preview Email Penawaran
                                            </strong></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- 16:9 aspect ratio -->
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <iframe class="embed-responsive-item" src="" id="iframepreview">
        
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center" style="margin-top: 50px;">
                                <div class="col-4 text-center">
                                    <a href="" class=" btn btn-secondary btn-icon-split" id="btngeneratenasabahpromo" onclick="$('#carddetailpromo').hide()">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-window-close"></i>
                                        </span>
                                        <span class="text">Batal</span>
                                    </a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="" class=" btn btn-warning btn-icon-split" id="btnkirimpenawaran" data-id_penawaran="">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-paper-plane"></i>
                                        </span>
                                        <span class="text">Kirimkan Promo</span>
                                    </a>
                                </div>
                            </div>
                </div>
            </div>
            
        </div>
    </div>


    <!-- <div class="card boder-primary mt-4">
 
        <div class="card-body ">
            <table id="tblNasabah" class="table thead-dark table-striped table-bordered " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kredit</th>
                        <th>Gambar Penawaran</th>
                        <th>Tanggal Kirim</th>
                        <th>Expired Date</th>
                        <th>Angsur (bln)</th>
                        <th>Bunga (persen)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($promoKredit as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> 
                                <a href="<?= base_url('/assets/img/promo_kredit/'.$br['gambar_penawaran']) ?>" target="_blank">
                                    <img class="img img-thumbnail w-50" src="<?= base_url('/assets/img/promo_kredit/'.$br['gambar_penawaran']) ?>" alt="">
                                </a>
                            </td>
                            
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['tgl_penawaran']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['tgl_berakhir']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['total_angsuran_bulan'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['jumlah_bunga_persen'] ?></td>
                            <td class="font-weight-normal align-middle" style="color: black; font-size:smaller; text-align:center;">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <button class="mdlDeletePromo btn btn-danger btn-block " data-toggle="modal" data-target="#mdlDeletePromo" 
                                    data-id-penawaran="<?= $br['id_penawaran'] ?>">Delete</button>
                                </div>
                            </div>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div> -->

</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->

<!-- modal Tambah Mesin -->
<div class="modal fade" id="mdlTambahPrm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success" >
                <h3 style="color: white;">Tambahkan Promo Kredit</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('promo/kirimpromo') ?>
            <div class="modal-body bg-gradient-info">
                <div class="form-group row">
                    <label for="namaKredit" class="col-sm-4 col-form-label text-light ">Nama Kredit</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="namaKredit" name="namaKredit">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('namaKredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_angsuran_bulan" class="col-sm-4 col-form-label text-light ">Total Angsuran(bulan)</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="totalAngsuran" name="totalAngsuran">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('totalAngsuran', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Bunga Kredit(persen)</b></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " id="jumlahBunga" name="jumlahBunga">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlahBunga', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Teks Penawaran</b></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " id="text_penawaran" name="text_penawaran">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('text_penawaran', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Tanggal Expired</b></div>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control " id="tgl_berakhir" name="tgl_berakhir"> -->
                        <input class="form-control" data-date="09/07/2023" value="" type="date" id="tgl_berakhir" name="tgl_berakhir">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('tgl_berakhir', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Url Gambar</b></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " id="urlgambar" name="urlgambar">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlahBunga', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <label for="gambarPenawaran" class="col-sm-4 col-form-label text-light ">Gambar Promo</label>
                    <div class="col-sm-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambarPenawaran" name="gambarPenawaran">
                                    <label class="custom-file-label" for="gambarPenawaran">Choose file</label>
                                </div>
                    </div>
                </div>
                <!-- mangakali bootstrap row rata kanan justify-content-end-->
                <div class="form-group row justify-content-end">
                    <div class="col-sm-8 ">
                        <button type="submit" class="btn btn-success text-light"><b>Kirimkan ke-Nasabah Lancar</b></button>
                    </div>

                </div>
                        
            </div>
            <!-- <?= form_close() ?> -->
        </div>
    </div>
</div>

<!-- Modal Edit Mesin-->
<div class="modal fade" id="mdlEditPromoKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h5 class="modal-title text-light" id="">Edit Promo Kredit</h5>
            </div>
            <?= form_open_multipart('promo/editPromoKredit', ['id' => 'formeditpromokredit']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_penawaran" name="id_penawaran" value="" hidden>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="gambar_penawaran" style="color: black;"> <b>Gambar Penawaran</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="gambar_penawaran" name="gambar_penawaran" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="dikonfirmasi" style="color: black;"> <b>Dikonfirmasi</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="dikonfirmasi" name="dikonfirmasi" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="tgl_penawaran" style="color: black;"> <b>Tanggal Penawaran</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="tgl_penawaran" name="tgl_penawaran">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditpromokredit')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Kirim Penawaran -->
<div class="modal fade" id="mdlDeletePromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Delete Promo Kredit</h5>
            </div>
            <?= form_open_multipart('promo/deletePenawaran', ['id' => 'formpromokredit']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_penawaran" name="id_penawaran" value="" hidden>
                    <h5 class="modal-title text-dark" id="">Apakah anda yakin ingin menghapus promo kredit ini?</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formpromokredit')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>