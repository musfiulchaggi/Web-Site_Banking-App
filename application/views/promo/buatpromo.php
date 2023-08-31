 <!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark text-center"><?= $title ?></h1>
    
    <?php echo $this->session->flashdata('message'); ?>

    <div class="row">
        <div class="col-6" id="mdltambahpromo">
                 <div class="shadow-sm jumbotron jumbotron-fluid py-3 ">
                    <div class="col text-center mt-0 pt-0 mb-3">
                            <h3> Input Data Promo Kredit</h3>
                        </div>
                    <div class="container ">
                        
                        <div class="row justify-content-center">
                            <div class="col">
                                <!-- bikin form dulu file (action, method, enctype="multipart")-->
                                <?= form_open_multipart('promo/promokredit') ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Kredit</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control text-center" id="nama_kredit" name="nama_kredit" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Bunga (persen)</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control text-center" id="jumlah_bunga_persen" name="jumlah_bunga_persen" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Total Angsuran (bulan)</label>
                                    <div class="col-sm-8 ">
                                        
                                        <select class="form-control" name="total_angsuran_bulan" id="total_angsuran_bulan" required>
                                            <option value="" selected disabled="">-Pilih Jumlah Angsuran-</option>
                                            <option value="6" >6 Bulan</option>
                                            <option value="12" >12 Bulan</option>
                                            <option value="24" >24 Bulan</option>
                                        </select>
                                        <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Biaya Admin (persen)</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control text-center" id="admin" name="admin" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Denda (persen)/bulan</label >
                                    <div class="col-sm-8 ">
                                        <input type="text" class="form-control text-center" id="denda" name="denda" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan Promo</label >
                                    <div class="col-sm-8 ">
                                        <textarea type="text" class="form-control" id="keterangan_jenis_kredit" placeholder="Text Penawaran" name="keterangan_jenis_kredit" rows="2"></textarea>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Url Gambar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="urlgambar" name="urlgambar" value="" >
                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">Gambar Penawaran</div>
                                    <div class="col-sm-8">
                                        <div class="row justify-content-end">
                                            <!-- <div class="col-sm-3">
                                                <img src="<= base_url('assets/img/profile/') . $user['image'] ?>" class="img-thumbnail">

                                            </div> -->
                                            <div class="col-sm">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="gambarpenawaran" name="gambarpenawaran">
                                                    <label class="custom-file-label" for="gambarpenawaran">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Dimulai</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" data-date="09/07/2023" value="" type="date" name="tgl_penawaran" id="tgl_penawaran" placeholder="-">

                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Berakhir</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" data-date="09/07/2023" value="" type="date" name="tgl_berakhir" id="tgl_berakhir" placeholder="-">

                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('tgl_berakhir', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Text Penawaran</label>
                                    <div class="col-sm-12">
                                        <textarea type="text" class="form-control" id="text_penawaran" placeholder="Text Penawaran" name="text_penawaran" rows="2"></textarea>
                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                    </div>
                                </div>

                                <!-- mangakali bootstrap row rata kanan justify-content-end-->
                                <div class="form-group row justify-content-end mt-3">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-sm btn-primary btn-block" id="btnbuatpromo" onclick="">Buat Promo</button>
                                    </div>

                                </div>
                            </div>
                            <?= form_close()?>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-6">
                    <!-- iframe preview email -->

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9">
                                    <span class="align-middle text-dark" style="font-size:medium;"><strong>
                                        Preview Email Penawaran
                                    </strong></span> 
                                </div>

                                <div class="col-3 text-right">
                                    <button class="btn btn-success " id="btnrefresh"> Refresh</button>
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
        </div>
    </div>

   


        
<!-- card daftar promo -->
<div class="col text-center p-0" id="cardDaftarPembayaran">
        <div class="shadow card mb-5 p-0 ">
        <div class="card-header bg-primary"> 
                    <h3 class="text-light">Daftar Promo Kredit</h3>
        </div>
        
        
        <div class="card-body">    
            <div class="row">
                
                <?php foreach ($promoKredit as $br) : ?>

                    <div class="col-4 my-2">

                        <div class="card-daftar-promo shadow-sm card" style="width: 100%;">
                        <div class="card-header bg-success">
                            <h3 class="text-light"><?= date('F',$br['tgl_berakhir'])?></h3> 
                        </div>
                        <a href="<?= base_url('/assets/img/promo_kredit/'.$br['gambar_penawaran']) ?>" target="_blank">
                            <img class="card-img-top" src="<?= base_url('/assets/img/promo_kredit/'.$br['gambar_penawaran']) ?>" alt="">
                        </a>
                            <div class="card-body">
                                    <h3 class="card-title text-dark"><?= $br['nama_kredit']?></h3>
                                    <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-size: small;">Bunga Kredit</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control text-center"  value="<?= $br['jumlah_bunga_persen']?> %" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-size: small;">Jumlah Angsuran</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control text-center"  value="<?= $br['total_angsuran_bulan']?> bulan" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-size: small;">Tgl. Dimulai</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control text-center"  value="<?= date('d/M/Y',$br['tgl_penawaran'])?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4" style="font-size: small;">Tgl. Berakhir</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" class="form-control text-center"  value="<?= date('d/M/Y',$br['tgl_berakhir'])?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col">
                                            <button class="btneditpromo btn btn-primary btn-sm btn-block " data-toggle="modal" data-target="#mdleditpromo" 
                                            data-id_penawaran="<?= $br['id_penawaran'] ?>" data-id_jenis_kredit="<?= $br['id_jenis_kredit'] ?>" 
                                            data-jumlah_bunga_persen="<?= $br['jumlah_bunga_persen'] ?>" 
                                            data-total_angsuran_bulan="<?= $br['total_angsuran_bulan'] ?>" 
                                            data-nama_kredit="<?= $br['nama_kredit'] ?>" data-urlgambar='<?= $br['urlgambar'] ?>' 
                                            data-text_penawaran="<?= $br['text_penawaran'] ?>" 
                                            data-admin="<?= $br['admin'] ?>" data-denda="<?= $br['denda_kredit'] ?>" 
                                            data-keterangan_jenis_kredit="<?= $br['keterangan_jenis_kredit'] ?>" 
                                            data-gambar_penawaran="<?= $br['gambar_penawaran'] ?>" 
                                            data-tgl_berakhir="<?= date('Y-m-d',$br['tgl_berakhir']) ?>" data-tgl_penawaran="<?= date('Y-m-d',$br['tgl_penawaran'] )?>"
                                            >Edit</button>        
                                    
                                            <button class="delpromo btn btn-danger btn-sm btn-block " data-toggle="modal" data-target="#mdlhapuspromo" 
                                            data-id_penawaran="<?= $br['id_penawaran'] ?>" onclick="$('#mdlhapuspromo #id_penawaran').attr('value',$(this).data('id_penawaran'))">Hapus</button>

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>


                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
    </div>
    <!-- /.container-fluid -->
</div>

<!-- End of Main Content -->

<!-- modal edit promo kredit -->
<div class="modal fade" id="mdleditpromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
                <div class="modal-header justify-content-center bg-primary">
                    <h3 class="text-light">Edit Promo Kredit</h3>
                </div>
            
          <div class="row mt-3 p-3">
                <div class="col-6" id="inputeditpromo">
                        
                        <div class="container p-0">
                                
                            <div class="shadow-sm jumbotron jumbotron-fluid p-3 ">
                                <div class="row justify-content-center">
                                    <div class="col">

                                        <!-- bikin form dulu file (action, method, enctype="multipart")-->
                                        <?= form_open_multipart('promo/promoKredit', ['id', 'formeditpromokredit']) ?>

                                        <div class="form-group row " hidden>
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Id Penawaran</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="id_penawaran_edit" name="id_penawaran" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row " hidden>
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Id Jenis Kredit</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="id_jenis_kredit_edit" name="id_jenis_kredit" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Kredit</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="nama_kredit_edit" name="nama_kredit" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Bunga (persen)</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="jumlah_bunga_persen_edit" name="jumlah_bunga_persen" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Total Angsuran (bulan)</label>
                                            <div class="col-sm-8 ">
                                                
                                                <select class="form-control" name="total_angsuran_bulan" id="total_angsuran_bulan_edit" required>
                                                    <option value="" selected disabled="">-Pilih Jumlah Angsuran-</option>
                                                    <option value="6" >6 Bulan</option>
                                                    <option value="12" >12 Bulan</option>
                                                    <option value="24" >24 Bulan</option>
                                                </select>
                                                <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Biaya Admin (persen)</label>
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="admin_edit" name="admin" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Denda (persen)/bulan</label >
                                            <div class="col-sm-8 ">
                                                <input type="text" class="form-control text-center" id="denda_edit" name="denda" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan Promo</label >
                                            <div class="col-sm-8 ">
                                                <textarea type="text" class="form-control" id="keterangan_jenis_kredit_edit" placeholder="Text Penawaran" name="keterangan_jenis_kredit" rows="2"></textarea>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Url Gambar</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="urlgambar_edit" name="urlgambar" value="" >
                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">Gambar Penawaran</div>
                                            <div class="col-sm-8">
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-3">
                                                        <img src="" class="img-thumbnail" id="gambarpenawaranpreviewedit">

                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="gambarpenawaran_edit" name="gambarpenawaran">
                                                            <label class="custom-file-label" for="gambarpenawaran">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Dimulai</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" data-date="09/07/2023" value="" type="date" name="tgl_penawaran" id="tgl_penawaran_edit" placeholder="-">

                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Berakhir</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" data-date="09/07/2023" value="" type="date" name="tgl_berakhir" id="tgl_berakhir_edit" placeholder="-">

                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('tgl_berakhir', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Text Penawaran</label>
                                            <div class="col-sm-12">
                                                <textarea type="text" class="form-control" id="text_penawaran_edit" placeholder="Text Penawaran" name="text_penawaran_edit" rows="2"></textarea>
                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                                            </div>
                                        </div>

                                        <!-- mangakali bootstrap row rata kanan justify-content-end-->
                                        <div class="form-group row mt-3">
                                                <div class="col text-right">    
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditpromokredit')[0].reset();">Cancel</button>
                                                        <button type="submit" class="btn btn-primary" id="btneditpromo" onclick="">Save</button>
                                                </div>
                                        </div>
                                    </div>
                                    <?= form_close()?>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-6">
                            <!-- iframe preview email -->

                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9">
                                            <span class="align-middle text-dark" style="font-size:medium;"><strong>
                                                Preview Email Penawaran
                                            </strong></span> 
                                        </div>

                                        <div class="col-3 text-right">
                                            <button class="btn btn-success " id="btnrefresh_edit"> Refresh</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- 16:9 aspect ratio -->
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <iframe class="embed-responsive-item" src="" id="iframepreview_edit">

                                        </iframe>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- modal hapus promo kredit -->
<div class="modal fade" id="mdlhapuspromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Delete Promo Kredit</h5>
            </div>
            <?= form_open_multipart('promo/deletePenawaran', ['id' => 'formhapusjmn']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_penawaran" name="id_penawaran" value="" hidden>
                    <h5 class="modal-title text-dark" id="">Apakah anda yakin ingin menghapus Promo ini?</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formhapusjmn')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>
<!-- belum mengajukan bisa mengajukan
kalau sudah mengajukan, tidak bisa mengajukan
atau punya kredit aktif tidak bisa mengajukan -->